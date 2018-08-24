<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Silber\Bouncer\Database\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use DB;
use DateTime;

class ExpressDeliveryController extends Controller
{
    public function show() {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $today = date("Y-m-d");
        $dt = new DateTime($today);
        
        $data = DB::connection('pgsql')->select("SELECT FAK.KOM,KOM.OPIS,KOM.OP1,KOM.OP2,KOM.OP3,KOM.OP4,KOM.OP5,CUSTOM.SKR FROM FAK AS FAK,KOM AS KOM,CUSTOM AS CUSTOM WHERE KOM.NUM_FAK = FAK.NUMER AND KOM.DATA BETWEEN '{$dt->format('Y-m-d')}' AND '{$dt->format('Y-m-t')}' AND FAK.OKEJKA = TRUE AND FAK.KL = CUSTOM.NUMER AND FAK.TYP LIKE '%DD%' AND FAK.MG LIKE '%01%'");
        //dd($data);
        foreach ($data as $key => $item) {
        	$klient = $item->skr;
			$str = ($item->kom == '') ? '' : trim($item->opis).'|';
			$str .= ($item->opis == '') ? '' : trim($item->opis).'|';
			$str .= ($item->op1 == '') ? '' : trim($item->op1).'|';
			$str .= ($item->op2 == '') ? '' : trim($item->op2).'|';
			$str .= ($item->op3 == '') ? '' : trim($item->op3).'|';
			$str .= ($item->op4 == '') ? '' : trim($item->op4);
			//$str .= ($item->op5 == '') ? '' : trim($item->op5);
			$comment = implode(' ',array_unique(explode('|', $str)));
			$priority = trim($item->op5);

			$items[] = array('klient' => $klient, 'comment' => $comment, 'priority' => $priority);
        }
	    //dd($items);    

        //dd($result);
        return view('admin.express_delivery.index')->with('items', $items);
        //return view('user.index', ['users' => $users]);
    }
}
