<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $info;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email1 = $this->info['email1'];
        $email2 = $this->info['email2'];
        $num1 = $this->info['num1'];
        $num2 = $this->info['num2'];
        $text = $this->info['text'];

        // send mail
        Mail::send('emails.absenceEmail', ['text' => $text], function($message) use ($email1, $email2){
            if ($email1) {
                $message->to($email1);
            }
            if ($email2){
                $message->cc($email2);
            }
            $message->subject('ABSENCIA');
        });

        // send sms
        if($num1){
            $client = Http::withHeaders([
                'auth_token'=>config('services.sms.token'),
                'Content-Type'=>'application/json'
            ])->post(config('services.sms.url'), [
                'email'=> 'davidksolome2@gmail.com',
                'country'=> 'TG',
                'phone_number'=> $num1,
                'message'=> $text,
                'response_url'=> 'https://webhook.site/9ea64d5a-65a3-4939-8455-cf3946436f7f'
            ]);
        }
        if($num2){
            $client = Http::withHeaders([
                'auth_token'=>config('services.sms.token'),
                'Content-Type'=>'application/json'
            ])->post(config('services.sms.url'), [
                'email'=> 'davidksolome2@gmail.com',
                'country'=> 'TG',
                'phone_number'=> $num2,
                'message'=> $text,
                'response_url'=> 'https://webhook.site/9ea64d5a-65a3-4939-8455-cf3946436f7f'
            ]);
        }
    }
}
