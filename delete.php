<?php
session_start();
require_once "function.php";
if(!$user = is_not_loggin_in($_SESSION['email'])){
    set_flash_message('danger', 'Введите email и пароль.');
    redirect_to('page_login.php');
}

if($user['role'] === 'admin'){
    $date_user = get_user_by_id($_GET['id']);
    if($date_user[0]){
    	$exist_image = has_image($date_user[0]['id'], $date_user[0]['imgProfil']);
    	if($exist_image){
    		$image = __DIR__ . $date_user[0]['imgProfil'];
    	}
		$is_deleted = delete($_GET['id']);
		if($is_deleted){
			if(file_exists($image)){
		    	unlink($image);
			}
			set_flash_message('success', 'Пользователь удален');
			if($_GET['id'] === $user['id']){
				session_destroy();
				redirect_to('page_login.php');
			}else{
				redirect_to('users.php');
			}
		}
    }
    set_flash_message('danger', 'Нет такого пользователя');
    redirect_to('users.php');
}else{
    $result = is_author($user['id'], $_GET['id']);
    if($result){
    	$date_user = get_user_by_id($_GET['id']);
    	$exist_image = has_image($date_user[0]['id'], $date_user[0]['imgProfil']);
    	if($exist_image){
    		$image = __DIR__ . $date_user[0]['imgProfil'];
    	}
		$is_deleted = delete($_GET['id']);
		if($is_deleted){
			if(file_exists($image)){
		    	unlink($image);
			}
	    	session_destroy();
	    	redirect_to('page_login.php');
	    }
    }
    set_flash_message('danger', 'Вы не можете редактировать чужой профиль');
    redirect_to('users.php');
}