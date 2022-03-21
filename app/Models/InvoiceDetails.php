<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
  use HasFactory;

  public $fillable = ['product_name', 'unit', 'quantity', 'unit_price', 'row_sub_total', 'invoice_id'];
  protected $hidden = ['created_at', 'updated_at'];
  public $timestamps = true;

  public function invoice()
  {
    return $this->belongsTo('app\Models\Invoice', 'invoice_id', 'id');
  }
}
