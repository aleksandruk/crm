<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Comment;
use App\Events\NewCommentNotification;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use DateTime;

class CommentsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        $data = array('user_id' => $user_id);
 
        return view('Admin\comments\comments', $data);

    }

    public function update()
    {   
         
        // добавляємо в БД новий комент з Falcon

        $today = date("Y-m-d");
        $dt = new DateTime($today);
        
        $data = DB::connection('pgsql')->select("SELECT KOM.NUM_FAK,FAK.NR_RACH,FAK.KOM,KOM.OPIS,KOM.OP1,KOM.OP2,KOM.OP3,KOM.OP4,KOM.OP5,CUSTOM.SKR FROM FAK AS FAK,KOM AS KOM,CUSTOM AS CUSTOM WHERE KOM.NUM_FAK = FAK.NUMER AND KOM.LASTMOD BETWEEN '{$dt->format('Y-m-d')}' AND '{$dt->format('Y-m-t')}' AND FAK.OKEJKA = TRUE AND FAK.KL = CUSTOM.NUMER AND FAK.TYP LIKE '%DD%' AND FAK.MG LIKE '%01%'");

        foreach ($data as $key => $item) {
            if ($item->opis == "     0.00                     ") {
                unset($data[$key]);
            }
        }
        $clean_data = $data;
        foreach ($clean_data as $key => $item) {
            $num_fak = trim($item->num_fak);
            $сlient = trim($item->skr);
            $disp = trim($item->nr_rach);
            $str = ($item->kom == '') ? '' : trim($item->opis).'|';
            $str .= ($item->opis == '') ? '' : trim($item->opis).'|';
            $str .= ($item->op1 == '') ? '' : trim($item->op1).'|';
            $str .= ($item->op2 == '') ? '' : trim($item->op2).'|';
            $str .= ($item->op3 == '') ? '' : trim($item->op3).'|';
            $str .= ($item->op4 == '') ? '' : trim($item->op4);
            $string = implode(' ',array_unique(explode('|', $str)));
            $priority = trim($item->op5);

             if (!Comment::where('num_fak', '=', $num_fak)->first()) {
                $comment = new Comment;
                $comment->num_fak = $num_fak;
                $comment->сlient = $сlient.' | '.$disp;
                $comment->comment = $string;
                $comment->priority = $priority;
                $comment->archive = 0;
                $comment->save();

                //dd($comment);
                event(new NewCommentNotification($comment));
             }
        }
    }
}
