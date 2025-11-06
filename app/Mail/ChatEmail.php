<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChatEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $htmlBody;

    public function __construct(string $subjectLine, string $htmlBody)
    {
        $this->subjectLine = $subjectLine;
        $this->htmlBody = $htmlBody;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->html($this->htmlBody);
    }
}
