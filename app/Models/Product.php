<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;
    public $translatable = ['name','description'];
    protected $guarded = [];
    protected $appends = ['image_path'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getImagePathAttribute(){
        return asset('uploads/products/'.$this->image);
    }
}
