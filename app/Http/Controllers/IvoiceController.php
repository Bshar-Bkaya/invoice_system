<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendInvoice as inin;
use App\Models\Invoice;
use App\Http\Requests\ValidationRequest;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Route;
use App\Notifications\AddInvoice;
use Illuminate\Support\Facades\Notification;

class IvoiceController extends Controller
{
  // To Auth
  public function __construct()
  {
    $this->middleware('auth');
  }
  /**b
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $all_invoices = Invoice::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);

    if (count($all_invoices) == 0) {
      return view('frontend.noinvoice');
    } else {
      return view('frontend.index', compact('all_invoices'));
    }
  }

  public function home()
  {
    return redirect()->route('index')->with([
      'message'    => __('messages.You are logged in'),
      'alert-type' => 'success'
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('frontend.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(ValidationRequest $request)
  {
    $data = [
      'user_id'            =>  Auth::id(),
      'customer_name'   => $request->customer_name,
      'customer_email'  => $request->customer_email,
      'customer_mobile' => $request->customer_mobile,
      'company_name'    => $request->company_name,
      'invoice_number'  => $request->invoice_number,
      'invoice_date'    => $request->invoice_date,

      'sub_total'       => $request->sub_total,
      'discount_type'   => $request->discount_type,
      'discount_value'  => $request->discount_value != null ? $request->discount_value : 0,
      'vat_value'       => $request->vat_value,
      'shipping'        => $request->shipping != null ? $request->shipping : 0,
      'total_due'       => $request->total_due,
    ];
    $created_invoice = Invoice::create($data);
    $details_list = [];

    for ($i = 0; $i < count($request->product_name); $i++) {
      // $details_list[$i]['invoice_id']  = $created_invoice->id;    //Set By Default
      $details_list[$i]['product_name']   = $request->product_name[$i];
      $details_list[$i]['unit']           = $request->unit[$i];
      $details_list[$i]['quantity']      = $request->quantity[$i];
      $details_list[$i]['unit_price']     = $request->unit_price[$i];
      $details_list[$i]['row_sub_total']  = $request->row_sub_total[$i];
    }

    $details = $created_invoice->invoice_details()->createMany($details_list);

    if ($details) {

      //##### Send Mail Message To Email User #####
      $user = auth()->user();
      // $user->notify(new AddInvoice($created_invoice->id));           //  OR
      Notification::send($user, new AddInvoice($created_invoice->id));  //  OR

      return redirect()->back()->with([
        'status'     => 'success',
        'message'    =>  __('messages.created_successfully'),
        'alert-type' => 'success'
      ]);
    } else {
      return redirect()->back()->with([
        'status'     => 'faile',
        'message'    =>  __('messages.created_failed'),
        'alert-type' => 'danger'
      ]);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $invoice = Invoice::findOrFail($id);
    return view('frontend.show', compact('invoice'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $invoice = Invoice::findOrFail($id);
    return view('frontend.edit', compact('invoice'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(ValidationRequest $request, $id)
  {
    $edit_invoice = Invoice::where('user_id', Auth::id())->whereId($id)->first();
    $data = [
      'customer_name'   => $request->customer_name,
      'customer_email'  => $request->customer_email,
      'customer_mobile' => $request->customer_mobile,
      'company_name'    => $request->company_name,
      'invoice_number'  => $request->invoice_number,
      'invoice_date'    => $request->invoice_date,

      'sub_total'       => $request->sub_total,
      'discount_type'   => $request->discount_type,
      'discount_value'  => $request->discount_value != null ? $request->discount_value : 0,
      'vat_value'       => $request->vat_value,
      'shipping'        => $request->shipping != null ? $request->shipping : 0,
      'total_due'       => $request->total_due,
    ];
    $details = $edit_invoice->update($data);
    // Delete Old Details
    $edit_invoice->invoice_details()->delete();

    $details_list = [];

    for ($i = 0; $i < count($request->product_name); $i++) {
      $details_list[$i]['product_name']   = $request->product_name[$i];
      $details_list[$i]['unit']           = $request->unit[$i];
      $details_list[$i]['quantity']      = $request->quantity[$i];
      $details_list[$i]['unit_price']     = $request->unit_price[$i];
      $details_list[$i]['row_sub_total']  = $request->row_sub_total[$i];
    }

    $details = $edit_invoice->invoice_details()->createMany($details_list);

    if ($details) {
      return redirect()->back()->with([
        'status'     => 'success',
        'message'    =>  __('messages.updated_successfully'),
        'alert-type' => 'success'
      ]);
    } else {
      return redirect()->back()->with([
        'status'     => 'faile',
        'message'    =>  __('messages.updated_failed'),
        'alert-type' => 'danger'
      ]);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $invoice = Invoice::findOrFail($id);
    if ($invoice) {
      $invoice->delete();
      return redirect()->route('invoice.index')->with([
        'message'    =>  __('messages.deleted_successfully'),
        'alert-type' => 'success'
      ]);
    } else {
      return redirect()->route('invoice.index')->with([
        'message'    =>  __('messages.deleted_failed'),
        'alert-type' => 'danger'
      ]);
    }
  }

  public function print($id)
  {
    $invoice = Invoice::findOrFail($id);

    return view('frontend.print', compact('invoice'));
  }

  public function pdf($id)
  {
    $invoice = Invoice::findOrFail($id);

    $pdf = PDF::loadView('frontend.generatePDF', compact('invoice'));
    if (Route::currentRouteName() == 'invoice.pdf') {
      return $pdf->download(__('messages.Invoice', ['invoice_number' => $invoice->invoice_number]) . '.pdf');
    } else {
      $pdf->save(public_path('assets/invoices/') . $invoice->invoice_number . '.pdf');
      return $invoice->invoice_number . '.pdf';
    }
  }

  public function sendemail($id)
  {

    $invoice = Invoice::whereId($id)->first();
    $this->pdf($id);
    Mail::to($invoice->customer_email)->send(new inin($invoice));
    return redirect()->route('invoice.index')->with([
      'message'    =>  __('messages.send_successfully'),
      'alert-type' => 'success'
    ]);
  }
}
