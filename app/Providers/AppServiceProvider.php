<?php

namespace App\Providers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use App\Comment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Comment::created(function($c){

            $this->alert($c);
        });
        Comment::updated(function($c){
            $this->alert($c);
        });
        Comment::deleted(function($c){
            $c->status="Supprime";
            $this->alert($c);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function alert(Comment $c){
        $to= env("MAIL_USERNAME");
        Mail::send(['emails.alert','emails.alert-text'],['comment' => $c],function($message) use ($c,$to){

            $message->to($to)
                ->subject($c->title." ( Speedy-click commentaire )");
        });
    }
}
