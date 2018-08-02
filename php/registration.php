<?php
    include 'job_with_database.php';
    include '../var/constants.php';

    $login = $_POST['login'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cnfPassword = $_POST['cnfPassword'];

    $login = stripslashes($login);
    $login = htmlspecialchars($login);

    $email = stripslashes($email);
    $email = htmlspecialchars($email);

    $first_name = stripslashes($first_name);
    $first_name = htmlspecialchars($first_name);

    $last_name = stripslashes($last_name);
    $last_name = htmlspecialchars($last_name);

    $password = stripslashes($password);
    $password = htmlspecialchars($password);

    $cnfPassword = stripslashes($cnfPassword);
    $cnfPassword = htmlspecialchars($cnfPassword);

    if (empty($login)) {
        exit("Введите логин");
    }
    if (empty($email)){
        exit("Введите Email");
    }
    if (empty($first_name)){
        exit("Введите Имя");
    }
    if (empty($last_name)){
        exit("Введите Фамилию");
    }
    if (empty($password) or empty($cnfPassword) or $password != $cnfPassword){
        exit("Пароли не совпадают либо не заполнены");
    }



    $params = [
        "login" => $login,
        "password" => md5($password),
        "email" => $email,
        "first_name" => $first_name,
        "last_name" => $last_name
        ];

    $bd = new job_with_database(NAME_BD, HOST_BD, LOGIN_BD, PASSWORD_BD);
    $token = $bd->create_token_bd();
    $list_login = $bd->getAccountTable($token);

    foreach ($list_login as $i => $value) {
        if ($list_login[$i]['login'] == $login) {
            exit('Логин занят');
        }
    }


    $bd->sendAccount($token, $params);
    $bd->close_token_bd($token);

    header('Location: ../site/index.php');






?>