<?php 
    // Iniciano a sessão
    session_start();

    $user = $_POST['userName'];
    $password = $_POST['password'];

    $con = mysqli_connect("localhost", "root", "admin", "Server");

    $result = mysqli_query($con,"SELECT * FROM Usuario WHERE user = '" . $user . "' AND password = '".$password."';");

    if(mysqli_num_rows($result) > 0){
        $_SESSION['userName'] = $user;
        $_SESSION['password'] = $password;
        header('location:crud.php');
    }else{
        unset ($_SESSION['userName']);
        unset ($_SESSION['password']);
        header('location:index.php');
    }

    mysqli_close($con);
?>