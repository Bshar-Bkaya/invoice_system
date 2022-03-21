@extends('layouts.app')

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
        </table>

        <div class="alert alert-dark d-flex justify-content-center" role="alert">
          {{ __('messages.no invoice yet') }}
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
