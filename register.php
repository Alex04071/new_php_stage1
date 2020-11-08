<?php
session_start();
$email = $_POST['email'];

$arr_user = get_user_by_email($email);

function get_user_by_email($email){
    $conect = mysqli_connect("localhost", "root", "root", "project1") 
            or die("Не могу подключится к базе данных.");
    
    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    if(mysqli_stmt_fetch($stmt)){
        $message = 'Этот эл. адрес уже занят другим пользователем.';
        set_flash_message('', $message);
        return [];
    }else{
        add_user($email, $_POST['password']);
        return [$email];
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conect);
};

function add_user($mail, $password){
    $conect = mysqli_connect("localhost", "root", "root", "project1") 
        or die("Не могу подключится к базе данных.");
    
    $sql = "INSERT INTO users (email, password) VALUES (?,?)";
    $stmt = mysqli_prepare($conect, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $_POST['email'], $_POST['password']);
    mysqli_stmt_execute($stmt);
    $message = 'Регистрация успешна';
    set_flash_message(session_id(), $message);
    mysqli_stmt_close($stmt);
    mysqli_close($conect);
};

function set_flash_message($name, $message){
    if($name){
        $_SESSION['messagen'] = $message;
        $_SESSION['style'] = 'success';
        display_flash_message($name);
    }else{
        $_SESSION['messagen'] = $message;
        $_SESSION['style'] = 'danger';
        display_flash_message($name);
    }
}

function display_flash_message($name){
    if($name){
        redirect_to('success');
    }else{
        redirect_to('danger');
    }
}

function redirect_to($path){
    if($path === 'success'){
        header("Location: /page_login.php");
    }else{
        header("Location: /page_register.php");
    }
};