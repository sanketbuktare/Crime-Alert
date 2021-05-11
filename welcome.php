<?php
// Initialize the session
session_start();

 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
            font: 14px sans-serif;
            background: url("bg_image.jpg");
            background-repeat: no-repeat;
            background-size: auto;
        }
        .heading {  
            margin: 30px;
            text-align: center; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }
        .heading h1 {
            margin: auto;
        }
        .center {
            margin-top: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btns .btn { 
            padding: 10px 20px;
            text-align: center;
            font-size: 18px;
            display: inline-block;  
        }
        .btns a { margin-top: 22px;   margin-bottom: 30px;}
        .heading a { margin: 20px; padding: 4px 10px; white-space: nowrap; }
        .btns a:not(:last-child) { margin-right: 28px; }
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: darkred;
            color: white;
            text-align: center;
            font-size: large;
        }

        @media only screen and (max-width: 600px) {
            .wrapper { margin: 0; padding: 0;}
            .heading { 
                width: auto;
                padding: 20px; 
                display: flex; 
                justify-content: center; 
                align-items: center;
            }
            
            .heading a { padding: 5px 16px; }
            .heading h1 {margin: auto;}
            .center {
                
                margin: 30px;
                margin-top: 0;
                padding: 40px;
                text-align: center;
            }
            .btns {
                align-items: center;
                margin: 10px 50px;
                padding: 30px;
            }
            .btns a {
                margin-left: 0;
                margin-right: 0;
                white-space: nowrap;
                
            }
        }

    </style>
</head>
<body>


        


    <div class="wrapper">
    
        <div class="heading d-flex justify-content-center">
            <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to Crime Alert!</h1> <br>
            <a href="logout.php" class="btn btn-danger btn-lg">Sign Out</a>
            <br><br><br><br><br>
        </div>
        <div class="center">
            <div class="btns">
                <a href="registercase.php" class="btn btn-primary btn-lg" role="button">Register a Case</a>
                
                <a href="cases.php" class="btn btn-info btn-lg" role="button">See Registered Cases</a>
            
                <a href="location.php" class="btn btn-success btn-lg" role="button">Check Area's Safety</a>
            </div>
        </div>
    </div>

    <div class="footer">
        © : Ashish & Sanket
    </div>
</body>

</html>