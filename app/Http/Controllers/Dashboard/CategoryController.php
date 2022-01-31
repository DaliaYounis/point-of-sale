<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use function MongoDB\BSON\toJSON;
use CodeZero\UniqueTranslation\UniqueTranslationRule;


class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::when($request->search, function ($q) use ($request) {
            return $q->where('name->'.app()->getLocale(), 'like', '%' . $request->search . '%');
        })->latest()->paginate(5);
        return view('dashboard.categories.index', compact('categories'));
    }


    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        Category::create(['name'=>$request->name]);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');

    }


    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));

    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.categories.index');

    }


    public function destroy(Category $category)
    {
        $category->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.category.index');
    }
}
