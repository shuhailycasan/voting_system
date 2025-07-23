<?php

namespace App\Jobs;

use App\Mail\VoteThankYouMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendThankYouEmail implements ShouldQueue
{
    use Queueable, Dispatchable,InteractsWithQueue,SerializesModels;

    protected $email;
    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new VoteThankYouMail($this->user));
    }
}
