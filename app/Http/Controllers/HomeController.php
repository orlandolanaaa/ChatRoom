<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\ChatSent;
use Illuminate\Mail\Message;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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

    public function sendMessage(Request $request)
    {
        $message =$request->user()->chats()->create([
                    'message' => $request->message
                  ]);
                //   dd();
        broadcast(new ChatSent($message->load('user')))->toOthers();
        return ['status'=>'success'];
    }
}
