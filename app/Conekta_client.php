<?php
namespace App;
use Conekta\Conekta;
use Conekta\Order;


class Conekta_client
{
    function __construct() {
        Conekta::setApiKey(env('APP_PAGOS_KEY_S'));
        Conekta::setApiVersion("2.0.0");
    }

    public function newOrder($data)
    {
        $info = Order::create($data);
        return $info;
    }

    public function newClient($data)
    {
        return Customer::create($data);
    }
}