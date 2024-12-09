<html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action='pogoda.php' method='get'>
        <input type='text' name='location'/>
        <input type='submit'>
    </form>

<?php
$conn = mysqli_connect("localhost","xrgxxkcydh_pogoda","Pogoda123!","xrgxxkcydh_pogoda");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}
 $user_ip = $_SERVER['REMOTE_ADDR'];
 echo "Your IP address is: " . htmlspecialchars($user_ip);
 $location = json_decode(file_get_contents('http://ip-api.com/json/'.$user_ip), true);
 if($_GET['location']) {
    $city = $_GET['location'];
 } else {
 $city = $location['city'];
 }
 $weather_url = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=9c36694cf729a55fe303b7e333375c56&units=metric";
 $weather_data = json_decode(file_get_contents($weather_url), true);
 echo "Current weather in " . htmlspecialchars($city) . ": " . htmlspecialchars($weather_data['weather'][0]['description']) . "<br>";
 echo "Temperature: " . htmlspecialchars($weather_data['main']['temp']) . "°C<br>";
 echo "Humidity: " . htmlspecialchars($weather_data['main']['humidity']) . "%<br>";
 echo "Cloudiness: " . htmlspecialchars($weather_data['clouds']['all']) . "%<br>";

 $data = date('Y-m-d H:i:s');
 $query = "INSERT INTO logi (Adres_ip, Data, lokalizacja) VALUES (?, ?,?)";
 $stmt = mysqli_prepare($conn, $query);
 if ($stmt) {
     // Adjust the bind_param types according to your database schema
     mysqli_stmt_bind_param($stmt, 'iss', $user_ip, $data, $fixed_loca);
     
     // Execute the statement
     if (mysqli_stmt_execute($stmt)) {
     
     } else {
         echo "Error executing statement: " . mysqli_stmt_error($stmt);
     }
     
     mysqli_stmt_close($stmt);
 } else {
     echo "Error preparing statement: " . mysqli_error($conn);
 }
 

?>
</body>
</html>