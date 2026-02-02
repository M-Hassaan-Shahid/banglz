<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductBackInStockMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $variation;

    public function __construct($product, $variation = null)
    {
        $this->product = $product;
        $this->variation = $variation;
    }

    public function build()
    {
        return $this->subject('🎉 Back in Stock: ' . $this->product->name)
            ->view('emails.products.back_in_stock')
            ->with([
                'product'   => $this->product,
                'variation' => $this->variation,
            ]);
    }
}
