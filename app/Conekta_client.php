<?php
namespace App;
require_once("../lib/Conekta.php");
use Conekta\Charge;
use Conekta\Conekta;
use Conekta\Customer as ConektaCustomer;
use Conekta\Handler;
use Conekta\Order;
use Conekta\ParameterValidationError;
use Conekta\ProcessingError;

class Conekta_client
{
    function __construct() {
        Conekta::setApiKey(config('services.pagos.skey'));
        Conekta::setApiVersion("2.0.0");
    }

    public function newOrder($data)
    {
        return Order::create($data);
    }

    public function newClient($data)
    {
        return Customer::create($data);
    }
}