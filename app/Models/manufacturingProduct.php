<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class manufacturingProduct extends Model
{
    use HasFactory;
    protected $table = "manufacturing_products";
    protected $fillable = [
        "status",
        "manufacturing_id",
        "product_id",
        "variation_id",
        "manufacture_cost_unit_sell",
        "manufacture_cost_unit_purchase",
        "quantity",
    ];
    protected $casts = [
        "quantity" => "double"
    ];
    public function product(){
        return $this->belongsTo(Product::class,"product_id","id");
    }
    public function variation(){
        return $this->belongsTo(Variation::class,"variation_id","id");
    }
    public function manufacturing(){
        return $this->belongsTo(Manufacturing::class,"manufacturing_id","id");
    }
    public function scopeManufacturingValue($q,$value){
        if (!is_null($value)){
            return $q->where("manufacturing_id",$value);
        }
    }
    public function scopeProduct($q,$value){
        if (!is_null($value)){
            return $q->where("product_id",$value);
        }
    }
    public function scopeVariation($q,$value){
        if (!is_null($value)){
            return $q->where("variation_id",$value);
        }
    }
    public function scopeStatus($q,$value){
        if (!is_null($value)){
            return $q->where("status",$value);
        }
    }
}
