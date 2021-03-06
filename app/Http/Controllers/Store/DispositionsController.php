<?php

namespace App\Http\Controllers\Store;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Response;
use App\Disposition;
use View;
use Carbon\Carbon;
use App\User;
use App\Storekeeper;
use DB;
use DateTime;
use App\Events\NewCommentNotification;
use Auth;
use GuzzleHttp\Client;

class DispositionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }

    protected $rules =
    [
        'nr_rach' => 'required',
        'client' => 'required',
        'comment' => 'required',
        'seats_amount' => 'required'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dispositions = Disposition::whereDate('created_at', Carbon::today())->where('status', 0)->orderBy('priority', 'desc')->orderBy('id', 'desc')->get();

        return view('store.dispositions.index', ['dispositions' => $dispositions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            $nr_rach = trim($item->nr_rach);
            $str = ($item->kom == '') ? '' : trim($item->opis).'|';
            $str .= ($item->opis == '') ? '' : trim($item->opis).'|';
            $str .= ($item->op1 == '') ? '' : trim($item->op1).'|';
            $str .= ($item->op2 == '') ? '' : trim($item->op2).'|';
            $str .= ($item->op3 == '') ? '' : trim($item->op3).'|';
            $str .= ($item->op4 == '') ? '' : trim($item->op4);
            $string = implode(' ',array_unique(explode('|', $str)));
            $priority = trim($item->op5);

             if (!Disposition::where('num_fak', '=', $num_fak)->first()) {
                $disposition = new Disposition;
                $disposition->num_fak = $num_fak;
                $disposition->nr_rach = $nr_rach;
                $disposition->client = $сlient;
                $disposition->comment = $string;
                $disposition->seats_amount = 0;
                $disposition->priority = $priority;
                $disposition->stock_time = null;
                $disposition->stock_id = null;
                $disposition->driver_time = null;
                $disposition->driver_id = null;
                $disposition->status = 0;
                $disposition->archive = 0;
                $disposition->save();

                //dd($comment);
                //працює//event(new NewCommentNotification($disposition));
             }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = Validator::make(Input::all(), $this->rules);
        // if ($validator->fails()) {
        //     return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        // } else {
        //     $disposition = new Disposition();
        //     $disposition->num_fak = $request->num_fak;
        //     $disposition->nr_rach = $request->nr_rach;
        //     $disposition->client = $request->client;
        //     $disposition->comment = $request->comment;
        //     $disposition->seats_amount = $request->seats_amount;
        //     $disposition->priority = $request->priority;
        //     //$disposition->stock_packed = $request->stock_packed;
        //     //$disposition->driver_received = $request->driver_received;
        //     $disposition->archive = $request->archive;
        //     $disposition->save();
        //     return response()->json($disposition);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $disposition = Disposition::findOrFail($id);
        return view('store.dispositions.show', ['disposition' => $disposition]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $disposition = Disposition::find($id);
        
        return view('store.dispositions.edit', ['disposition' => $disposition]);
        // $disposition = Disposition::findOrFail($id);
        // $disposition->num_fak = $request->num_fak;
        // $disposition->nr_rach = $request->nr_rach;
        // $disposition->client = $request->client;
        // $disposition->comment = $request->comment;
        // $disposition->seats_amount = $request->seats_amount;
        // $disposition->stock_time = $request->stock_time;
        // $disposition->stock_id = $request->stock_id;
        // $disposition->status = $request->status;
        // $disposition->save();
        // event(new NewCommentNotification($disposition));
        // return response()->json($disposition);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            //return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
            return redirect()->back()->with(['errors' => $validator->getMessageBag()->toArray()]);

        } 
        else {
            $disposition = Disposition::find($id);
            $disposition->nr_rach = $request->get('nr_rach');
            $disposition->client = $request->get('client');
            $disposition->comment = $request->get('comment');
            $disposition->seats_amount = $request->get('seats_amount');
            $disposition->stock_time = \Carbon\Carbon::now();
            $disposition->stock_id = Auth::user()->id;
            $disposition->status = 1;
            $disposition->save();
            //event(new NewCommentNotification($disposition));
            return redirect('store/dispositions')->with('message', 'Запис успішно оновлений');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $disposition = Disposition::findOrFail($id);
        $disposition->delete();
        return response()->json($disposition);
    }

    public function allPacks()
    {
        $dispositions = Disposition::whereDate('created_at', Carbon::today())->where('status', 1)->orderBy('priority', 'desc')->orderBy('id', 'desc')->get();
        return view('store.dispositions.allPacks', ['dispositions' => $dispositions]);
    }

    public function myPacks()
    {   
        $id = \Auth::user()->id;
        $dispositions = Disposition::whereDate('created_at', Carbon::today())->where('status', 1)->where('stock_id', $id)->orderBy('priority', 'desc')->orderBy('id', 'desc')->get();

        return view('store.dispositions.myPacks', ['dispositions' => $dispositions]);
    }

    public function packed()
    {   
        $dispositions = Disposition::whereDate('created_at', Carbon::today())->where('status', 1)->orderBy('priority', 'desc')->orderBy('stock_time', 'desc')->get();

        return view('store.dispositions.packed', ['dispositions' => $dispositions]);
    }

    public function getParcels()
    {
            $dispositions = Disposition::whereDate('created_at', Carbon::today())->where('status', 1)->orderBy('priority', 'desc')->orderBy('stock_time', 'desc')->get();

            return view('store.dispositions.getParcels', ['dispositions' => $dispositions]);      
    }

    public function driverUpdate(Request $request)
    {
        $disposition = Disposition::find(Input::get('id'));
        if ($disposition->driver_id) {
            return redirect()->back()->with(['errors' => 'Товар вже прийнятий водієм '.$disposition->driver->name]);
        }
        $disposition->driver_time = \Carbon\Carbon::now();
        $disposition->driver_id = Auth::user()->id;
        $disposition->status = 2;
        $disposition->save();
        //event(new NewCommentNotification($disposition));
        return redirect('store/dispositions/get_parcels')->with('message', 'Товар успішно прийнятий');
        
    }

    public function allParcels()
    {   
        $dispositions = Disposition::whereDate('created_at', Carbon::today())->where('status', '>', 1)->orderBy('status', 'asc')->orderBy('id', 'desc')->get();

        return view('store.dispositions.allParcels', ['dispositions' => $dispositions]);
    }

    public function myParcels()
    {   
        $id = \Auth::user()->id;
        $dispositions = Disposition::whereDate('created_at', Carbon::today())->where('driver_id', $id)->orderBy('priority', 'desc')->orderBy('id', 'desc')->get();

        return view('store.dispositions.myParcels', ['dispositions' => $dispositions]);
    }

    public function driverReport($id)
    {   
        $disposition = Disposition::find($id);
        //$disposition->report = json_decode($disposition->report, true);
        //dd($disposition);
        return view('store.dispositions.driverReport', ['disposition' => $disposition]);
    }

    public function driverReportUpdate(Request $request)
    {
        $disposition = Disposition::find(Input::get('id'));
        $options = $disposition->report;

        $options['bus_rout'] = $request->input('bus_rout');
        $options['state_number'] = $request->input('state_number');
        $options['arrival_time'] = $request->input('arrival_time');
        $options['note'] = $request->input('note');

        $disposition->report = $options;
        $disposition->report_time = \Carbon\Carbon::now();
        $disposition->status = 3;
        $disposition->save();

        $details = action('Admin\DispositionsController@shippedParcels');
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://autodimservice.com.ua/viber/bot.php', [
            'form_params' => [
                'receiverId' => '0boH7JWYTKLJ9e15KGSYzA',
                'message' => 'Замовлення № '.$disposition->nr_rach.' клієнта '.$disposition->client.' відправлено водієм '.$disposition->driver->name,
            ]
        ]);
        
        return redirect('store/dispositions/my_parcels')->with('message', 'Звіт успішно додано');
    }

    public function shippedParcels()
    {
        $dispositions = Disposition::whereDate('created_at', Carbon::today())->where('status', 3)->orderBy('status', 'asc')->orderBy('id', 'desc')->get();

        return view('store.dispositions.shippedParcels', ['dispositions' => $dispositions]);
    }

    public function info($id)
    {
        $disposition = Disposition::find($id);
        
        return view('store.dispositions.info', ['disposition' => $disposition]);
    }

    public function infoUpdate(Request $request)
    {
        $disposition = Disposition::find(Input::get('id'));
        $disposition->info_time = \Carbon\Carbon::now();
        $disposition->archive = true;
        $disposition->save();
        return redirect('store/dispositions/shipped_parcels')->with('message', 'Клієнта поінформовано');
    }
}
