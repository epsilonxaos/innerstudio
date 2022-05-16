<?php
namespace App;
use Conekta\Conekta;
use Conekta\Order;
use Conekta\Customer;
use Conekta\Handler;
use Conekta\ParameterValidationError;
use Conekta\ProcessingError;



class Conekta_client
{
    public function newOrder($data)
    {
        Conekta::setApiVersion("2.0.0");
        Conekta::setApiKey(env('APP_PAGOS_KEY_S'));
        $info = 0;
        $err = '';
        
        try {
        $info = Order::create($data);
        } catch (ProcessingError $error) {
            $er = 'Error: ' . $error->getMessage();
        } catch (ParameterValidationError $error) {
            $er ='Error: ' . $error->getMessage();
        } catch (Handler $error) {
            $er ='Error: ' . $error->getMessage();
        }

        return isset($info)? $info : $er;
    }

    public function newClient($data)
    {
        Conekta::setApiVersion("2.0.0");
        Conekta::setApiKey(env('APP_PAGOS_KEY_S'));
        $info = 0;
        $err = '';
        
        try {

            $info = Customer::create($data);
        } catch (ProcessingError $error) {
            $er ='Error: ' . $error->getMessage();
        } catch (ParameterValidationError $error) {
            $er = 'Error: ' . $error->getMessage();
        } catch (Handler $error) {
            $er = 'Error: ' . $error->getMessage();
        }
        return isset($info)? $info : $er;
    }
    public function capturaOrden(String $id)
    {
        $order = \Conekta\Order::find($id);
        $order -> capture();

        return $order;
    }
    public static function getClient($id)
    {
        Conekta::setApiVersion("2.0.0");
        Conekta::setApiKey(env('APP_PAGOS_KEY_S'));
        $info = 0;
        $err = '';
        
        try {

            $info = Customer::find($id);
        } catch (ProcessingError $error) {
            $er ='Error: ' . $error->getMessage();
        } catch (ParameterValidationError $error) {
            $er = 'Error: ' . $error->getMessage();
        } catch (Handler $error) {
            $er = 'Error: ' . $error->getMessage();
        }
        return isset($info)? $info : $er;
        }
   
}