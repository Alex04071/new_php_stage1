<?php
function get_user_by_email($email){
	$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
	$sql = "SELECT * FROM users WHERE email = '$email'";

	$result = mysqli_query($connect, $sql);
	$arr_user = mysqli_fetch_assoc($result);
	mysqli_close($connect);
	return $arr_user;
}
function add_user($email, $password){
	$password = password_hash("$password", PASSWORD_DEFAULT);
	$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
	$sql = "INSERT INTO users (email, password) VALUES ('$email', '$password');";
	$result = mysqli_query($connect, $sql);
	mysqli_close($connect);
}
function set_flash_message($name, $message){
	$_SESSION[$name] = $message;
}
function display_flash_message($name){
		echo  '<div class="alert alert-' . $name . ' text-dark" role="alert">'
        . '<strong>' . $_SESSION[$name] . '</strong>'
        . '</div>';
}
function redirect_to($path){
	header("Location: /$path");
}
function login($email, $pass){
	$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
	$sql = "SELECT email, password FROM users WHERE email = '$email'";
	$result = mysqli_query($connect, $sql);
	$user = mysqli_fetch_array($result, MYSQLI_ASSOC);
	mysqli_free_result($result);
	mysqli_close($connect);
	return password_verify($pass, $user["password"]);
}

function is_not_loggin_in($email){
	$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
	$sql = "SELECT * FROM users WHERE email = '$email'";
	$result = mysqli_query($connect, $sql);
	$user = mysqli_fetch_array($result, MYSQLI_ASSOC);
	mysqli_free_result($result);
	mysqli_close($connect);
	return $user;
}

function get_users($email, $valueForShow = 'user'){
	$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
	if($valueForShow === 'admin'){
		$sql = "SELECT * FROM users";
		$result = mysqli_query($connect, $sql);
		$dateUser = mysqli_fetch_all($result, MYSQLI_ASSOC);
	}else{
		$sql = "SELECT * FROM users WHERE email = '$email'";
		$result = mysqli_query($connect, $sql);
		$dateUser[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
	mysqli_free_result($result);
	mysqli_close($connect);
	return $dateUser;
}