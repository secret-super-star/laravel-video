<?php

namespace App\Jobs;

use App\Mail\MassEmail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class MassEmails implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	public $content;
	
	public $subject;
	
	public $user;
	
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($content, $subject, $users)
	{
		$this->content = $content;
		$this->subject = $subject;
		$this->user = $users;
;
	}
	
	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$when = Carbon::now()->addMinutes(1);
		foreach ($this->user as $key=> $val) {
			\Log::info($val->email);
			Mail::to($val->email)
				->queue(new MassEmail($this->content, $this->subject));
		}
	}
}
