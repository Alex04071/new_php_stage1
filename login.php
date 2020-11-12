<?php
session_start();
require_once "function.php";
$email = $_POST['email'];
$password = $_POST['password'];

$res = login($email, $password);


if($res){
	set_flash_message('success', 'Добро пожаловать');
	redirect_to('users.html');
}else{
	set_flash_message('danger', 'Введен неверный логин или пароль.');
	redirect_to('page_login.php');
}



function login($email, $pass){
	$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
	$sql = "SELECT email, password FROM users WHERE email = '$email'";
	$result = mysqli_query($connect, $sql);
	$user = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	mysqli_close($connect);
	return password_verify($pass, $user["password"]); 
}