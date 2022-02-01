<?php
namespace App;
/**
 * Created by PhpStorm.
 * User: GraficoLocker
 * Date: 2019-04-29
 * Time: 15:37
 */

class PagoFacil
{
    var $sandbox = false;
    var $url_sandbox = 'https://sandbox.pagofacil.tech/';
    var $url_produccion = 'https://api.pagofacil.tech/';
    var $branch_key;
    var $user_key;
    var $charge;
    var $customer;
    var $base_url = '';
    var $request;
    var $response;


    function __construct($branch_key = '', $user_key = '')
    {
        $this -> branch_key = $branch_key;
        $this -> user_key = $user_key;
    }

    function setMode($sandbox){
        $this -> sandbox = $sandbox;
        $this -> base_url = $this -> sandbox ?  $this -> url_sandbox : $this -> url_produccion;
    }

    function createCharge($charge){
        $this -> charge = $charge;
        /*Array('data[nombre]' => '',
            'data[apellidos]' => '',
            'data[numeroTarjeta]' => '',
            'data[cvt]' => '',
            'data[cp]' => '',
            'data[mesExpiracion]' => '',
            'data[anyoExpiracion]' => '',
            'data[monto]' => '1.00');*/
    }

    function createCustomer($customer){
        $this -> customer = $customer;
        /*Array('data[nombre]' => '',
            'data[apellidos]' => '',
            'data[email]' => '',
            'data[telefono]' => '',
            'data[celular]' => '',
            'data[calleyNumero]' => '',
            'data[colonia]' => '',
            'data[municipio]' => '',
            'data[estado]' => '',
            'data[pais]' => '');*/

    }


    function createData(){
        $data = Array('method' => 'transaccion', 'data[idServicio]' => 3, 'data[idSucursal]' => $this -> branch_key, 'data[idUsuario]' => $this -> user_key);
        $data2 = array_merge($data, $this -> customer);
        $this -> request = array_merge($data2, $this -> charge);
    }

    function executePay(){
        $this -> createData();
        $curl = curl_init();
        curl_setopt_array( $curl, array(
            CURLOPT_URL => $this -> base_url."Wsrtransaccion/index/format/json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $this -> request
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this -> response = $err;
            //echo "cURL Error #:" . $err;
        } else {
            //echo '<pre>'.$response.'</pre>';
            $res = json_decode($response);
            $this -> response = $res -> WebServices_Transacciones -> transaccion;
        }
    }


}