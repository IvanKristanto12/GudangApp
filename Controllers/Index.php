<?php

class Index extends Controller
{

    public static function createHead()
    {
        echo '<head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <!-- <meta http-equiv="refresh" content="1"> -->
                <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
                <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
                <link rel="icon" href="Assets/image/title-icon.png">
                <title>Login</title>
            </head>';
    }

    public static function createBody(){
        session_start();
        if(isset($_SESSION["error"])){
            $error = $_SESSION["error"];
        }else{
            $error="";
        }
        session_unset();

        echo '
        <body class="w3-theme-d2">
        <div class="w3-col m3">
            <div class="w3-container w3-card w3-theme-l5 w3-round login-form" style="position: absolute;top: 50%;left: 50%; margin-right: -50%;transform: translate(-50%, -50%);">
                <form method="POST" action="authLogin">
                    <div style="height:50px; width: 300px">
                        <h2 class="text-center w3-center">Log in</h2>
                    </div>
                    <p class="w3-text-red w3-center">'.$error.' </p>
                    <div class="form-group">
                        Username <br>
                        <input type="text" class="form-control w3-input w3-border" name="username" placeholder="" required="required">
                    </div>
                    <div class="form-group">
                        Password <br>
                        <input type="password" class="form-control w3-input w3-border" name="password" placeholder="" required="required">
                    </div>
                    <div class="form-group w3-right">
                        <input type="submit" name="login" value="Login" class="btn btn-primary btn-block w3-button w3-blue-grey w3-round" style="margin-bottom:10px; margin-top:10px;">
                    </div>
                </form>
            </div>
        </div>
        </body>';
    }

    public static function createPage()
    {
        echo '<!DOCTYPE html>
            <html lang="en">';
        self::createHead();
        self::createBody();
        echo '</html>';
        
    }
}
