<?php
session_start();
require_once "function.php";
if(isset($_POST['set_status']) && isset($_POST['status'])){
	$status = $_POST['status'];
	$user_id = $_SESSION['id'];

	$result = set_status($status, $user_id);
	if($result){
	    set_flash_message('success', 'Статус усшено добавлен');
	    redirect_to('profil.php?id=' . $user_id);
	}else{
	    set_flash_message('danger', 'Статус не добавлен');
	    redirect_to('status.php?id=' . $user_id);
	}
}