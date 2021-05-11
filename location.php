<?php
// Initialize the session
session_start();

// Include config file
require_once "config.php";


$lat = ''; //19.169815;
$lng = '';  //77.319717;
$min_dist = "";

function distance($lat1, $lon1, $lat2, $lon2) {
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
    }
    else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        //$unit = strtoupper($unit);
        return ($miles * 1.609344); //in kilometers
     }
}

//$dist = distance();



if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(empty(trim($_POST["lat"])) && empty(trim($_POST["lng"]))){
        $location_err = "Error while getting location";     
    } else {
        $lat = trim($_POST["lat"]);
        $lng = trim($_POST["lng"]);
        
    }
    

    
    $sql = "SELECT * FROM data;";
    $result = mysqli_query($link, $sql);
    $resultCheck = mysqli_num_rows($result);

    $distance = [];
    if($resultCheck > 0){
        while ($row = mysqli_fetch_assoc($result)) {
            /* echo "<div class='container'>";
                echo "<p>" . $row['lat']. "<br>" . $row['lng'] . "</p><hr>";
            echo "</div>"; */
            $val = distance((double)$lat, (double)$lng, (double)$row['lat'], (double)$row['lng']);
            //echo $val. "<br>";
            array_push($distance, $val);
        }
    }

    //echo "<hr>" . min($distance); 

    if(empty($distance)) {
        echo "There are no locations in database";
    } else {
        $min_dist = min($distance);
        //echo $min_dist;
        if($min_dist <= 5) {
            echo "<script>alert('You are in Danger Zone!')</script>";
        } else {
            echo "<script>alert('You are Safe :)')</script>";
        }
    }
}

//echo $distance;

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location</title>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    
     <!-- Latest compiled and minified CSS -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css">
    <style>

        body {
            background-image: url('https://martechtoday.com/wp-content/uploads/2018/08/location-data-cityscape-ss-1920_rmjpym.jpg');
            background-repeat: no-repeat; 
            background-size: cover; 
            background-position: center center;
        
        }
        h1 {
            text-align: center;
            text-shadow: 0 0 5px #fff, 0 0 10px #fff, 0 0 15px #0073e6, 0 0 20px #0073e6, 0 0 25px #0073e6, 0 0 30px #0073e6, 0 0 35px #0073e6;
        }

    </style>

</head>
<body>
    
    <div class="container-fluid">
        <div class="view">
            <br><br><br><br>
            <h1 class="text-white text-center">Check if I'm in a safe location</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" id="lat" class="form-group" name="lat">
                    <input type="hidden" id="lng" class="form-group" name="lng">
                </div>
                <br><br><br><br><br><br><br><br><br><br>

                <div class="form-group col-md-12 text-center">
                    <input type="submit" class="btn btn-dark border-white" value="Check" name="submit">
                </div>
                <br><br><br><br><br><br><br><br><br><br>
            </form>
        </div>
    </div>

    <p>To go to home page <a href="welcome.php">Click Here</a></p>
</body>
<script>

    var lat = document.getElementById('lat');
    var lng = document.getElementById('lng');
    
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
            alert("Geolocation is not supported by this browser.");
        }
    }
    setTimeout(getLocation, 4000);
        
    function showPosition(position) {
        /* x.innerHTML="Latitude: " + position.coords.latitude + 
        "<br>Longitude: " + position.coords.longitude;  */
        lat.value = position.coords.latitude;
        lng.value = position.coords.longitude;
        console.log(position.coords.latitude);
        console.log(position.coords.longitude);
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                x.innerHTML = "User denied the request for Geolocation."
                break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML = "Location information is unavailable."
                break;
            case error.TIMEOUT:
                x.innerHTML = "The request to get user location timed out."
                break;
            case error.UNKNOWN_ERROR:
                x.innerHTML = "An unknown error occurred."
                break;
        }
}
  
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</html>