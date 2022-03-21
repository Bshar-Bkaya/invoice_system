@extends('layouts.print')

@section('style')
<style>
  .styled-table {
    border-collapse: collapse;
    margin: auto;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
  }

  .styled-table thead tr {
    background-color: #b4b4b4;
    color: #000000;
  }

  .styled-table th,
  .styled-table td {
    padding: 12px 15px;
  }

  .styled-table th,
  .styled-table tfoot td {
    text-align: center;
  }

  .styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
    text-align: center;
  }

  .styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
  }

  .styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #6d6d6d;
  }

</style>
@endsection

@section('content')

<div class="row justify-content-center">
  <div class="col-12">
    <div class="card">
      <div class="card-header text-center">
        <h2>{{__('messages.Invoice',['invoice_number' => $invoice->invoice_number])}}</h2>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table styled-table">
            <thead>
              <tr>
                <th colspan="4" class="text-center">{{__('messages.information')}}</th>
              </tr>
            </thead>
            <tbody>
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
            </tbody>
          </table>
          <table class="table styled-table">
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
                <td>{{$item->row_sub_total}}</td>
              </tr>
              @endforeach
            </tbody>
            <tfoot style="background-color: rgba(238, 238, 238, 0.4)">
              <tr>
                <th colspan="3"></th>
                <th colspan="2">{{__('messages.Subtotal')}}</th>
                <td class="font-weight-bold">{{$invoice->sub_total}}</td>
              </tr>
              <tr>
                <th colspan="3"></th>
                <th colspan="2">{{__('messages.Discount')}}</th>
                <td class="font-weight-bold">{{$invoice->discountResult()}}</td>
              </tr>
              <tr>
                <th colspan="3"></th>
                <th colspan="2">{{__('messages.Vat')}}</th>
                <td class="font-weight-bold">{{$invoice->vat_value}}</td>
              </tr>
              <tr>
                <th colspan="3"></th>
                <th colspan="2">{{__('messages.Shipping')}}</th>
                <td class="font-weight-bold">{{$invoice->shipping}}</td>
              </tr>
              <tr>
                <th colspan="3"></th>
                <th colspan="2">{{__('messages.Total Due')}}</th>
                <td class="font-weight-bolder">{{$invoice->total_due}}</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')

<script>
  window.print();
</script>

@endsection
