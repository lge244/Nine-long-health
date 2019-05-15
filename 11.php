<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8080",
    CURLOPT_URL => "http://api.jiai.pro:8080/jiai/watches",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n\"imei\":\"357190489608372\"\n}",
    CURLOPT_HTTPHEADER => array(
        "Accept: */*",
        "Cache-Control: no-cache",
        "Connection: keep-alive",
        "Content-Type: application/json",
        "Host: api.jiai.pro:8080",
        "Postman-Token: 1dea128a-965a-4d69-aace-65af36861056,91f5a4a0-4c72-4ea1-bad2-3326ace466e8",
        "User-Agent: PostmanRuntime/7.11.0",
        "accept-encoding: gzip, deflate",
        "cache-control: no-cache",
        "content-length: 28",
        "cpid: 424",
        "imei: 357190489608372",
        "key: d0041f5e674aebd6b645fbdca5885644"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}
//var_dump($response);