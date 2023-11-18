<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections=sections::all();
        return view('sections.sections' ,compact('sections'));
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
             'section_name'=>'required |unique:sections|max:255',
             'description'=>'required',
  ],[

      'section_name.required'=>'يرجي ادخال اسم القسم',
      'section_name.unique'=>'اسم القسم مسجل مسبقا',
      'description.required'=>'يرجي ادخال ملاحظاتك'
  ]);


    $input=$request->all();
     $exist=sections::where('section_name','=' ,$input['section_name'])->exists();
     if($exist){
        return redirect()->back()->with('error' ,'هذا القسم مسجل مسبقا');
     }
   else{
    sections::create([
      'section_name'=>$request->section_name,
      'description'=>$request->description,
      'created_by'=>(Auth::user()->name),


    ]);
    return redirect()->back()->with('تم اضافة القسم بنجاح');

   }




    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request  ,$id)
    {
        //return "kkkkkkkkkk";
        $id = $request->id;

        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required',
        ],[

            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',
            'description.required' =>'يرجي ادخال البيان',

        ]);

        $sections = sections::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,

        ]);

        return redirect('/sections');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
    // return "kkkkkkkkk";
    $id=$request->id;
    sections::find($id)->delete();
    return redirect()->route('sections');

    }
}
