<?php
namespace App;
require_once("../lib/Conekta.php");


class Conekta_client
{
    function __construct() {
        \Conekta\Conekta::setApiKey(config('services.pagos.skey'));
        \Conekta\Conekta::setApiVersion("2.0.0");
    }

    public function newOrder($data)
    {
        $info = \Conekta\Order::create($data);
    }

    public function newClient($data)
    {
        $info = \Conekta\Customer::create($data);
    }
}