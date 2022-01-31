<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    use ImageTrait;

    public function index(Request $request)
    {
        $categories = Category::all();
        $products = Product::when($request->search,function ($q) use ($request){
            return $q->where('name->'.app()->getLocale(), 'like', '%' . $request->search . '%');
        })->when($request->category_id,function ($q) use ($request){
            return $q->where('category_id',$request->category_id);
        })->latest()->paginate(5);
        return view('dashboard.products.index', compact('products','categories'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }


    public function store(ProductRequest $request)
    {
        $request_data = $request->all();
        if ($request->image) {
            $this->saveImage($request,'products');
            $request_data['image'] = $request->image->hashName();
        }
        Product::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.products.index');

    }


    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact('categories','product'));
    }



    public function update(ProductRequest $request, Product $product)
    {
        $request_data = $request->all();
        if ($product->image != 'default.png') {
            if ($request->image) {
                \Storage::disk('public_uploads')->delete('/products/' . $product->image);
                $this->saveImage($request, 'products');
                $request_data['image'] = $request->image->hashName();
            }
        }
        $product->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');
    }


    public function destroy(Product $product)
    {
        if ($product->image != 'default.png') {
            \Storage::disk('public_uploads')->delete('/users/' . $product->image);
        }
        $product->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');

    }
}
