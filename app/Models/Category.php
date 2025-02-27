<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Yajra\DataTables\Html\Editor\Fields\BelongsTo;

class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'translations' => 'array',
    ];

    public function getNameAttribute($name)
    {
        $translations = !empty($this->translations['name']) ? $this->translations['name'] : [];
        if (!empty($translations)) {
            $lang = session('language');
            if (!empty($translations[$lang])) {
                return $translations[$lang];
            }
        }
        return $name;
    }

    public function productClass()
    {
        return $this->belongsTo(ProductClass::class,'product_class_id');
    }

    public function mainCategory()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function subCategories() : HasMany
    {
        return $this->hasMany(Category::class,'parent_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
