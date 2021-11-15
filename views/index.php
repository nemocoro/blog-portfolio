<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>
<body>
    
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-6">
                <!-- DISPLAY ERROR / SUCCESS MESSAGE -->
                <?php
                    if( isset($_SESSION["success"]) && isset($_SESSION["message"]))
                    {
                        $class = ($_SESSION["success"]==0)?"danger":"success";
                        $message = $_SESSION["message"];

                        //UNSET / remove session variables
                        unset($_SESSION["success"]);
                        unset($_SESSION["message"]);
                ?>
                    <div class="alert alert-<?php echo $class;?>" role="alert">
                        <?php echo $message;?>
                    </div>
                <?php        
                    }
                ?>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-4">
                <h1>Login</h1>
                <form action="../action/login-action.php" method="POST">
                    <div class="form-group">
                        <label for="username">User Name</label>
                        <input class="form-control" type="text" name="username" id="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password">
                    </div>
                    <input type="submit" value="Login" name="submit" class="btn btn-success btn-block">
                </form>
                <div class="mt-3">
                    <a href="register.php" class="text-decoration-none text-muted float-left">Create an Account</a>
                    <a href="#" class="text-decoration-none text-muted float-right">Recover account</a>
                </div>
            </div>
        </div>
    </div>     


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>