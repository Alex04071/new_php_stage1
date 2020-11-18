<?php
session_start();
require_once "function.php";

$username = $_POST["name"];
$job_title = $_POST["job"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$email = $_POST["email"];
$pass = $_POST["password"];
$status = $_POST["status"];
$arr_file = $_FILES["avatar"];
$linkVk = $_POST["linkVk"];
$linkTelegram = $_POST["linkTelegram"];
$linkInstagram = $_POST["linkInstagram"];


if((isset($email) && !empty($email)) && (isset($pass) && !empty($pass))){
	$existUser = get_user_by_email($email);
	if(is_null($existUser[0])){
		$user_id = add_user($email, $password);
		$edit_result = edit_information($username, $job_title, $phone, $address, $user_id);
		set_status($status, $user_id);
		//upload_avatar($arr_file);
		add_social_links($linkVk, $linkTelegram, $linkInstagram, $user_id);
		set_flash_message('success', 'Данные добавлены');
		redirect_to('create_user.php');
	}else{
		set_flash_message('danger', "$email уже занят.");
		redirect_to('create_user.php');
	}
}else{
	set_flash_message('danger', 'Ошибка, проверьте email или password');
	redirect_to('create_user.php');
}
