<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;

class ConektaController extends Controller
{

    public function webhook(Request $request)
    {     
        switch ($request -> type) {
            case 'order.paid':
                $pago = Purchase::find($request->data['object']['metadata']['pago_id']);
                $pago -> status = 3;
                $pago -> save();        
                logger('Realizado', [ 'pago' => $pago, 'status' => $request->data['object']['payment_status'] ]);
                break;
            case 'charge.paid':
                //TODO
                break;
            case 'subscription.created':
                //TODO
                break;
            case 'subscription.paid':
                //TODO
                break;
        }   
       
        logger('WEBHOOK LOG', [
            'type' => $request->type,
            'data' => print_r($request->data, true)
        ]);
        return response('webhook done', 200);
    }
}
