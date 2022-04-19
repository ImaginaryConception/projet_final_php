<?php
// Remplacer les XXX par la clé secrète délivrée par Google
function recaptchaValid($code, $ip = null)
{
    if(empty($code)) {
        return false;
    }
    $params = [
        'secret'    => '6Ld9YncfAAAAAFV28yk6xpp_m8jBEPpCr4Xsysi7',
        'response'  => $code
    ];
    if($ip){
        $params['remoteip'] = $ip;
    }
    $url = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query($params);
    if(function_exists('curl_version')){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
    }else{
        $response = file_get_contents($url);
    }
    if(empty($response) || is_null($response)){
        return false;
    }
    $json = json_decode($response);
    return $json->success;
}