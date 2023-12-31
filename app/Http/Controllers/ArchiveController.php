<?php

namespace App\Http\Controllers;

use App\Models\cr;
use App\Models\invoices;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $invoices=invoices::onlyTrashed()->get();
       return view('invoices.archive' ,compact('invoices'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $invoice=invoices:: withTrashed()->where('id' ,$id)->restore();
        return redirect()->route('invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $invoice=invoices::withTrashed()->where('id' ,$id)->forceDelete();
        return redirect()->back();
    }
}
