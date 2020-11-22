<?php
session_start();
require_once "function.php";
if(isset($_POST['submit_edit']) && !empty($_POST['submit_edit'])){
	$id = $_SESSION['id'];
	$email = $_POST['email'];
	$password = $_POST["password"];
	$repeat_password = $_POST["repeat_password"];
	$role = $_SESSION['role'];
	if((!empty($_POST['password']) && !empty($_POST['repeat_password'])) && ($password === $repeat_password)){

		$exist_user = get_user_by_email($email);
		if((!$exist_user[0]['email']) || (($exist_user[0]['email']) && ($exist_user[0]['id'] === $id))){
			$result = edit_credentials($email, $password, $id);
			if($result){
				if(($role === 'user') || ($role === 'admin' && $id === $_SESSION['id_admin'])){
					$_SESSION['email'] = $email;
				}
				set_flash_message('success', "Вы изменили данные");
				redirect_to('profil.php?id=' . $id);
			}else{
				set_flash_message('danger', "Ошибка, данные не добавленны");
				redirect_to('users.php');
			}
		}else{
			set_flash_message('danger', 'Этот эл. адрес уже занят другим пользователем.');
			redirect_to('users.php');
		}
	}else{
		set_flash_message('danger', "Ошибка, введенные пароли не совпадают");
		redirect_to('security.php?id=' . $id);
	}
}