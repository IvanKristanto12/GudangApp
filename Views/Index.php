<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <meta http-equiv="refresh" content="1"> -->
    <link rel="stylesheet" type="text/css" href="assets/style/style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <title>Login</title>
</head>

<body class="w3-theme-d2">
    <div class="w3-col m3">
        <div class="w3-container w3-card w3-theme-l5 w3-round login-form" style="position: absolute;top: 50%;left: 50%; margin-right: -50%;transform: translate(-50%, -50%);">
            <form method="POST" action="authLogin">
                <div style="height:80px; width: 300px">
                    <h2 class="text-center w3-center">Log in</h2>
                    <p class="w3-text-red w3-center">
                        <?php if (isset($_SESSION['error'])) {
                            echo $_SESSION['error'];
                        } ?>
                    </p>
                </div>
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
</body>

</html>