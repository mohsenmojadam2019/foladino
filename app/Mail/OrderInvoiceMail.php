<?php
namespace App\Mail;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class OrderInvoiceMail extends Mailable implements ShouldQueue { use Queueable, SerializesModels; public function __construct(public PurchaseOrder $order) {} public function build(){ $pdf=Pdf::loadView('invoice',['order'=>$this->order])->setPaper('a4'); return $this->subject('فاکتور سفارش '.$this->order->order_number)->view('emails.invoice')->with(['order'=>$this->order])->attachData($pdf->output(),($this->order->order_number ?: 'invoice').'.pdf',['mime'=>'application/pdf']); } }
