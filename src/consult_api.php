<?php
    $url = "http://127.0.0.1:8000/users.php?name=Antonio";
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,false);
    curl_setopt($curl,CURLOPT_HEADER,false);

    $data = curl_exec($curl);
    curl_close($curl);
    //var_dump($data);
?> 