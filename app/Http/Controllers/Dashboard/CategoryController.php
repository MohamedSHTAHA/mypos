<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Product;
use App\ProductTranslation;
use App\CategoryTranslation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:create_categories'])->only('create');
        $this->middleware(['permission:read_categories'])->only('index');
        $this->middleware(['permission:update_categories'])->only(['edit', 'update']);
        $this->middleware(['permission:delete_categories'])->only('destroy');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd(Category::translated()->get());
        $categories  = Category::when($request->search, function ($q) use ($request) {
            //return $q->where('name','like', '%' . $request->search . '%');
            return $q->whereTranslationLike('name', '%' . $request->search . '%');
        })->latest()->paginate(3);


        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$request->validate(
            [
                'ar.*' => 'required|min:3|unique:category_translations,name',
            ]
        );*/

        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            //$rules += [$locale . '.name' => ['required','min:3', Rule::unique('category_translations', 'name')]];
            $rules += [$locale . '.name' => 'required|min:3|unique:category_translations,name',];
        } //end of for each

        $request->validate($rules);

        $category = Category::Create($request->all());

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', 'min:3', Rule::unique('category_translations', 'name')->ignore($category->id, 'category_id')]];
        } //end of for each

        $request->validate($rules);


        $category->update($request->all());

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        $categoryTranslation = CategoryTranslation::where('category_id', $category->id)->delete();
        //dd($category);
        $product = Product::where('category_id', $category->id)->first();

        //dd($product->id);
        $product->delete();
        $productTranslation = ProductTranslation::where('product_id', $product->id)->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.categories.index');
    }
}