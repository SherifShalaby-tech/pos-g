@forelse ($products as $product)
<tr class="product_row">
    <td style="width: 30%">
        {{$product->product->name}}

        @if($product->variation->name != "Default")
        <b>{{$product->variation->name}}</b>
        @endif
        <input type="hidden" name="purchase_return_lines[{{$loop->index}}][purchase_return_line_id]" class="purchase_return_line_id"
            value="{{$product->id}}">
        <input type="hidden" name="purchase_return_lines[{{$loop->index}}][product_id]" class="product_id"
            value="{{$product->product_id}}">
        <input type="hidden" name="purchase_return_lines[{{$loop->index}}][variation_id]" class="variation_id"
            value="{{$product->variation_id}}">

    </td>
    <td style="width: 20%">
        <div class="input-group">
            <input type="text" class="form-control quantity"  max="{{preg_match('/\.\d*[1-9]+/', (string)$product->quantity) ? $product->quantity : @num_format($product->quantity)}}"
                name="purchase_return_lines[{{$loop->index}}][quantity]" required
                value="@if(isset($product->quantity)){{preg_match('/\.\d*[1-9]+/', (string)$product->quantity) ? $product->quantity : @num_format($product->quantity)}}@else{{0}}@endif">
        </div>

    </td>
    <td style="width: 20%">
        <input type="text" class="form-control purchase_price" name="purchase_return_lines[{{$loop->index}}][purchase_price]"
            required value="@if(isset($product->purchase_price)){{@num_format($product->purchase_price)}}@else{{0}}@endif">
    </td>
    <td>
        @php
            $query = App\Models\ProductStore::where('product_id', $product->product_id)->where('variation_id', $product->variation_id);
            if(!empty($store_id)){
                $query->where('store_id', $store_id);
            }
            $current_stock = $query->sum('qty_available');
        @endphp
        <input type="hidden" name="current_stock" class="current_stock" value="{{$current_stock}}">
        <span class="current_stock_span">{{@num_format($current_stock)}}</span>
    </td>
    <td style="width: 10%">
        <span class="sub_total_span">{{@num_format(0)}}</span>
        <input type="hidden" class="form-control sub_total" name="purchase_return_lines[{{$loop->index}}][sub_total]"
            value="{{@num_format(0)}}">
    </td>
    <td style="width: 20%">
        <button type="button" class="btn btn-danger btn-sx remove_row"><i class="fa fa-times"></i></button>
    </td>
</tr>
@empty

@endforelse
