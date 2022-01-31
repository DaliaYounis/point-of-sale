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
        $products = Product::paginate(2);
        return view('dashboard.products.index', compact('products'));
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


    public function show(Category $category)
    {
        //
    }


    public function edit(Category $category)
    {
        //
    }


    public function update(Request $request, Category $category)
    {
        //
    }


    public function destroy(Category $category)
    {
        //
    }
}
