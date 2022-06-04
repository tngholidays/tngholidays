<?php
namespace Modules\Booking\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Booking\Models\Booking;

class VoucherEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {

        return $this->replyTo($this->data['from'], 'Reply To')->from($this->data['from'])->subject('Voucher')->view('Booking::emails.mail-voucher')->with([
            'booking' => $this->data['booking'],
            'row' => $this->data['row']
        ])->attachData($this->data['pdf'], 'voucher.pdf');
    }
}
