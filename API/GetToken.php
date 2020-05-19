<?php


class GetToken
{
    static function acquireToken($baseUrl, $username, $password){
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_USERAGENT => 'Curl Post Request',
            CURLOPT_URL => $baseUrl . "oauth/token",
            CURLOPT_POSTFIELDS => array(
                "grant_type" => "password",
                "client_id" => "2",
                "client_secret" => "kUltLEB0nM9pEQfIFNd7BSrWycDp0DPM1Fq6kQ2T",
                "username" => $username,
                "password" => $password,
                "scope" => "*"
            )
        ]);
        $jsonResponseData = curl_exec($curl);
        curl_close($curl);

        $responseArray = json_decode($jsonResponseData, 1);
        if(isset($responseArray["access_token"])){
            return $responseArray["access_token"];
        } else {
            return null;
        }
    }
}