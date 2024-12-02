<html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<?php
 $user_ip = $_SERVER['REMOTE_ADDR'];
 echo "Your IP address is: " . htmlspecialchars($user_ip);
 $location = file_get_contents('http://ip-api.com/json/'.$user_ip.'?fields=city');
 echo $location;
?>
</body>
</html>