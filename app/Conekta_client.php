<?php
namespace App;
require_once("../lib/Conekta.php");


class Conekta_client
{
    function __construct() {
        \Conekta\Conekta::setApiKey(env('APP_PAGOS_KEY_S'));
        \Conekta\Conekta::setApiVersion("2.0.0");
    }

    public function newOrder($data)
    {
        try {
            return $order = \Conekta\Order::create($data);
          } catch (\Conekta\ProcessingError $e){
            return $e->getMessage();
          } catch (\Conekta\ParameterValidationError $e){
            return $e->getMessage();
          } catch(\Conekta\Handler $e){
            return $e->getMessage();
          }
    }

    public function newClient($data)
    {
        return \Conekta\Customer::create($data);
    }
    public function capturaOrden(String $id)
    {
        $order = \Conekta\Order::find($id);
        $order -> capture();

        return $order;
    }
}