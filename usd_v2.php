<?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
       error_reporting(0);
       $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://abantether.com/eapi/api/Portfolio/GetNewMainPortfolio',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        $custom_response = json_decode($response, 1);
        
        curl_close($curl);
        foreach($custom_response['data'] as $item) {
            if (strtolower($item['symbol']) == 'usdt') {
                $custom_response = [
                    "status" => '200',
                    "best_buy" => (string) $item['irrbuy'],
                    "best_sell" => (string) $item['irrsell']
                ];
            break;
            }
        }
        
        header('Content-Type: application/json');
        curl_close($curl);
        echo json_encode($custom_response);
        
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
