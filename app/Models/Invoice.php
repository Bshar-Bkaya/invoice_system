<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InvoiceDetails;

class Invoice extends Model
{
  use HasFactory;

  // protected $table = "invoices";

  protected $fillable = [
    'id', 'user_id',
    'customer_name', 'customer_email', 'customer_mobile', 'company_name', 'invoice_number', 'invoice_date',
    'sub_total', 'discount_type', 'discount_value', 'vat_value', 'shipping', 'total_due'
  ];

  protected $hidden = ['created_at', 'updated_at'];
  public $timestamps = true;


  //--------- Relation : One(invoice) ===> many(invoice details)---------//
  public function invoice_details()
  {
    return $this->hasMany('App\Models\InvoiceDetails', 'invoice_id');
    // OR ==> return $this->hasMany('InvoiceDetails::class', 'invoice_id');
  }

  public function user()
  {
    return $this->belongsTo('app\Models\User', 'user_id', 'id');
  }

  public function discountResult()
  {
    return $this->discount_type == 'fixed' ? $this->discount_value : $this->discount_value . " %";
  }
}
