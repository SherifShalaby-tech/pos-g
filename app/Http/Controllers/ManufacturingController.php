<?php

namespace App\Http\Controllers;

use App\Models\AddStockLine;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Grade;
use App\Models\Manufacturer;
use App\Models\Manufacturing;
use App\Models\manufacturingProduct;
use App\Models\Product;
use App\Models\ProductClass;
use App\Models\ProductStore;
use App\Models\Recipe;
use App\Models\Size;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use App\Models\Variation;
use App\Utils\ProductUtil;
use App\Utils\Util;
use Carbon\Carbon;
use Doctrine\DBAL\Exception\DatabaseDoesNotExist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ManufacturingController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;
    protected $productUtil;

    public function __construct(Util $commonUtil, ProductUtil $productUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
    }

    public function index()
    {
        $type = explode("?",\request()->getRequestUri())[1] ?? "pending";
        $manufacturings = Manufacturing::query()->where("status",$type)->latest()->get();
        return view('manufacturings.index')->with(compact(
            'manufacturings',
                    'type'
        ));
    }

    public function create()
    {
        $store_query = '';
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $po_nos = Transaction::where('type', 'purchase_order')->where('status', '!=', 'received')->pluck('po_no', 'id');
        $status_array = $this->commonUtil->getPurchaseOrderStatusArray();
        $payment_status_array = $this->commonUtil->getPaymentStatusArray();
        $payment_type_array = $this->commonUtil->getPaymentTypeArray();
        $payment_types = $payment_type_array;
        $taxes = Tax::pluck('name', 'id');
        $variation_id = request()->get('variation_id');
        $product_id = request()->get('product_id');
        $is_raw_material = request()->segment(1) == 'raw-material' ? true : false;
        $product_classes = ProductClass::orderBy('name', 'asc')->pluck('name', 'id');
        $categories = Category::whereNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        $sub_categories = Category::whereNotNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        $brands = Brand::orderBy('name', 'asc')->pluck('name', 'id');
        $units = Unit::orderBy('name', 'asc')->pluck('name', 'id');
        $colors = Color::orderBy('name', 'asc')->pluck('name', 'id');
        $sizes = Size::orderBy('name', 'asc')->pluck('name', 'id');
        $grades = Grade::orderBy('name', 'asc')->pluck('name', 'id');
        $taxes_array = Tax::orderBy('name', 'asc')->pluck('name', 'id');
        $customer_types = CustomerType::orderBy('name', 'asc')->pluck('name', 'id');
        $discount_customer_types = Customer::getCustomerTreeArray();
        $exchange_rate_currencies = $this->commonUtil->getCurrenciesExchangeRateArray(true);
        $stores = Store::getDropdown();
        $users = User::Notview()->pluck('name', 'id');
        $stores = Store::getDropdown();
        $manufacturers = Manufacturer::getDropdown();


        return view('manufacturings.create')
            ->with(compact(
                'stores',
                'manufacturers',
                'is_raw_material',
                'suppliers',
                'status_array',
                'payment_status_array',
                'payment_type_array',
                'stores',
                'variation_id',
                'product_id',
                'po_nos',
                'taxes',
                'product_classes',
                'payment_types',
                'payment_status_array',
                'categories',
                'sub_categories',
                'brands',
                'units',
                'colors',
                'sizes',
                'grades',
                'taxes_array',
                'customer_types',
                'exchange_rate_currencies',
                'discount_customer_types',
                'users',
            ));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'store_id' => ['required', 'numeric'],
            'manufacturer_id' => ['required', 'numeric'],
        ]);
        try {
        $data = $request->only('store_id', 'manufacturer_id');
        $data["created_by"] = auth()->id();
        DB::beginTransaction();
        $manufacturing = Manufacturing::create($data);
        $transaction = Transaction::query()->create([
            "store_id" => $request->store_id,
            "manufacturing_id" => $manufacturing->id,
            "type" => "material_under_manufacture",
            "status" => "pending",
            "transaction_date" => Carbon::now()->toDateTimeString(),
            "is_raw_material" => "1",
            "created_by" => auth()->id(),
        ]);
//        dd($request->product_quentity);
        foreach ($request->product_quentity as $product_id => $variation_quentities) {
            foreach ($variation_quentities as $variation_id=>$variation_quentity){
                $this->productUtil->decreaseProductQuantity($product_id,$variation_id,$request->store_id,$variation_quentity["quantity"]);

//                dd($product_id,$variation_id,$variation_quentity["quantity"]);
                $qty = $this->num_uf($variation_quentity["quantity"]);
                $stock = ProductStore::where("product_id",$product_id)
                    ->where("variation_id",$variation_id)
                    ->where("qty_available",">",$variation_quentity["quantity"])
                    ->first();
                if (!is_null($stock)){
                    $variation = $variation_id;
                    $stock->decrement("qty_available", $variation_quentity["quantity"]);
                    $manufacturingProducts = manufacturingProduct::create([
                        "manufacturing_id" => $manufacturing->id,
                        "product_id" => $product_id,
                        "variation_id" => $variation_id,
                        "quantity" => $variation_quentity["quantity"],
                    ]);
                }else{
                    $output = [
                        'success' => false,
                        'msg' => __('lang.something_went_wrong')
                    ];
                    return $output;
                }
            }
        }
        DB::commit();
        $output = [
            'success' => true,
            'msg' => __('lang.success')
        ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return $output;
    }

    public function show($id)
    {
        //
    }

    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator = ',';
        $decimal_separator = '.';

        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);

        return (float)$num;
    }

    public function getReceivedProductsPage($id)
    {
        $manufacturing = Manufacturing::findOrFail($id);
        $store = Store::where("id", $manufacturing->store_id)->first();
        $manufacturer = Manufacturer::where("id", $manufacturing->manufacturer_id)->first();
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $po_nos = Transaction::where('type', 'purchase_order')->where('status', '!=', 'received')->pluck('po_no', 'id');
        $status_array = $this->commonUtil->getPurchaseOrderStatusArray();
        $payment_status_array = $this->commonUtil->getPaymentStatusArray();
        $payment_type_array = $this->commonUtil->getPaymentTypeArray();
        $payment_types = $payment_type_array;
        $taxes = Tax::pluck('name', 'id');
        $variation_id = request()->get('variation_id');
        $product_id = request()->get('product_id');
        $is_raw_material = request()->segment(1) == 'raw-material' ? true : false;
        $product_classes = ProductClass::orderBy('name', 'asc')->pluck('name', 'id');
        $categories = Category::whereNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        $sub_categories = Category::whereNotNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        $brands = Brand::orderBy('name', 'asc')->pluck('name', 'id');
        $units = Unit::orderBy('name', 'asc')->pluck('name', 'id');
        $colors = Color::orderBy('name', 'asc')->pluck('name', 'id');
        $sizes = Size::orderBy('name', 'asc')->pluck('name', 'id');
        $grades = Grade::orderBy('name', 'asc')->pluck('name', 'id');
        $taxes_array = Tax::orderBy('name', 'asc')->pluck('name', 'id');
        $customer_types = CustomerType::orderBy('name', 'asc')->pluck('name', 'id');
        $discount_customer_types = Customer::getCustomerTreeArray();
        $exchange_rate_currencies = $this->commonUtil->getCurrenciesExchangeRateArray(true);
        $stores = Store::getDropdown();
        $users = User::Notview()->pluck('name', 'id');

        return view('manufacturings.receivedProductsPage')
            ->with(compact(
                'store',
                'manufacturer',
                'manufacturing',
                'is_raw_material',
                'suppliers',
                'status_array',
                'payment_status_array',
                'payment_type_array',
                'stores',
                'variation_id',
                'product_id',
                'po_nos',
                'taxes',
                'product_classes',
                'payment_types',
                'payment_status_array',
                'categories',
                'sub_categories',
                'brands',
                'units',
                'colors',
                'sizes',
                'grades',
                'taxes_array',
                'customer_types',
                'exchange_rate_currencies',
                'discount_customer_types',
                'users',
            ));
    }

    public function postReceivedProductsPage(Request $request)
    {

        $data = $request->product_quentity;
//        try {
            $manufacturing = Manufacturing::find($request->manufacturing_id);
            DB::beginTransaction();
            $transaction_data=[
                "store_id" => $request->store_id,
                "manufacturing_id" => $manufacturing->id,
                "type" => "material_manufactured",
                "status" => "approved",
                "transaction_date" => Carbon::now()->toDateTimeString(),
                "is_raw_material" => "1",
                "invoice_no" => $request->invoice_no,
                "other_expenses" => $request->other_expenses ?? 0,
                "discount_amount" => $request->discount_amount ?? 0,
                "other_payments" => $request->other_payments ?? 0.0000,
                "source_type" => $request->source_type ?? null,
                "source_id" => $request->source_id,
                "payment_status" => $request->payment_status,
                "amount" => $request->amount ?? 0,
                "method" => $request["method"] ?? null,
                "paid_on" => $request->paid_on ?? null,
                "ref_number" => $request->ref_number ?? 0,
                "bank_deposit_date" => $request->bank_deposit_date,
                "bank_name" => $request->bank_name ?? null,
                "due_date" => $request->due_date ?? null,
                "notify_before_days" => $request->notify_before_days ?? 0,
                "notes" => $request->notes ?? null,
                'created_by' => Auth::user()->id,
            ];
            $transaction = Transaction::query()->create($transaction_data);
            $transaction->transaction_payments()->create($transaction_data);
            if ($request->files) {
                foreach ($request->file('files', []) as $key => $file) {
                    $transaction->addMedia($file)->toMediaCollection('add_stock');
                }
            }
            // add stock new products
            foreach ($request->product_quentity as $product_id => $variation_quentities) {
                foreach ($variation_quentities as $variation_id=>$variation_quentity){
                    $this->productUtil->increaseProductQuantity($product_id,$variation_id,$transaction->store_id,$variation_quentity["quantity"]);
                    $manufacturingProducts = manufacturingProduct::create([
                        "manufacturing_id" => $manufacturing->id,
                        "product_id" => $product_id,
                        "variation_id" => $variation_id,
                        "quantity" => $variation_quentity["quantity"],
                        "status" => "1",
                    ]);
                }
            }
            $manufacturing->update(["status"=>"completed","edited_by"=>auth()->id()]);


            //calc price of one
            $product_cost_purchase=0;
            $product_cost_sell=0;
            foreach($manufacturing->manufacturing_products as $product){
                $product_cost_purchase+=($product->product->purchase_price*$product->quantity);
                $product_cost_sell+=($product->product->sell_price*$product->quantity);
            }
            $product_cost_purchase+=($request->amount ??0);
            $product_cost_sell+=($request->amount ??0);
            foreach ($request->product_quentity as $product_id => $variation_quentities) {
                foreach ($variation_quentities as $variation_id=>$variation_quentity){
                    $qty = $this->num_uf($variation_quentity["quantity"]);
                    $product_cost_purchase/=$qty;
                    $product_cost_sell/=$qty;
                }
            }

            $manufacturing->manufacture_cost_unit_purchase=$product_cost_purchase;
            $manufacturing->manufacture_cost_unit_sell=$product_cost_sell;
            $manufacturing->save();
            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
//        } catch (\Exception $e) {
//            DB::rollBack();
//            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
//            $output = [
//                'success' => false,
//                'msg' => __('lang.something_went_wrong')
//            ];
//        }
        return $output;

    }

    public function edit($id)
    {
        $manufacturing = Manufacturing::findOrFail($id);
        $underManufacturings = manufacturingProduct::query()->where('manufacturing_id', $id)->where("status", "0")->get();
        $manufactureds = manufacturingProduct::query()->where("manufacturing_id", $id)->where("status", "1")->get();
        $product_ids = manufacturingProduct::query()->where("manufacturing_id", $id)->pluck("quantity", "product_id")->toArray();
        return view('manufacturings.edit', compact('manufacturing', 'underManufacturings', 'manufactureds', 'product_ids'));
    }

    public function updates(Request $request)
    {
        $manufacturing = Manufacturing::find($request->manufacturing_id);
//        try {
            // stock
            DB::beginTransaction();
            if (isset($request->product_material_recived) && is_array($request->product_material_recived) && count($request->product_material_recived) > 0) {
                $old_variations = $manufacturing->material_recived->pluck("variation_id")->toArray();
                foreach ($request->product_material_recived as $product_id=>$variation){
                    foreach ($variation as $variationId=>$quantity){
                        $new_variations[$variationId] = $product_id ;
                    }
                }
                $deleted_product_material_recived = array_diff($old_variations, array_keys($new_variations));
                foreach ($old_variations as $variation_id){
                    $manufacturingDeletedProduct = manufacturingProduct::query()->where("manufacturing_id", $manufacturing->id)->where("variation_id",$variation_id)->where("status", "1")->first();
                    $variation = Variation::find($variation_id);
//                    $this->productUtil->increaseProductQuantity($variation->product_id,$variation_id,$manufacturing->store_id,$manufacturingDeletedProduct->quantity);
                    $manufacturingDeletedProduct->delete();
                }
                foreach ($request->product_material_recived as $product_id => $material_recived) {
                    foreach ($material_recived as $variation_id => $material){
                        $manufacturingProduct = manufacturingProduct::ManufacturingValue($manufacturing->id)->Product($product_id)->Variation($variation_id)->Status(1)->first();
                        $manufacturingProductOldQuantity = $manufacturingProduct->quantity;
                        $manufacturingProductNewQuantity = $material["quantity"];
                        $manufacturingProduct->update(["quantity" => $manufacturingProductNewQuantity]);
                        if ($manufacturingProductOldQuantity < $manufacturingProductNewQuantity) {
                            $increased = $manufacturingProductNewQuantity - $manufacturingProductOldQuantity;
                            $this->productUtil->increaseProductQuantity($product_id, $variation_id, $manufacturing->store_id, $increased);
                        } else {
                            $decreased = $manufacturingProductOldQuantity - $manufacturingProductNewQuantity;
                            $this->productUtil->decreaseProductQuantity($product_id, $variation_id, $manufacturing->store_id, $decreased);
                        }
                    }
                }
            }
            if (isset($request->product_material_under_manufactured) && is_array($request->product_material_under_manufactured) && count($request->product_material_under_manufactured) > 0) {
                $old_variations = $manufacturing->materials->pluck("variation_id")->toArray();
                foreach ($request->product_material_under_manufactured as $product_id=>$variation){
                    foreach ($variation as $variationId=>$quantity){
                        $new_variations[$variationId] = $product_id ;
                    }
                }
                $deleted_product_material_recived = array_diff($old_variations, array_keys($new_variations));
                foreach ($old_variations as $variation_id){
                    $manufacturingDeletedProduct = manufacturingProduct::query()->where("manufacturing_id", $manufacturing->id)->where("variation_id",$variation_id)->where("status", "0")->first();
                    $variation = Variation::find($variation_id);
//                    $this->productUtil->increaseProductQuantity($variation->product_id,$variation_id,$manufacturing->store_id,$manufacturingDeletedProduct->quantity);
                    $manufacturingDeletedProduct->delete();
                }
                foreach ($request->product_material_under_manufactured as $p_id => $material_under_manufactured) {
                    foreach ($material_under_manufactured as $variation_id => $material){
//                      dd($variation_id,$material["quantity"],$product_id,$manufacturing->id);
                        $manufacturingProduct = manufacturingProduct::query()->where("manufacturing_id", $manufacturing->id)->where("variation_id",$variation_id)->where("product_id", $product_id)->where("status", "0")->first();
                        $manufacturingProductOldQuantity = $manufacturingProduct->quantity;
                        $manufacturingProductNewQuantity = $material["quantity"];
                        $manufacturingProduct->update(["quantity" => $manufacturingProductNewQuantity]);
                        if ($manufacturingProductOldQuantity < $manufacturingProductNewQuantity) {
                            $increased = $manufacturingProductNewQuantity - $manufacturingProductOldQuantity;
                            $this->productUtil->increaseProductQuantity($product_id, $variation_id, $manufacturing->store_id, $increased);
                        } else {
                            $decreased = $manufacturingProductOldQuantity - $manufacturingProductNewQuantity;
                            $this->productUtil->decreaseProductQuantity($product_id, $variation_id, $manufacturing->store_id, $decreased);
                        }
                    }
                }
            }
            $transaction = Transaction::query()->create([
                "store_id" => $request->store_id,
                "type" => "material_manufactured",
                "status" => "received",
                "transaction_date" => Carbon::now()->toDateTimeString(),
                "is_raw_material" => "1",
            ]);
            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
//        } catch (\Exception $e) {
//            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
//            $output = [
//                'success' => false,
//                'msg' => __('lang.something_went_wrong')
//            ];
//        }
        return $output;
    }

    public function addProductRow(Request $request)
    {
        if ($request->ajax()) {
            $currency_id = $request->currency_id;
            $currency = Currency::find($currency_id);
            $exchange_rate = $this->commonUtil->getExchangeRateByCurrency($currency_id, $request->store_id);
            $product_id = $request->input('product_id');
            $variation_id = $request->input('variation_id');
            $store_id = $request->input('store_id');

            if (!empty($product_id)) {
                $index = $request->input('row_count');
                $products = $this->productUtil->getDetailsFromProduct($product_id, $variation_id, $store_id);
//                dd($products);
                return view('manufacturings.partials.product_row')
                    ->with(compact('products', 'index', 'currency', 'exchange_rate'));
            }
        }
    }

    public function add_product_stock(Request $request)
    {
        if ($request->ajax()) {
            $currency_id = $request->currency_id;
            $currency = Currency::find($currency_id);
            $exchange_rate = $this->commonUtil->getExchangeRateByCurrency($currency_id, $request->store_id);
            $product_id = $request->input('product_id');
            $variation_id = $request->input('variation_id');
            $store_id = $request->input('store_id');

            if (!empty($product_id)) {
                $index = $request->input('row_count');
                $products = $this->productUtil->getDetailsFromProduct($product_id, $variation_id, $store_id);
                return view('manufacturings.partials.product_row_add_to_stock')
                    ->with(compact('products', 'index', 'currency', 'exchange_rate'));
            }
        }
    }

    public function destroy($id)
    {
        try {
            $manufacturing = Manufacturing::find($id);
            if (isset($manufacturing->material_recived) && count($manufacturing->material_recived) > 0) {
                foreach ($manufacturing->material_recived as $deleted_product) {
//                        $product = Product::find($deleted_product->product_id);
//                        $product->product_stores->first()->increment("qty_available", $deleted_product->quantity);
                    $deleted_product->delete();
                }
            }

            if (isset($manufacturing->materials) && count($manufacturing->materials) > 0) {
                foreach ($manufacturing->materials as $deleted_product) {
                    $product = Product::find($deleted_product->product_id);
                    $product->product_stores->first()->increment("qty_available", $deleted_product->quantity);
                    $deleted_product->delete();
                }
            }
            $manufacturing->delete();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return $output;
    }
}
