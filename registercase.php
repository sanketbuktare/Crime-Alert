<?php

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$title = $crime_type = $description = "";
$title_err = $crime_type_err = $description_err = "";
$location = $location_err = $msg = $dt = $lat = $lng = "";

// if(isset($_POST['submit'])){
    
  
// }
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Get image name
  	$image = $_FILES['image']['name'];

    // image file directory
    $target = "images/".basename($image);

    //$sql = "INSERT INTO data (image) VALUES ('$image')";

    //mysqli_query($link, $sql);

    
    // Validate title, crime and description
    if(empty(trim($_POST["title"]))){
        $title_err = "Please enter the title of crime.";     
    } else{
        $title = trim($_POST["title"]);
    }

    if(empty(trim($_POST["crime"]))){
        $crime_type_err = "Please enter the type of crime.";     
    } else{
        $crime_type = trim($_POST["crime"]);
    }

    if(empty(trim($_POST["description"]))){
        $description_err = "Please enter some information about the crime.";     
    } elseif(strlen(trim($_POST["description"])) < 15){
        $description_err = "Description must have atleast 15 characters.";
    } else{
        $description = trim($_POST["description"]);
    }

    if(empty(trim($_POST["location"]))){
        $location_err = "Error while getting location";     
    } else{
        $location = trim($_POST["location"]);
        $lat = trim($_POST["lat"]);
        $lng = trim($_POST["lng"]);
    }

    if(empty(trim($_POST["dt"]))){
        $dt_err = "Error while getting Date and Time";     
    } else{
        $dt = trim($_POST["dt"]);
    }

    // Check input errors before inserting in database
    if(empty($title_err) && empty($crime_type_err) && empty($description_err)){
    
        // Prepare an insert statement
        $sql = "INSERT INTO data (title, crime_type, description, location, image, date_time, lat, lng) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_title, $param_crime_type, $param_description, $param_location, $param_image, $param_dt, $param_lat, $param_lng);
            
            // Set parameters
            $param_title = $title;
            $param_crime_type = $crime_type;
            $param_description = $description;
            $param_location = $location;
            $param_image = $image;
            $param_dt = $dt;
            $param_lat = $lat;
            $param_lng = $lng;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: welcome.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $msg = "Image uploaded successfully";
            }else{
                $msg = "Failed to upload image";
            }
        

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register a Case</title>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        h1 { color: sandybrown;}
        .wrapper{ width: 350px; padding: 20px; }

    </style>
</head>
<body>
    
    <div class="wrapper">
        <h1>Register your case here</h1> <hr>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Title of crime</label>
                <input type="text" name="title" class="form-control">
                <span class="invalid-feedback"><?php echo $title_err; ?></span>
            </div>   
            
            <div class="form-group">
                <label>Type of crime</label>
                <input type="text" name="crime" class="form-control" placeholder="e.g. Burglury, Kidnapping, Murder, etc">
                <span class="invalid-feedback"><?php echo $crime_type_err; ?></span>
            </div>
            
            <div class="form-group">
                <input type="hidden" id="currentDateTime" class="form-group" name="dt">
                <script>
                    var today = new Date();
                    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    var dateTime = date+' '+time;
                    document.getElementById("currentDateTime").value = dateTime;
                </script>

                <input type="hidden" id="lat" class="form-group" name="lat">
                <input type="hidden" id="lng" class="form-group" name="lng">
            </div>
            
            <div class="form-group">
                <label>Location</label>
                <button id="loc-btn" onclick="getLocation()" style="display:none">Get Location</button>
                <textarea id='output' rows=3 cols=50 class="form-control" name="location"></textarea>
                <span class="invalid-feedback"><?php echo $location_err; ?></span>

                
            </div>
            
            <div class="form-group">
                <label>Tell more details</label>
                <textarea id='output' rows=4 cols=50 class="form-control" name="description"></textarea>
                <span class="invalid-feedback"><?php echo $description_err; ?></span>
                
            </div>
            
            <div class="form-group">
                <label>Upload Image</label>
                <input type="file" class="form-control" name="image">
                <span class="invalid-feedback"><?php echo $msg; ?></span>
            </div> 
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
            </div>
            
        </form>
    </div>

    <p>To go to home page <a href="welcome.php">Click Here</a></p>

</body>
<script src="script.js"></script>
</html>