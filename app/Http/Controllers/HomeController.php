<?php

namespace App\Http\Controllers;

use App\Jobs\SendMails;
use App\Jobs\TestJobs;
use App\Mail\TestMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function testemail()
    {
        $emails = User::where('id', '<', 1000)->chunk(100, function ($users) {
            dispatch(new SendMails($users));
        });
        return 'send emails';
        /*$users = User::all();
        foreach ($users as $user) {
            if ($user->id != 2) {
                echo $user->email . "<br>";
                Mail::to($user->email)->send(new TestMail);
            }
        }*/
    }


    public function testjobs()
    {
        $emails = User::where('id', '<', 10)->chunk(50, function ($users) {
            dispatch(new TestJobs($users));
        });
        return 'test jobs';
    }
}