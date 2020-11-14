<?php
session_start();
require_once "function.php";
$email = $_POST['email'];
$password = $_POST['password'];

$result = login($email, $password);

if($result){
	$_SESSION['email'] = $email;
	set_flash_message('success', 'Добро пожаловать.');
	redirect_to('users.php');
}else{
	set_flash_message('danger', 'Введен неверный логин или пароль.');
	redirect_to('page_login.php');
}