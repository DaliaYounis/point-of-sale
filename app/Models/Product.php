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
    protected $appends = ['image_path','profit_percent'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getImagePathAttribute(){
        return asset('uploads/products/'.$this->image);
    }

    public function getProfitPercentAttribute(){
        $profit = $this->sale_price - $this->purchase_price ;
        $profit_perecent = $profit * 100 / $this->purchase_price ;
        return number_format($profit_perecent, 2);
    }
}
