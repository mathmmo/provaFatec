<?php 
    // Iniciano a sessão
    session_start();

    $user = $_POST['userName'];
    $password = $_POST['password'];

    $con = mysqli_connect("localhost", "root", "admin", "Servers");

    $result = mysqli_query($con,"SELECT * FROM Usuario WHERE user = '" . $user . "' AND password = '".$password."'");

    var_dump($result);

    if($result){
        $_SESSION['userName'] = $user;
        $_SESSION['password'] = $password;
        header('location:crud.php');
    }else{
        echo ("</br>6");
        unset ($_SESSION['userName']);
        unset ($_SESSION['password']);
        header('location:index.php');
    }

    mysqli_close($con);
?>