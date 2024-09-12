<?php

namespace App\Jobs;

use App\Mail\VerifyMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private User $user, private string $code)
    {
        $this->onQueue('emails');
    }

    public function handle(): void
    {
        Mail::to($this->user)->send(new VerifyMail($this->code));
    }
}
