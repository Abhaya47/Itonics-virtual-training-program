<?php
$json = '{
    "userId": 97058,
    "id": 201,
    "title": "Post Try",
    "completed": true
}';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL,'https://jsonplaceholder.typicode.com/todos/');
curl_setopt($curl,CURLOPT_POST,True);// tell its ppostrqst
curl_setopt($curl,CURLOPT_POSTFIELDS,$json);//to upload the json
curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type : application/json']);//to tellthe file is json
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
$execustion = curl_exec($curl);

$curl1 = curl_init();
curl_setopt($curl1, CURLOPT_URL,'https://jsonplaceholder.typicode.com/todos/201');

curl_setopt($curl1,CURLOPT_RETURNTRANSFER,true);
$execution1 = curl_exec($curl1);
$data=json_decode($execution1);

echo "<pre>";
print_r($data);
echo "This is Tushar";
echo"wdkh";
echo"wdkh";
echo"wdkh";
echo"wdkh";
echo"wdkh";


echo "</pre>";

