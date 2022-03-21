<!DOCTYPE html>
<html lang="{{config('app.locale')}}">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>

    @if (config('app.locale') == 'ar')
    <style>
      body {
        direction: rtl;
      }

    </style>
    @endif

    <style>
      body {
        font-family: 'XBRiyaz', sans-serif;
      }

      .styled-table {
        border-collapse: collapse;
        margin: auto;
        font-size: 0.9em;
        /* font-family: sans-serif; */
        min-width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
      }

      .styled-table thead tr {
        background-color: #b4b4b4;
        color: #ffffff;
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

      .styled-table .bold {
        font-weight: bold;
      }

      .styled-table .bg {
        background-color: #eee;
      }

    </style>
  </head>

  <body>
    <table class="styled-table">
      <thead>
        <tr>
          <th colspan="6" class="text-center">{{__('messages.information')}}</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>{{__('messages.Customer Name')}}</th>
          <td colspan="2">{{$invoice->customer_name}}</td>
          <th>{{__('messages.Customer Email')}}</th>
          <td colspan="2">{{$invoice->customer_email}}</td>
        </tr>
        <tr>
          <th>{{__('messages.Customer Mobile')}}</th>
          <td colspan="2">{{$invoice->customer_mobile}}</td>
          <th>{{__('messages.Company Name')}}</th>
          <td colspan="2">{{$invoice->company_name}}</td>
        </tr>
        <tr>
          <th>{{__('messages.Invoice Number')}}</th>
          <td colspan="2">{{$invoice->invoice_number}}</td>
          <th>{{__('messages.Invoice Date')}}</th>
          <td colspan="2">{{$invoice->invoice_date}}</td>
        </tr>
      </tbody>

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
      <tfoot style="background-color: rgba(238, 238, 238, 0.3)">
        <tr>
          <th colspan="3"></th>
          <th colspan="2">{{__('messages.Subtotal')}}</th>
          <td class="bold">{{$invoice->sub_total}}</td>
        </tr>
        <tr>
          <th colspan="3"></th>
          <th colspan="2">{{__('messages.Discount')}}</th>
          <td class="bold">{{$invoice->discountResult()}}</td>
        </tr>
        <tr>
          <th colspan="3"></th>
          <th colspan="2">{{__('messages.Vat')}}</th>
          <td class="bold">{{$invoice->vat_value}}</td>
        </tr>
        <tr>
          <th colspan="3"></th>
          <th colspan="2">{{__('messages.Shipping')}}</th>
          <td class="bold">{{$invoice->shipping}}</td>
        </tr>
        <tr>
          <th colspan="3"></th>
          <th colspan="2" class="bg">{{__('messages.Total Due')}}</th>
          <td class="bold bg">{{$invoice->total_due}}</td>
        </tr>
      </tfoot>
    </table>
  </body>

</html>
