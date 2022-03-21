@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('frontend/css/pickadate/classic.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/css/pickadate/classic.date.css')}}">
{{-- <link rel="stylesheet" href="{{ asset('frontend/css/pickadate/classic.time.css')}}"> --}}
@if (config('app.locale') == 'ar')
<link rel="stylesheet" href="{{ asset('frontend/css/pickadate/rtl.css')}}">
@endif
@endsection

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
        <form action="{{route('invoice.update',$invoice->id)}}" method="post" class="form">
          @csrf
          @method('PATCH')
          <div class="row">
            <div class="col-4">
              <div class="form-group">
                <label for="customer_name">{{ __('messages.Customer Name')}}</label>
                <input type="text" name="customer_name" class="form-control"
                  value="{{ old('customer_name',$invoice->customer_name) }}">
                @error('customer_name')
                <span class=" help-block text-danger">
                  {{$message}}
                </span>
                @enderror
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label for="customer_email">{{ __('messages.Customer Email') }}</label>
                <input type="text" name="customer_email" class="form-control"
                  value="{{ old('customer_email',$invoice->customer_email) }}">
                @error('customer_email')
                <span class="help-block text-danger">
                  {{$message}}
                </span>
                @enderror
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label for="customer_mobile">{{ __('messages.Customer Mobile') }}</label>
                <input type="text" name="customer_mobile" class="form-control"
                  value="{{ old('customer_mobile',$invoice->customer_mobile) }}">
                @error('customer_mobile')
                <span class="help-block text-danger">
                  {{$message}}
                </span>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-4">
              <div class="form-group">
                <label for="company_name">{{__('messages.Company Name')}}</label>
                <input type="text" name="company_name" class="form-control"
                  value="{{ old('company_name',$invoice->company_name) }}">
                @error('company_name')
                <span class="help-block text-danger">
                  {{$message}}
                </span>
                @enderror
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label for="invoice_number">{{__('messages.Invoice Number')}}</label>
                <input type="text" name="invoice_number" class="form-control"
                  value="{{ old('invoice_number',$invoice->invoice_number) }}">
                @error('invoice_number')
                <span class="help-block text-danger">
                  {{$message}}
                </span>
                @enderror
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label for="invoice_date">{{__('messages.Invoice Date')}}</label>
                <input type="text" name="invoice_date" class="form-control pickadate"
                  value="{{ old('invoice_date',$invoice->invoice_date) }}">
                @error('invoice_date')
                <span class="help-block text-danger">
                  {{$message}}
                </span>
                @enderror
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table" id="invoice-details">
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

              <tbody id="product-container">
                @foreach ($invoice->invoice_details as $item)
                <tr id="product-tr{{$loop->index}}">
                  <td>
                    @if ($loop->index == 0)
                    {{'#'}}
                    @else
                    <span class="btn btn-danger btn-sm" onclick="deleteProduct({{$loop->index}})">
                      <i class="fa fa-minus"></i>
                    </span>
                    @endif
                  </td>
                  <td>
                    <input required type="text" name="product_name[]" class="prduct-name form-control"
                      value="{{old('product_name.0',$item->product_name)}}">
                    @error('product_name')
                    <span class="help-block text-danger">
                      {{$message}}
                    </span>
                    @enderror
                  </td>
                  <td>
                    <select required name="unit[]" class="unit form-control" id="unit1" onchange="calcul(1)">
                      <option value=""></option>
                      <option value="piece" {{$item->unit == 'piece' ? 'selected' : '' }}>Piece</option>
                      <option value="g" {{$item->unit == 'g' ? 'selected' : '' }}>Gram</option>
                      <option value="kg" {{$item->unit == 'kg' ? 'selected' : '' }}>Kilo Gram</option>
                    </select>
                    @error('unit')
                    <span class="help-block text-danger">
                      {{$message}}
                    </span>
                    @enderror
                  </td>
                  <td>
                    <input type="number" step="0.01" name="unit_price[]" id="price1" min="0"
                      value="{{old('unit_price.0',$item->unit_price)}}" class="unit-price form-control"
                      onkeyup="calcul(1)" onchange="calcul(1)">
                    @error('unit-price')
                    <span class=" help_block text-danger">
                      {{$message}}
                    </span>
                    @enderror
                  </td>
                  <td>
                    <input required type="number" step="0.01" name="quantity[]" id="quantity1" min="0"
                      value="{{old('quantity.0',$item->quantity)}}" class="quantity form-control" onkeyup="calcul(1)"
                      onchange="calcul(1)">
                    @error('quantity')
                    <span class="help-block text-danger">
                      {{$message}}
                    </span>
                    @enderror
                  </td>
                  <td>
                    <input required type="number" step="0.01" name="row_sub_total[]" id="rowsubtotal1"
                      value="{{old('row_sub_total.0',$item->row_sub_total)}}" class="row-sub-total form-control"
                      readonly>
                    @error('row_sub_total')
                    <span class="help-block text-danger">
                      {{$message}}
                    </span>
                    @enderror
                  </td>
                </tr>
                @endforeach
              </tbody>


              <tfoot>
                <td colspan="6">
                  <button type="button" class="btn-add btn btn-primary">{{__('messages.add_another_product')}}</button>
                </td>

                <tr>
                  <td colspan="3"></td>
                  <td colspan="2">{{__('messages.Subtotal')}}</td>
                  <td><input type="number" step="0.01" name="sub_total" class="sub-total form-control" id="sub-total"
                      value="{{old('sub_total',$invoice->sub_total)}}" readonly>
                  </td>
                </tr>
                <tr class="discount-tr">
                  <td colspan="3"></td>
                  <td colspan="2">{{__('messages.Discount')}}</td>
                  <td>
                    <div class="input-group mb-3">
                      <select name="discount_type" id="discount-type" class="custom-select discount-type"
                        onchange="calcul(1)" value="{{old('discount_type',$invoice->discount_type)}}">
                        <option value="fixed" {{$invoice->discount_type == 'fixed' ? 'selected' : '' }} title="fixed"
                          onkeyup="calcul(1)">{{__('messages.SB')}}</option>
                        <option value="percentage" {{$invoice->discount_type == 'percentage' ? 'selected' : '' }}
                          title="(%)">{{__('messages.Percentage')}}</option>
                      </select>
                      <div class="input-group-append">
                        <input type="number" step="0.01" name="discount_value" id="discount-value"
                          value="{{old('discount_value',$invoice->discount_value)}}" class="discount-value form-control"
                          onkeyup="calcul(1)" onchange="calcul(1)">
                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td colspan="3"></td>
                  <td colspan="2">{{__('messages.Vat')}}</td>
                  <td>
                    <input type="number" step="0.01" name="vat_value" id="vat-value" class="vat-value form-control"
                      value="{{old('vat_value',$invoice->vat_value)}}" readonly>
                  </td>
                </tr>
                <tr class="shipping-tr">
                  <td colspan="3"></td>
                  <td colspan="2">{{__('messages.Shipping')}}</td>
                  <td>
                    <input type="number" step="0.01" name="shipping" id="shipping" class="shipping form-control"
                      value="{{ old('shipping',$invoice->shipping)}}" onkeyup="calcul(1)" onchange="calcul(1)">
                  </td>
                </tr>
                <tr>
                  <td colspan="3"></td>
                  <td colspan="2">{{__('messages.Total Due')}}</td>
                  <td>
                    <input type="number" step="0.01" name="total_due" id="total-due" class="total-due form-control"
                      value="{{old('total_due',$invoice->total_due)}}" readonly>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>

          <div class="text-right pt-3">
            <button type="submit" name="save" class="btn btn-primary">{{__('messages.update')}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
{{-- For pickadate --}}
<script src="{{asset('frontend/js/pickadate/picker.js')}}"></script>
<script src="{{asset('frontend/js/pickadate/picker.date.js')}}"></script>
<script src="{{asset('frontend/js/pickadate/picker.time.js')}}"></script>
@if (config('app.locale')=='ar')
<script src="{{asset('frontend/js/pickadate/ar.js')}}"></script>
@endif


<script>
  // Start Handle Date
  let invoiceDate = document.getElementsByClassName('pickadate')[0];
  window.onload = function(){
    $('.pickadate').pickadate({
      format: 'yyyy-mm-dd',
      selectMonth: true,
      selectYear: true,
      clearDate: true,
      close: "OK",
      closeOnClick: true
    });
  };
  // End Handle Date

  // -------- Start Footer Variable----------//
  // Start ADD Another Product
  let btnAddProduct = document.getElementsByClassName('btn-add')[0];
  let productContainer = document.getElementById('product-container');
  btnAddProduct.addEventListener('click',() => {
    let indexinc = Math.floor(Math.random() * 1000000000);
    console.log(indexinc);
    let newTr = document.createElement('tr');
    newTr.id = `product-tr${indexinc}`;
    newTr.innerHTML = `
        <td>
          <button class="btn btn-danger btn-sm" onclick="deleteProduct(${indexinc})"><i class="fa fa-minus"></i></button>
        </td>
        <td>
          <input required type="text" name="product_name[]" class="prduct-name form-control" value="{{old('product_name.${indexinc-1}')}}">
          @error('product-name')
          <span class="help-block text-danger">
            {{$message}}
          </span>
          @enderror
        </td>
        <td>
          <select required name="unit[]" class="unit form-control" id="unit${indexinc}" onchange="calcul(${indexinc})">
            <option value=""></option>
            <option value="piece">Piece</option>
            <option value="g">Gram</option>
            <option value="kg">Kilo Gram</option>
          </select>
          @error('unit')
          <span class="help-block text-danger">
            {{$message}}
          </span>
          @enderror
        </td>
        <td>
          <input required type="number" step="0.01" name="quantity[]" id="quantity${indexinc}" class="quantity form-control" value="{{old('quantity.${indexinc-1}')}}"
            onkeyup="calcul(${indexinc})" onchange="calcul(${indexinc})" >
          @error('quantity')
          <span class="help-block text-danger">
            {{$message}}
          </span>
          @enderror
        </td>
        <td>
          <input required type="number" step="0.01" name="unit_price[]" id="price${indexinc}" class="unit-price form-control"
            value="{{old('unit_price.${indexinc-1}')}}" onkeyup="calcul(${indexinc})" onchange="calcul(${indexinc})">
          @error('unit-price')
          <span class="help-block text-danger">
            {{$message}}
          </span>
          @enderror
        </td>
        <td>
          <input type="number" step="0.01" name="row_sub_total[]" id="rowsubtotal${indexinc}" class="row-sub-total form-control" readonly>
          @error('row-sub-total')
          <span class="help-block text-danger">
            {{$message}}
          </span>
          @enderror
        </td>
    `;
    productContainer.appendChild(newTr);
  });
  // EndADD Another Product

  let subTotal = document.getElementById('sub-total');// The Sum To All rowSupTotal
  let discountValue = document.getElementById('discount-value');
  let discountType = document.getElementById('discount-type');
  let vat = document.getElementById('vat-value');
  let shipping = document.getElementById('shipping');
  let totalDue = document.getElementById('total-due');
  // -------- End Footer Variable----------//



  function calcSupTotalVal() {
    let rowSupTotal = document.querySelectorAll('.row-sub-total');
    let sumSupTotal = 0;
    rowSupTotal.forEach((e) => {
    sumSupTotal = sumSupTotal + Number(e.value?e.value:0);
    });
    subTotal.value = sumSupTotal.toFixed(2);
    return String(sumSupTotal.toFixed(2));
  }

  function discount(){
    let discountTypeVal = discountType.value;
    let discountValueVal = discountValue.value || 0;
    let subTotalVal = Number(subTotal.value) || 0;
    let discount = 0;
    if(discountValueVal != 0){
      if(discountTypeVal == "percentage"){
        discount = subTotalVal * (discountValueVal/100);
      } else {
        discount = discountValueVal;
      }
    } else {
      discount = 0;
    }
    return discount;
  }

  function calcVat(discount) {
    let subTotalVal = Number(subTotal.value) || 0 ;
    let vatVal = (subTotalVal - discount) * 0.05;
    vat.value = vatVal.toFixed(2);
    return vatVal.toFixed(2);
  }

  function calcTotalDue(discount){
    let sum = 0;
    let subTotalVal = Number(subTotal.value) || 0 ;
    let vatVal = Number(vat.value) || 0;
    let shippingVal = Number(shipping.value) || 0;

    sum += subTotalVal;
    sum -= discount;
    sum += vatVal;
    sum += shippingVal;

    totalDue.value = sum.toFixed(2);

    return sum.toFixed(2);
  }

  function deleteProduct(id) {
    let deleteProductTr = document.getElementById('product-tr'+id);
    deleteProductTr.remove();

    calcSupTotalVal();
    let dis = discount();
    calcVat(dis);
    calcTotalDue(dis);
  }

  function calcul(id){
    let quantity = document.getElementById('quantity'+id).value;
    let unit_price = document.getElementById('price'+id).value;
    let sub_total = document.getElementById('rowsubtotal'+id).value;
    let totalsub = document.getElementById('sub-total').value;
    let shipping = document.getElementById('shipping').value;
    let vat = document.getElementById('vat-value').value;
    if(quantity=='' || unit_price==''){
      document.getElementById('rowsubtotal'+id).value=0;
    }else{
      document.getElementById('rowsubtotal'+id).value = quantity * unit_price;
    }
    calcSupTotalVal();
    let dis = discount();
    calcVat(dis);
    calcTotalDue(dis);
  }
</script>
@endsection
