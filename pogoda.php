<html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action='pogoda.php' method='get'>
        <input type='text' name='location' />
        <input type='submit'>
    </form>

<?php
$conn = mysqli_connect("localhost","xrgxxkcydh_pogoda","Pogoda123!","xrgxxkcydh_pogoda");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
 $user_ip = $_SERVER['REMOTE_ADDR'];
 echo "Your IP address is: " . htmlspecialchars($user_ip);
 $location = json_decode(file_get_contents('http://ip-api.com/json/'.$user_ip), true);
 if($_GET['location']) {
    $city = $_GET['location'];
 } else {
 $city = $location['city'];
 }
 $key = "9c36694cf729a55fe303b7e333375c56";

 $fixed_loca = htmlspecialchars($location['city']);
 $weather_url = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=$key&units=metric";
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



if (isset($weather_data['coord'])) {
    $lat = $weather_data['coord']['lat'];
    $lon = $weather_data['coord']['lon'];
    
    
    $forecast_url = "https://api.openweathermap.org/data/3.0/onecall?lat=$lat&lon=$lon&exclude=current,minutely,hourly&appid=05ae1cbb79f458d5f16f94d01c65b9d2&units=metric";
    $forecast_response = @file_get_contents($forecast_url);
    $forecast_response = json_decode($forecast_response, true);
        mysqli_query($conn, "DELETE FROM pogoda WHERE miasto ='Warsaw'");
        
       
        foreach ($forecast_response['daily'] as $day) {
           
            $date = date('Y-m-d', $day['dt']);
            $description = htmlspecialchars($day['weather'][0]['description']);
            $temp_max = htmlspecialchars($day['temp']['max']);
            $temp_min = htmlspecialchars($day['temp']['min']);
            $query = "INSERT INTO pogoda (miasto, dzien, prognoza_pogody) VALUEs(?,?,?)"; 
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'ssi',$city ,$date,$temp_max );
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    
 else {
    echo "Error: Unable to retrieve location coordinates.";
}

if (isset($weather_data['coord'])) {
    $lat = 37.7749;
    $lon = -122.4194;
    $city = "San Francisco";
    $forecast_url = "https://api.openweathermap.org/data/3.0/onecall?lat=$lat&lon=$lon&exclude=current,minutely,hourly&appid=05ae1cbb79f458d5f16f94d01c65b9d2&units=metric";
    $forecast_response = @file_get_contents($forecast_url);
    $forecast_response = json_decode($forecast_response, true);
        mysqli_query($conn, "DELETE FROM pogoda WHERE miasto ='San Francisco'");
        foreach ($forecast_response['daily'] as $day) {
           
            $date = date('Y-m-d', $day['dt']);
            $description = htmlspecialchars($day['weather'][0]['description']);
            $temp_max = htmlspecialchars($day['temp']['max']);
            $temp_min = htmlspecialchars($day['temp']['min']);
            $query = "INSERT INTO pogoda (miasto, dzien, prognoza_pogody) VALUEs(?,?,?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'ssi',$city ,$date,$temp_max );
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    


if (isset($weather_data['coord'])) {
    $lat = 51.5085;
    $lon = -0.1257;
    $city = "London";
    $forecast_url = "https://api.openweathermap.org/data/3.0/onecall?lat=$lat&lon=$lon&exclude=current,minutely,hourly&appid=05ae1cbb79f458d5f16f94d01c65b9d2&units=metric";
    $forecast_response = @file_get_contents($forecast_url);
    $forecast_response = json_decode($forecast_response, true);
        mysqli_query($conn, "DELETE FROM pogoda WHERE miasto ='London'");
        foreach ($forecast_response['daily'] as $day) {
           
            $date = date('Y-m-d', $day['dt']);
            $description = htmlspecialchars($day['weather'][0]['description']);
            $temp_max = htmlspecialchars($day['temp']['max']);
            $temp_min = htmlspecialchars($day['temp']['min']);
            $query = "INSERT INTO pogoda (miasto, dzien, prognoza_pogody) VALUEs(?,?,?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'ssi',$city ,$date,$temp_max );
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    


?>
</body>
</html>