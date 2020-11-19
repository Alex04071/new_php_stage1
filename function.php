<?php
function get_user_by_email($value = 'user', $email){
	$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
	if($value === 'admin'){
		$sql = "SELECT * FROM `users`";

		$result = mysqli_query($connect, $sql);
		$dateUser = mysqli_fetch_all($result, MYSQLI_ASSOC);
		mysqli_free_result($result);
		mysqli_close($connect);
		return $dateUser;
	}
	$sql = "SELECT * FROM `users` WHERE `email` = '$email'";

	$result = mysqli_query($connect, $sql);
	$dateUser[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
	mysqli_free_result($result);
	mysqli_close($connect);
	return $dateUser;
}

function add_user($email, $password){
	$password = password_hash("$password", PASSWORD_DEFAULT);
	$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
	$sql = "INSERT INTO `users` (`email`, `password`) VALUES ('$email', '$password')";

	if(mysqli_query($connect, $sql)){
		$sql = "SELECT `id` FROM `users` WHERE `email` = '$email'";

		$result = mysqli_query($connect, $sql);
		$user = mysqli_fetch_array($result, MYSQLI_ASSOC);
		mysqli_free_result($result);
		mysqli_close($connect);
		return $user['id'];
	}
	mysqli_close($connect);
	return false;
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
	$sql = "SELECT `email`, `password` FROM `users` WHERE `email` = '$email'";

	$result = mysqli_query($connect, $sql);
	$user = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	mysqli_close($connect);
	return password_verify($pass, $user["password"]);
}

function is_not_loggin_in($email){
	$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
	$sql = "SELECT * FROM `users` WHERE `email` = '$email'";

	$result = mysqli_query($connect, $sql);
	$user = mysqli_fetch_array($result, MYSQLI_ASSOC);
	mysqli_free_result($result);
	mysqli_close($connect);
	return $user;
}

function edit_information($user_id = null, $username, $job_title, $phone, $address){
	if(($user_id && $username && $job_title && $phone && $address) != false){
		$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
		$sql = "UPDATE `users` SET `fullName` = '$username', `position` = '$job_title', `phone` = '$phone', `address` = $address WHERE `id` = '$user_id'";

		mysqli_query($connect, $sql);
		mysqli_close($connect);
		return true;
	}
	return false;
}

function set_status($status, $user_id){
	switch ($status) {
		case '1':
			$status = 'Онлайн';
			break;
		case '2':
			$status = 'Отошел';
			break;
		case '3':
			$status = 'Не беспокоить';
			break;
	}
	if(!is_null($user_id)){
		$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
		$sql = "UPDATE `users` SET `status` = '$status' WHERE `id` = '$user_id'";

		mysqli_query($connect, $sql);
	}
	mysqli_close($connect);
}

function add_social_links($user_id = null, $vk, $telegram, $instagram){
	if(($user_id && $vk && $telegram && $instagram) != false){
		$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
		$sql = "UPDATE `users` SET `linkVK` = '$vk', `linkTelegram` = '$telegram', `linkInstagram` = '$instagram' WHERE `id` = '$user_id'";

		mysqli_query($connect, $sql);
		mysqli_close($connect);		
	}
}

function upload_avatar($user_id = null, $arr_file){
	if(is_uploaded_file($arr_file['tmp_name'])){
		$dir_images = 'images';
		if(!is_dir(__DIR__ . '/' . $dir_images)){
			mkdir(__DIR__ . '/' . $dir_images);
		}

		$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
		$sql = "SELECT `imgProfil` FROM `users` WHERE `id` = '$user_id'";

		$result = mysqli_query($connect, $sql);
		$user_img = mysqli_fetch_array($result, MYSQLI_NUM);
		mysqli_free_result($result);
		$newLinkImage = '/' . $dir_images . '/' . uniqid($arr_file['name']) . '.jpg';

		if(is_file($user_img[0])){
			unlink($user_img[0]);
			copy($arr_file['tmp_name'], __DIR__ . $newLinkImage);
		}else{
			copy($arr_file['tmp_name'], __DIR__ . $newLinkImage);
		}
		$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
		$sql = "UPDATE `users` SET `imgProfil` = '$newLinkImage' WHERE `id` = '$user_id'";
		mysqli_query($connect, $sql);
		mysqli_close($connect);
	}
}

function get_user_by_id($id){
	$connect = mysqli_connect('localhost', 'root', 'root', 'projectphp1');
	$sql = "SELECT * FROM `users` WHERE `id` = '$id'";

	$result = mysqli_query($connect, $sql);
	$arr_user[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
	mysqli_free_result($result);
	mysqli_close($connect);
	return $arr_user;
}

function is_author($logged_user_id, $edit_user_id){
	if($logged_user_id === $edit_user_id){
		return true;
	}
	return false;
}

function edit_info($user_id = null, $username, $job_title, $phone, $address){
	if($user_id && $username && $job_title && $phone && $address){
		$connect = mysqli_connect("localhost", "root", "root", "projectphp1");
		$sql = "UPDATE `users` SET `fullName` = '$username', `position` = '$job_title', `phone` = '$phone', `address` = '$address' WHERE `id` = '$user_id'";
		
		mysqli_query($connect, $sql);
		mysqli_close($connect);
		return true;
	}
	return false;
}