<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::when($request->search , function ($q) use ($request){

            return $q->whereTranslationLike('name','%' .$request->search . '%');

        })->when($request->category_id , function ($qq) use($request){

           return $qq->where('category_id', $request->category_id);

        })->latest()->paginate(5);

        return view('dashboard.products.index',compact('categories','products'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create',compact('categories'));
    }


    public function store(Request $request)
    {
        $rules = [];
        foreach(config('translatable.locales') as $locale){

            $rules += [$locale .'.name' =>['required', Rule::unique('product_translations','name')]];
            $rules += [$locale .'.description' =>['required', Rule::unique('product_translations','description')]];
        }

        $rules += [
            'category_id' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];

        $request->validate($rules);

        $request_data = $request->all();

        if($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(base_path('uploads/product_images/' . $request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }//end if for image

        Product::create($request_data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('products.index');
    }



    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit',compact('categories','product'));
    }


    public function update(Request $request, Product $product)
    {
        $rules = [];
        foreach(config('translatable.locales') as $locale){

            $rules += [$locale .'.name' =>['required', Rule::unique('product_translations','name')
                ->ignore($product->id , 'product_id')]];
            $rules += [$locale .'.description' =>['required', Rule::unique('product_translations','description')
                ->ignore($product->id , 'product_id')]];
        }

        $rules += [
            'category_id' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];
        $request->validate($rules);

        $request_data = $request->except('image');

        // save image //

        if($request->image) {

            if ($product->image != 'default.png') {

                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
            }//end if delete image

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(base_path('uploads/product_images/' . $request->image->hashName()));
            $request_data['image'] = $request->image->hashName();

        }//end if for image

        $product->update($request_data);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('products.index');
    }


    public function destroy(Product $product)
    {
        $product->delete();

        if ($product->image != 'default.png'){
            Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
        }
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('products.index');
    }
}
