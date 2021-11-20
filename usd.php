<?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $url = "https://api.nobitex.ir/market/stats";
        $params = [
            "srcCurrency" => "usdt",
            "dstCurrency"=> "rls"
        ];
    
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$params);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
        //for debug only!
        /*
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        */
    
        $res = curl_exec($curl);
        $response = json_decode($res, true);
        
        $custom_response = [
            'status' => '200',
            'best_buy' => $response['stats']['usdt-rls']['bestBuy'],
            'best_sell' => $response['stats']['usdt-rls']['bestSell'],
        ];
        
        header('Content-Type: application/json');
        curl_close($curl);
        echo json_encode($custom_response);
        
        die();
    } else {
        $response = [
            'status' => '401',
            'message' => 'Unsupported method.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        die();
    }
?>
