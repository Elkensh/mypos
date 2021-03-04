<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::when($request->search , function ($q) use ($request){
            return $q->where('name','like','%' .$request->search . '%');
        })->latest()->paginate(10);
        return view('dashboard.category.index',compact('categories'));
    }


    public function create()
    {
        return view('dashboard.category.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);
        Category::create($request->all());
        session()->flash('success', __('site.added.successfully'));
        return redirect()->route('categories.index');
    }





    public function edit(Category $category)
    {
        return view('dashboard.category.edit',compact('category'));
    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
            // new validation
            /*'name' =>  ['required',Rule::unique('categories')->ignore($category->id),],*/
          //old validation
            'name' =>  'required|unique:categories,name,' . $category->id,
        ]);
        $category->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('categories.index');

    }


    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('categories.index');
    }
}
