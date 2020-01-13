<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dnetix\Redirection\PlacetoPay;
use Dnetix\Redirection\Contracts\Gateway;
use Dnetix\Redirection\Carrier\Authentication;
use Redirect;

class PlacetopayController extends Controller
{
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


        public function prueba()
    {
     
    }
}
