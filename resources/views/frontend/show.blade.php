@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex">
        <h2>{{__('messages.Invoice',['invoice_number' => $invoice->invoice_number])}}</h2>
        <a href="{{route('invoice.index')}}" class="btn btn-primary ml-auto"><i class="fa fa-home"></i>
          {{__('messages.back to home')}}</a>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table">

            <tr>
              <th>{{__('messages.Customer Name')}}</th>
              <td>{{$invoice->customer_name}}</td>
              <th>{{__('messages.Customer Email')}}</th>
              <td>{{$invoice->customer_email}}</td>
            </tr>
            <tr>
              <th>{{__('messages.Customer Mobile')}}</th>
              <td>{{$invoice->customer_mobile}}</td>
              <th>{{__('messages.Company Name')}}</th>
              <td>{{$invoice->company_name}}</td>
            </tr>
            <tr>
              <th>{{__('messages.Invoice Number')}}</th>
              <td>{{$invoice->invoice_number}}</td>
              <th>{{__('messages.Invoice Date')}}</th>
              <td>{{$invoice->invoice_date}}</td>
            </tr>
          </table>
          <table class="table">
            <thead>
              <tr>
                <th></th>
                <th>{{__('messages.Product Name')}}</th>
                <th>{{__('messages.Unit')}}</th>
                <th>{{__('messages.Unit Price')}}</th>
                <th>{{__('messages.Quantity')}}</th>
                <th>{{__('messages.Rowsubtotal')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($invoice->invoice_details as $item)
              <tr>
                <th>{{ $loop->iteration }}</th>
                <td>{{$item->product_name}}</td>
                <td>{{$item->unit}}</td>
                <td>{{$item->unit_price}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{number_format($item->row_sub_total)}}</td>
              </tr>
              @endforeach
            </tbody>
            <tfoot style="background-color: rgba(238, 238, 238, 0.4)">
              <tr>
                <th colspan="3"></th>
                <th colspan="2">{{__('messages.Subtotal')}}</th>
                <td class="font-weight-bold">{{number_format($invoice->sub_total,2)}}</td>
              </tr>
              <tr>
                <th colspan="3"></th>
                <th colspan="2">{{__('messages.Discount')}}</th>
                <td class="font-weight-bold">{{$invoice->discountResult()}}</td>
              </tr>
              <tr>
                <th colspan="3"></th>
                <th colspan="2">{{__('messages.Vat')}}</th>
                <td class="font-weight-bold">{{number_format($invoice->vat_value,2)}}</td>
              </tr>
              <tr>
                <th colspan="3"></th>
                <th colspan="2">{{__('messages.Shipping')}}</th>
                <td class="font-weight-bold">{{number_format($invoice->shipping,2)}}</td>
              </tr>
              <tr>
                <th colspan="3"></th>
                <th colspan="2">{{__('messages.Total Due')}}</th>
                <td class="font-weight-bolder">{{number_format($invoice->total_due,2)}}</td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <a href="{{route('invoice.print', $invoice->id)}}" class="btn btn-primary btn-sm ml-auto">
              <i class="fa fa-print"></i> {{__('messages.print_the_invoice')}}
            </a>
            <a href="{{route('invoice.pdf', $invoice->id)}}" class="btn btn-secondary btn-sm ml-auto">
              <i class="fa fa-file-pdf"></i> {{__('messages.export_invoice_pdf')}}</a>
            <a href="{{route('invoice.sendEmail',$invoice->id)}}" class="btn btn-success btn-sm ml-auto"><i class="fa fa-envelope"></i>
              {{__('messages.send_to_email')}}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
