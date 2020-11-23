<?php
session_start();
require_once "function.php";
if(isset($_POST['submit']) && !empty($_POST['submit'])){
	$id = $_SESSION['id'];
	$arr_file = $_FILES["avatar"];
	$result = upload_avatar($arr_file, $id);
	if($result){
	    set_flash_message('success', 'Ваше фото добавлено.');
	    redirect_to('profil.php?id=' . $id);
	}else{
		set_flash_message('danger', 'Ошибка, нет фото для добавления');
	    redirect_to('users.php');
    }
}else{
	set_flash_message('danger', 'Вы можете редактировать только свои данные');
    redirect_to('users.php');
}