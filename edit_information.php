<?php
session_start();
require_once "function.php";
if(isset($_POST['submit_edit']) && !empty($_POST['submit_edit'])){
	$id = $_SESSION['id'];
	$username = $_POST["name"];
	$job_title = $_POST["job"];
	$phone = $_POST["phone"];
	$address = $_POST["address"];

	$result = edit_info($id, $username, $job_title, $phone, $address);
	if($result){
		set_flash_message('success', "Данные добавлены.");
		redirect_to('users.php');
	}else{
		set_flash_message('danger', "Ошибка, данные не добавлены.");
		redirect_to('users.php');
	}
}