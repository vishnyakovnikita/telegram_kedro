<?php
    include 'job_with_database.php';
    include '../var/constants.php';

    session_start();

    $login = $_POST['login'];
    $password = md5($_POST['password']);

    $login = stripslashes($login);
    $login = htmlspecialchars($login);

    $bd = new job_with_database(NAME_BD, HOST_BD, LOGIN_BD, PASSWORD_BD);
    $token = $bd->create_token_bd();

    $data = $bd->getAccount($token, $login);

    if ($data['password'] != $password) {
        exit("Пароли не совпадают");
    }
    else {
        $_SESSION['login'] = $login;
        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['last_name'] = $data['last_name'];
        $_SESSION['status'] = $data['status'];
    }

    header('Location: ../site/index.php');



?>