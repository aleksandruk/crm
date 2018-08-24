<?php
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Message;
use App\Events\NewMessageNotification;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;

 
class MessageController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
 
    public function index()
    {
        $user_id = Auth::user()->id;
        $data = array('user_id' => $user_id);
 
        return view('Admin\broadcast\broadcast', $data);
    }
 
    public function send()
    {   
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->name;
         
        // message is being sent
        $message = new Message;
        $message->setAttribute('from', $user_id);
        $message->setAttribute('to', 3);
        $message->setAttribute('message', 'Нове повідомлення від користувача: '.$user_name);
        $message->save();
        //$user = DB::table('users')->where('id', $user_id)->first();
        //$user = $user->name;
        // want to broadcast NewMessageNotification event
        event(new NewMessageNotification($message));
         
        // ...
    }
}