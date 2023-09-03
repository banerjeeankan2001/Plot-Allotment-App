<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'update_account'){
	$save = $crud->update_account();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_division"){
	$save = $crud->save_division();
	if($save)
		echo $save;
}

if($action == "delete_division"){
	$delete = $crud->delete_division();
	if($delete)
		echo $delete;
}
if($action == "get_map"){
	$get = $crud->get_map();
	if($get)
		echo $get;
}
if($action == "save_lot"){
	$save = $crud->save_lot();
	if($save)
		echo $save;
}
if($action == "delete_lot"){
	$save = $crud->delete_lot();
	if($save)
		echo $save;
}

if($action == "save_model"){
	$save = $crud->save_model();
	if($save)
		echo $save;
}
if($action == "delete_model"){
	$save = $crud->delete_model();
	if($save)
		echo $save;
}
if($action == "save_reserve"){
	$save = $crud->save_reserve();
	if($save)
		echo $save;
}

if($action == "update_reserved"){
	$save = $crud->update_reserved();
	if($save)
		echo $save;
}
if($action == "delete_reserve"){
	$save = $crud->delete_reserve();
	if($save)
		echo $save;
}

ob_end_flush();
?>
