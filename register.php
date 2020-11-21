<?php
session_start();
require_once "function.php";
if(isset($_POST['register']) && !empty($_POST['register'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	$arr_user = get_user_by_email($email);
	if(!$arr_user){
		add_user($email, $password);
		set_flash_message('success', 'Регистрация успешна');
		redirect_to('page_login.php');

	}else{
		set_flash_message('danger', 'Этот эл. адрес уже занят другим пользователем.');
		redirect_to('page_register.php');
	}
}
