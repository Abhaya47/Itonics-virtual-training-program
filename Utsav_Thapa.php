<?php
$url="https://jsonplaceholder.typicode.com/users";
$ch=curl_init($url);

curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

$response =curl_exec($ch);

if(curl_errno($ch)){
    die (curl_error($ch));
    unset($ch); //curl_close($ch) has depreciated since sep 28 0225
    exit;
}

unset($ch);

$data = json_decode($response,true);

if(!$data){
    echo"Invalid JSON response";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER LIST FROM API</title>
</head>
<body>
    <?php foreach($data as $user):?>
        <h2><?php echo $user['name'];?></h2>
        <p><strong>Email:</strong> <?php echo $user['email'];?></p>
        <p><strong>Phone:</strong> <?php echo $user['phone'];?></p>
        <p><strong>Company:</strong> <?php echo $user['company']['name'];?></p>
        <hr>
    <?php endforeach;?>
</body>
</html>