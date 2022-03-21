<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidationRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'customer_name'      => 'required',
      'customer_email'     => 'required|email',
      'customer_mobile'    => 'required|numeric',
      'company_name'       => 'required',
      'invoice_number'     => 'required|numeric',
      'invoice_date'       => 'required',
    ];
  }

  public function messages()
  {
    return [
      'customer_name.required'      => __('messages.customer_name.required'),
      'customer_email.required'     => __('messages.customer_email.required'),
      'customer_mobile.required'    => __('messages.customer_mobile.required'),
      'customer_mobile.numeric'     => __('messages.customer_mobile.numeric'),
      'company_name.required'       => __('messages.company_name.required'),
      'invoice_number.required'     => __('messages.invoice_number.required'),
      'invoice_number.numeric'      => __('messages.invoice_number.numeric'),
      'invoice_date.required'       => __('messages.invoice_date.required'),
    ];
  }
}
