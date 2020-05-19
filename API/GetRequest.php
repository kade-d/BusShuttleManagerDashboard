<?php

class GetRequest {

    static function executeGetRequest($baseUrl ,$endPoint, $token){
        $curl = curl_init($baseUrl . $endPoint);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_USERAGENT => 'Curl Get Request',
            CURLOPT_HTTPHEADER => ["Authorization: Bearer " . $token]
        ]);
        $json_response_data = curl_exec($curl);
        curl_close($curl);
        return $json_response_data;
    }

    static function executeGetRequestForId($baseUrl ,$endPoint, $id){
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $baseUrl . $endPoint . "/" . $id,
            CURLOPT_USERAGENT => 'Curl Get Request'
        ]);
        $json_response_data = curl_exec($curl);
        curl_close($curl);
        return $json_response_data;
    }

}




