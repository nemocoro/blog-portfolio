<?php
    include '../class/user.php';

    if( isset($_POST["submit"]) )
    {
        //INPUT
        $username = $_POST["username"];
        $password = $_POST["password"];

        //Instantiate
        $user = new User();

        //method call
        $user->login($username, $password);
    }
?>