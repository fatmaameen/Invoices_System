<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections=sections::all();
        $products=Product::all();
        return view('products.products' ,compact('sections' ,'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate_data=$request->validate([
            'product_name'=>'required',
            'section_id'=>'required',
            'description'=>'required',
 ],[

     'product_name.required'=>'يرجي ادخال اسم المنتج',
     'section_id.required'=>'يرجي تحديد اسم القسم التابع لة ذلك المنتج',
     'description.required'=>'يرجي ادخال ملاحظاتك'
 ]);




   Product::create([
     'product_name'=>$request->product_name,
     'section_id'=>$request->section_id,
     'description'=>$request->description,



   ]);
   return redirect()->back()->with('تم اضافة القسم بنجاح');

  }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {


        $id = sections::where('section_name', $request->section_name)->first()->id;

       $products = Product::findOrFail($request->product_id);

       $products->update([
       'product_name' => $request->product_name,
       'description' => $request->description,
       'section_id' => $id,
       ]);


       return redirect()->route('/products');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request ,$id)
    {
 $products=Product::findOrfail($request->product_id);
  $products->delete();

 return redirect()->route('/products');
    }
}
