<?php

namespace App\Jobs;

use App\DTO\User\VerifyUserDTO;
use App\Mail\VerifyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private VerifyUserDTO $data)
    {
    }

    public function handle(): void
    {
        Mail::to($this->data->user)->send(new VerifyMail($this->data->code));
    }
}
