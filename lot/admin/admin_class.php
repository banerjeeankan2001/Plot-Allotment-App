<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		
			extract($_POST);		
			$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
				if($_SESSION['login_type'] != 1){
					foreach ($_SESSION as $key => $value) {
						unset($_SESSION[$key]);
					}
					return 2 ;
					exit;
				}
					return 1;
			}else{
				return 3;
			}
	}
	function login2(){
		
			extract($_POST);
			if(isset($email))
				$username = $email;
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			if($_SESSION['login_alumnus_id'] > 0){
				$bio = $this->db->query("SELECT * FROM alumnus_bio where id = ".$_SESSION['login_alumnus_id']);
				if($bio->num_rows > 0){
					foreach ($bio->fetch_array() as $key => $value) {
						if($key != 'passwors' && !is_numeric($key))
							$_SESSION['bio'][$key] = $value;
					}
				}
			}
			if($_SESSION['bio']['status'] != 1){
					foreach ($_SESSION as $key => $value) {
						unset($_SESSION[$key]);
					}
					return 2 ;
					exit;
				}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = '$type' ";
		if($type == 1)
			$establishment_id = 0;
		$data .= ", establishment_id = '$establishment_id' ";
		$chk = $this->db->query("Select * from users where username = '$username' and id !='$id' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function signup(){
		extract($_POST);
		$data = " name = '".$firstname.' '.$lastname."' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$uid = $this->db->insert_id;
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password')
					continue;
				if(empty($data) && !is_numeric($k) )
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if($_FILES['img']['tmp_name'] != ''){
							$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
							$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
							$data .= ", avatar = '$fname' ";

			}
			$save_alumni = $this->db->query("INSERT INTO alumnus_bio set $data ");
			if($data){
				$aid = $this->db->insert_id;
				$this->db->query("UPDATE users set alumnus_id = $aid where id = $uid ");
				$login = $this->login2();
				if($login)
				return 1;
			}
		}
	}
	function update_account(){
		extract($_POST);
		$data = " name = '".$firstname.' '.$lastname."' ";
		$data .= ", username = '$email' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' and id != '{$_SESSION['login_id']}' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("UPDATE users set $data where id = '{$_SESSION['login_id']}' ");
		if($save){
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password')
					continue;
				if(empty($data) && !is_numeric($k) )
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if($_FILES['img']['tmp_name'] != ''){
							$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
							$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
							$data .= ", avatar = '$fname' ";

			}
			$save_alumni = $this->db->query("UPDATE alumnus_bio set $data where id = '{$_SESSION['bio']['id']}' ");
			if($data){
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				$login = $this->login2();
				if($login)
				return 1;
			}
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['settings'][$key] = $value;
		}

			return 1;
				}
	}

	
	function save_division(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", description = '$description' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/maps/'. $fname);
					$data .= ", map_img = '$fname' ";

		}
			if(empty($id)){
				$save = $this->db->query("INSERT INTO division set $data");
			}else{
				$save = $this->db->query("UPDATE division set $data where id = $id");
			}
		if($save)
			return 1;
	}
	function delete_division(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM division where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function get_map(){
		extract($_POST);
		$get = $this->db->query("SELECT * FROM division where id = $id");
		if($get->num_rows > 0){
			return $get->fetch_array()['map_img'];
		}
	}
	function save_lot(){
		extract($_POST);
		$data = " division_id = '$division_id' ";
		$data .= ", lot = '$lot' ";
		$data .= ", type = '$type' ";
		$data .= ", price = '$price' ";
		$data .= ", model_id = '$model_id' ";
		$data .= ", details = '".htmlentities(str_replace("'","&#x2019;",$details))."' ";
		$pos = array("top"=>$top,"left"=>$left);
		$data .= ", marker_position = '".json_encode($pos)."' ";
		if(empty($id)){
			// echo "INSERT INTO lots set ".$data;

			$save = $this->db->query("INSERT INTO lots set ".$data);
		}else{
			$save = $this->db->query("UPDATE lots set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_lot(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM lots where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_model(){
		extract($_POST);
		$data = " title = '$title' ";
		$data .= ", description = '".htmlentities(str_replace("'","&#x2019;",$description))."' ";
		if($_FILES['cover']['tmp_name'] != ''){
						$_FILES['cover']['name'] = str_replace(array("(",")"," "), '', $_FILES['cover']['name']);
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];
						$move = move_uploaded_file($_FILES['cover']['tmp_name'],'assets/uploads/models/'. $fname);
					$data .= ", cover = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO model_houses set ".$data);
			if($save){
				$id = $this->db->insert_id;
				$folder = "assets/uploads/models/".$id;
				if(is_dir($folder)){
					$files = scandir($folder);
					foreach($files as $k =>$v){
						if(!in_array($v, array('.','..'))){
							unlink($folder."/".$v);
						}
					}
				}else{
					mkdir($folder);
				}
				if(isset($img)){
				for($i = 0 ; $i< count($img);$i++){
						$img[$i]= str_replace('data:image/jpeg;base64,', '', $img[$i] );
						$img[$i] = base64_decode($img[$i]);
						$fname = $id."_".strtotime(date('Y-m-d H:i'))."_".$imgName[$i];
						$upload = file_put_contents($folder."/".$fname,$img[$i]);
					}
				}
			}
		}else{
			$save = $this->db->query("UPDATE model_houses set ".$data." where id=".$id);
			if($save){
				$id = $this->db->insert_id;
				$folder = "assets/uploads/models/".$id;
				if(is_dir($folder)){
					$files = scandir($folder);
					foreach($files as $k =>$v){
						if(!in_array($v, array('.','..'))){
							unlink($folder."/".$v);
						}
					}
				}else{
					mkdir($folder);
				}
				if(isset($img)){
				for($i = 0 ; $i< count($img);$i++){
						$img[$i]= str_replace('data:image/jpeg;base64,', '', $img[$i] );
						$img[$i] = base64_decode($img[$i]);
						$fname = $id."_".strtotime(date('Y-m-d H:i'))."_".$imgName[$i];
						$upload = file_put_contents($folder."/".$fname,$img[$i]);
					}
				}
			}
		}
		if($save)
			return 1;
	}
	function delete_model(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM model_houses where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_reserve(){
		extract($_POST);
		$data = " lot_id = '$lot_id' ";
		$data .= ", lastname = '$lastname' ";
		$data .= ", firstname = '$firstname' ";
		$data .= ", middlename = '$middlename' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", message = '$message' ";

		if(empty($id)){
			$save = $this->db->query("INSERT INTO reserved set ".$data);
			if($save)
			$this->db->query("UPDATE lots set status = 2 where id = $lot_id");
		}else{
			$save = $this->db->query("UPDATE reserved set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function update_reserved(){
		extract($_POST);
			$save = $this->db->query("UPDATE reserved set status = $status where id=".$id);
		if($save){
			if($status == 0){
				$this->db->query("UPDATE lots set status = 1 where id = $lot_id");
			}elseif($status == 1){
				$this->db->query("UPDATE lots set status = 2 where id = $lot_id");
			}else{
				$this->db->query("UPDATE lots set status = 0 where id = $lot_id");
			}
			return 1;
		}
	}
	function delete_reserve(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM reserved where id = ".$id);
		if($delete){
			return 1;
		}
	}
}