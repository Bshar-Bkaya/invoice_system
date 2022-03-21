@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{asset('frontend/css/sweetalert2.min.css')}}">
@endsection

@section('content')

<div class="row d-flex justify-content-center">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title text-center">{{__('messages.invoices')}}</h3>
        <a href="{{route('invoice.create')}}" class="btn btn-primary ml-auto">
          <i class="fa fa-plus"></i>
          {{__('messages.add_another_invoice')}}
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-hover card-table">
          <thead>
            <tr>
              <th>{{__('messages.Customer Name')}}</th>
              <th>{{__('messages.Invoice Date')}}</th>
              <th>{{__('messages.Total')}}</th>
              <th>{{__('messages.Action')}}</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($all_invoices as $invoice)
            <tr id="tr{{$invoice->id}}">
              <td><a href="{{route('invoice.show',$invoice->id)}}">{{$invoice->customer_name}}</a></td>
              <td>{{$invoice->invoice_date}}</td>
              <td>{{number_format($invoice->total_due,2)}}</td>
              <td>
                <a href="{{route('invoice.edit',$invoice->id)}}" class="btn btn-primary btn-sm"
                  title="{{__('messages.Edit')}}">
                  <i class="fa fa-edit"></i>
                </a>
                <span class="btn btn-danger btn-sm" title="{{__('messages.delete')}}"
                  onclick="delInvoice({{$invoice->id}})">
                  <i class="fa fa-trash"></i>
                </span>

                {{-- Start Form To Delete Invoice --}}
                <form id="form-{{$invoice->id}}" action="{{route('invoice.delete',$invoice->id)}}" method="get"
                  class="d-none">
                  @csrf
                </form>
                {{-- End Form To Delete Invoice --}}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="d-flex justify-content-center">
  {{ $all_invoices->links('pagination::bootstrap-4') }}
</div>
@endsection

@section('script')

<script>
  function delInvoice(id){

    Swal.fire({
      title: "{{__('messages.are You sure?')}}",
      text: "{{__('messages.you_will_delete_this_invoice')}}",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "{{__('messages.yes_delete_it')}}",
      cancelButtonText: "{{__('messages.no_keep_it')}}",
    }).then((result) => {
      if (result.value) {
        Swal.fire("{{__('messages.deleted')}}", "{{__('messages.message_alert_delete')}}", "success");
        let del = document.getElementById('form-'+id);
        del.submit();
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire("{{__('messages.cancelled')}}", "{{__('messages.message_alert_cancel')}}", "error");
      }
    });
  }
</script>

<script src="{{ asset('frontend/js/sweetalert2.all.min.js') }}"></script>

@endsection
