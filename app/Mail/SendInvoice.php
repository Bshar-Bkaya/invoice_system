<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvoice extends Mailable
{
  use Queueable, SerializesModels;

  public $invoice;
  public $invoice_details;
  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($invoice)
  {
    $this->invoice = $invoice;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $invoice = $this->invoice;
    return $this->subject(__('messages.email_subject'))->view('layouts.email', compact('invoice'))
      ->attach(public_path('assets/invoices/' . $this->invoice->invoice_number . '.pdf'));
  }
}
