<?php

namespace App\Mail;

use App\Models\DonHang;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirm extends Mailable
{
    use Queueable, SerializesModels;
    public $donHang;

    /**
     * Create a new message instance.
     */
    public function __construct(DonHang $donHang)
    {
        $this->donHang = $donHang;
    }

  
   public function build()
    {
        return $this->subject('Xác nhận đơn hàng')
        ->markdown('clients.donhangs.mail')
        ->with('donHang', $this->donHang);
    }
}
