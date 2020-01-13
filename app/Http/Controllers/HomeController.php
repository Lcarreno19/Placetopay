<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use App\Productos;
use App\User_orders;
use Auth;
use Dnetix\Redirection\PlacetoPay;
use Dnetix\Redirection\Contracts\Gateway;
use Dnetix\Redirection\Carrier\Authentication;
use Redirect;

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
        $ordenes = Orders::where([
            ['iduser', Auth::user()->id],
            ['consultada', '=', 0],
        ])->Paginate(10);
        foreach ($ordenes as $orders) {
            if ($orders->requestid > 0) {
                try {
                    $response = $this->placetopay()->query($orders->requestid);
                    if ($response->isSuccessful()) {
                        // In order to use the functions please refer to the RedirectInformation class
                        if ($response->status()->status() === 'APPROVED') {
                            $actualizar  = Orders::where('idorders', $orders->idorders)->update([
                            'status' => $response->status()->status(),
                            'consultada' => 1
                            ]);
                        }else{
                            $actualizar  = Orders::where('idorders', $orders->idorders)->update([
                            'status' => $response->status()->status()
                            ]);
                        }
                        
                    } else {
                        // There was some error with the connection so check the message
                        break;
                    }
                } catch (Exception $e) {
                    break;
                }
            }
        }
        $productos = Productos::all();
        $ord = Orders::Paginate(10);
        return view('home', ['orders' => $ord,'productos' => $productos]);
    }

        public function placetopay()
    {
        $data  = new PlacetoPay([
            'login' => env('P2P_LOGIN'),
            'tranKey' => env('P2P_TRANKEY'),
            'url' => env('P2P_URL'),
            'type' => PlacetoPay::TP_REST
        ]);
        return $data;
    }

        public function addRequest($request)
    {
        return array_merge([
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'PHPUnit',
        ], $request);
    }
}
