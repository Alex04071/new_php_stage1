<?php
session_start();
require_once "function.php";
if(isset($_POST['submit_add']) && !empty($_POST['submit_add'])){
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
		if(!is_null($existUser[0])){
			set_flash_message('danger', "$email уже занят.");
			redirect_to('create_user.php');
		}else{
			if(empty($username) || empty($job_title) || empty($phone) || empty($address)){
				set_flash_message('danger', "Пользователе не добавлен");
				redirect_to('create_user.php');
			}else{
				$user_id = add_user($email, $password);
				$edit_result = edit_information($user_id, $username, $job_title, $phone, $address);
				set_status($user_id, $status);
				upload_avatar($user_id, $arr_file);
				add_social_links($user_id, $linkVk, $linkTelegram, $linkInstagram);
				set_flash_message('success', "Пользователь добавлен");
				redirect_to('users.php');
			}
		}
	}else{
		set_flash_message('danger', 'Ошибка: поле пустое, проверьте email или password');
		redirect_to('create_user.php');
	}
}