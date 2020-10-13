<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['symbol']) && !is_null($_GET['symbol'])) {
        $url = "https://api.binance.com/api/v3/ticker/price?symbol=" . $_GET['symbol'];
    
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
        //for debug only!
        /*
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        */
    
        $res = curl_exec($curl);
        $response = json_decode($res);
        $custom_response = [
            'status' => '200',
            'symbol' => $response->symbol,
            'price' => $response->price,
        ];
        header('Content-Type: application/json');
        curl_close($curl);
        echo json_encode($custom_response);
    } else {
        $response = [
            'status' => '400',
            'message' => 'Require parameters not set.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        die();    
    }
    
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