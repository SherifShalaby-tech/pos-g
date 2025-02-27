<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Variation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $appends = [
        "avg_purchase_price"
    ];
    // protected $casts=['multiple_thread_colors' => 'array'];
    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault(['name' => '']);
    }
    public function addStockLines()
    {
        return $this->hasMany(AddStockLine::class);
    }
    public function color()
    {
        return $this->belongsTo(Color::class)->withDefault(['name' => '']);
    }
    public function thread_color()
    {
        return $this->belongsTo(Color::class,"multiple_thread_colors","id")->withDefault(['name' => '']);
    }
    public function size()
    {
        return $this->belongsTo(Size::class)->withDefault(['name' => '']);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class)->withDefault(['name' => '']);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class)->withDefault(['name' => '']);
    }

    public function product_stores()
    {
        return $this->hasMany(ProductStore::class, 'variation_id');
    }

    public function raw_materials()
    {
        return $this->hasMany(ConsumptionProduct::class);
    }
    public function getAvgPurchasePriceAttribute($query)
    {
       return  AddStockLine::query()->where("variation_id",$this->id)->average("purchase_price");
    }
    public function manufacturing_products()
    {
        return $this->hasMany(manufacturingProduct::class);
    }

}
