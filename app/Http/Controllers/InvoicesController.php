<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\sections;
use App\Models\User;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices=invoices::all();
       return view('invoices.invoices' ,compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections=sections::all();
        return view('invoices.add_invoice' , compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments;
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }
    //      $user= User::first();

    //      Notification::send($user, new AddInvoice());


      return redirect()->route( 'invoices.index');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
     $invoices=invoices::where('id',$id)->first();
     return view('invoices.status_update' ,compact('invoices'));


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
       $invoices=invoices::where('id' ,$id)->first();
       $sections=sections::all();
       return view('invoices.edit_invoice' ,compact('invoices' ,'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request ,$id)
    {

$invoice=invoices::where('id' ,$id)->update([

    'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,


]);

return redirect()->route( 'invoices.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $invoice=invoices::where('id' ,$id)->delete();
        return redirect()->route('invoices.index');
    }
    public function getproducts($id)
    {
    $products=DB::table('products')->where('section_id' ,$id)->pluck('product_name' ,'id');
    return json_encode($products);


    }

 public function status_update(Request $request,$id)
    {

$invoice=invoices::findOrFail($id);

   if($request->Status ==='مدفوعة'){
    $invoice->update([
        'invoice_number' => $request->invoice_number,
        'invoice_Date' => $request->invoice_Date,
        'Due_date' => $request->Due_date,
        'product' => $request->product,
        'section_id' => $request->Section,
        'Amount_collection' => $request->Amount_collection,
        'Amount_Commission' => $request->Amount_Commission,
        'Discount' => $request->Discount,
        'Value_VAT' => $request->Value_VAT,
        'Rate_VAT' => $request->Rate_VAT,
        'Total' => $request->Total,
        'note' => $request->note,
            'Status' =>$request->Status,
            'Value_Status' => 1,
             'Payment_Date'=>$request->Payment_Date,
    ]);
    invoices_Details::create([
        'id_Invoice' => $request->invoice_id,
        'invoice_number' => $request->invoice_number,
        'product' => $request->product,
        'Section' => $request->Section,
        'Status' => $request->Status,
        'Value_Status' => 1,
        'note' => $request->note,
        'Payment_Date' => $request->Payment_Date,
        'user' => (Auth::user()->name),
    ]);
   }else{
    $invoice->update([
        'Value_Status' => 3,
        'Status' => $request->Status,
        'Payment_Date' => $request->Payment_Date,
    ]);
    invoices_Details::create([
        'id_Invoice' => $request->invoice_id,
        'invoice_number' => $request->invoice_number,
        'product' => $request->product,
        'Section' => $request->Section,
        'Status' => $request->Status,
        'Value_Status' => 3,
        'note' => $request->note,
        'Payment_Date' => $request->Payment_Date,
        'user' => (Auth::user()->name),
    ]);
   }
   session()->flash('Status_Update');
   return redirect('/invoices');
}

public function invoices_paid()
{
$invoices=invoices::where('Value_Status','=' ,1)->get();
return view('invoices.invoices_paid' ,compact('invoices'));

}

public function invoices_unpaid()
{

    $invoices=invoices::where('Value_Status' ,2)->get();
    return view('invoices.invoices_unpaid' ,compact('invoices'));


}

public function invoices_partial()
{
    $invoices=invoices::where('Value_Status' ,3)->get();
    return view('invoices.invoices_partial' ,compact('invoices'));

}
public function print_invoice($id)
{
    $invoice=invoices::where('id' ,$id)->first();
    return view('invoices.print_invoice' ,compact('invoice'));

}




















    }

