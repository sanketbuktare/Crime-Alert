<?php
// Initialize the session
session_start();

// Include config file
require_once "config.php";

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Registered Cases</title>
    <style>
        h1 { color: sandybrown;}
        img {
            height: 300px;
            width: 300px;
            margin: 5px;
            margin-bottom: 18px;
            border: 2px solid blanchedalmond;
        }
        .container {
            font-size: 20px;
            padding: 10px;
        }
        small {
            font-size: small;
        }

        @media only screen and (max-width: 600px) {
            img {
                height: 100px;
                width: 100px;
            }
        }
    </style>
</head>
<body>

    <div class="wrapper">

    <h1>Registered Cases</h1> <br>
    
    <?php
    
    $sql = "SELECT * FROM data;";
    $result = mysqli_query($link, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0){
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='container'>";
                echo "<h2>" . $row['title'] . "</h2>" ;
                echo "<h5>(" . $row['crime_type'] . ")</h5>";
                echo "<img src='images/" . $row['image'] . "' class='img-responsive' > <br>";
                echo "<em>" . $row['description'] . "</em><br><br>";
                echo "<b>Location: </b>" . $row['location'] . "<br>";
                echo "<small>Posted on " . $row['date_time'] . "</small><br><hr><hr>";
            echo "</div>";
        }
    }
    
    ?>

    <p>To go to home page <a href="welcome.php">Click Here</a></p>

    </div>

</body>
</html>