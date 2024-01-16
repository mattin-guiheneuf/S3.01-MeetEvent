<?php
/**
 * 
 */

class ApiSynonyme{
    // METHODES
    public function utiliserApiSyn(Mot $mot, String $destinationFile = NULL){
        $url = curl_init();
        $urlARechercher = "https://wordsapiv1.p.rapidapi.com/words/";
        $urlARechercher = $urlARechercher . $mot . "/synonyms";
        curl_setopt_array($url, [
            CURLOPT_URL => $urlARechercher,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: wordsapiv1.p.rapidapi.com",
                "X-RapidAPI-Key: f59a2efa60msha84f78f61a68ddap12ca6djsnadb8f76a8e62"
            ],
        ]);
            
        $response = curl_exec($url);
        $err = curl_error($url);
            
        curl_close($url);
            
        if ($err) {
            echo "URL Error #:" . $err;
        } else {
            $data = json_decode($response,true);
            if ($destinationFile != NULL)
            {
                file_put_contents($destinationFile,json_encode($data,JSON_PRETTY_PRINT));
            }
        }
        
        return $data;
    } 
}

