<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sampleEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $input;
    public $verification_token;

    public function __construct($input, $verification_token)
    {
        $this->input = $input;
        $this->verification_token = $verification_token;
    }

    public function build()
    {
        return $this->view('email.sample');        
    }
}
