<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use App\User_orders;
use App\Http\Requests\OrdersRequest;
use Auth;
use App\Productos;
use Dnetix\Redirection\PlacetoPay;
use Dnetix\Redirection\Contracts\Gateway;
use Dnetix\Redirection\Carrier\Authentication;
use Redirect;

class OrdersController extends Controller
{
       public function index(Orders $model)
    {
    	return view('orders.index', ['orders' => $model->paginate(15)]);
    }
    	public function store(Request $request, Orders $model)
    {
    	$datos = $request->all();
    	$ordenes = Orders::create([
    		'iduser' => Auth::user()->id,
			'customer_name' => $datos['customer_name'],
			'customer_email' => $datos['customer_email'],
			'customer_mobile' => $datos['customer_mobile'],
			'status' => 'CREATED',
			'token_unico' => base64_encode(sha1(uniqid(), TRUE)),
			'idproducto' => $datos['idproducto']
    	]);
        return redirect()->route('ordenes.show', ['ordene' => $ordenes->idorders]);

    }

    	public function show($id)
    {
    	$order = Orders::find($id);
    	$productos = Productos::all();
    	return view('orders.show', ['order' => $order, 'productos' => $productos]);

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


    	public function checkout(Request $request)
    {
    	$datos = $request->all();
    	$reference = 'TEST_' . time();
        $orden = Orders::find($datos['idorders']);
        $total = $orden->order_prod[0]->price_producto + $orden->order_prod[0]->tax_producto;
        // Request Information
        $request = [
            "locale" => "es_CO",
            "payer" => [
                "name" => "".$datos['customer_name'],
                "surname" => "".$datos['customer_name'],
                "email" => "".$datos['customer_email'],
                "documentType" => "CC",
                "document" => "1848839248",
                "mobile" => "".$datos['customer_mobile'],
            ],
            "buyer" => [
                "name" => "".$datos['customer_name'],
                "surname" => "".$datos['customer_name'],
                "email" => "".$datos['customer_email'],
                "documentType" => "CC",
                "document" => "1848839248",
                "mobile" => "".$datos['customer_mobile'],
            ],
            "payment" => [
                "reference" => $reference,
                "description" => "App creada por Luis Carreño",
                "amount" => [
                    "taxes" => [
                        [
                            "kind" => "".$orden->order_prod[0]->nombre_producto,
                            "amount" => $orden->order_prod[0]->tax_producto
                        ]
                    ],
                    "currency" => "USD",
                    "total" => $total
                ],
                "items" => [
                    [
                        "sku" => $orden->order_prod[0]->idproducto,
                        "name" => "".$orden->order_prod[0]->nombre_producto,
                        "category" => "physical",
                        "qty" => 1,
                        "price" => $orden->order_prod[0]->price_producto,
                        "tax" => $orden->order_prod[0]->tax_producto
                    ]
                ],
                "shipping" => [
                    "name" => "".$datos['customer_name'],
                    "surname" => "".$datos['customer_name'],
                    "email" => "".$datos['customer_email'],
                    "documentType" => "CC",
                    "document" => "1848839248",
                    "mobile" => "".$datos['customer_mobile'],
                    "address" => [
                        "street" => "703 Dicki Island Apt. 609",
                        "city" => "North Randallstad",
                        "state" => "Antioquia",
                        "postalCode" => "46292",
                        "country" => "US",
                        "phone" => "363-547-1441 x383"
                    ]
                ],
                "allowPartial" => false
            ],
            "expiration" => date('c', strtotime('+1 hour')),
            "ipAddress" => "127.0.0.1",
            "userAgent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
            "returnUrl" => "http://127.0.0.1:8000/home",
            "cancelUrl" => "http://127.0.0.1:8000/home",
            "skipResult" => false,
            "noBuyerFill" => false,
            "captureAddress" => false,
            "paymentMethod" => null
        ];
        try {
            $placetopay = $this->placetopay();
            $response = $placetopay->request($request);
            $actualizar  = Orders::where('idorders', $datos['idorders'])->update([
                    'requestid' => $response->requestId,
                    'urlgenerada' => $response->processUrl()
        	]);
            if ($response->isSuccessful()) {
                // Redirect the client to the processUrl or display it on the JS extension
                return Redirect::to($response->processUrl());;
            } else {
                // There was some error so check the message
                return $response->status()->message();
            }
            var_dump($response);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
