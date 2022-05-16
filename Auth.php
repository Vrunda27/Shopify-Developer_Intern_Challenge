<?php
	require('db_users.php');
	require('db_inventory.php');

	if (isset($_POST)) {
		if(isset($_POST["form_type"])) {
			switch ($_POST["form_type"]) {
				case 'Register':
					registrationHandler($_POST);
					echo '<script>alert("Registration unsuccessful. Try again!")</script>';
					header("Refresh:0; url=ui_register.php");
					die();
					break;

				case 'Login':
					if (validateInput($_POST)) { 
						loginHandler($_POST);
					}
					echo '<script>alert("Login unsuccessful. Try again!")</script>';
					header("Refresh:0; url=ui_login.php");
					die();
					break;

				case 'Add Inventory':
					addInventoryHandler($_POST);
					echo '<script>alert("Inventory not added. Try again!")</script>';
					header("Refresh:0; url=ui_list.php");
					die();
					break;

				case 'Save Inventory':
					saveInventoryHandler($_POST);
					echo '<script>alert("Inventory not updated. Try again!")</script>';
					header("Refresh:0; url=ui_list.php");
					die();
					break;

				case 'delete_inventory' :
					deleteInventoryHandler($_POST);

				case 'Change Password':
					if (validateInput($_POST)) { 
						changePasswordHandler($_POST);
					}
					echo '<script>alert("Cannot change password. Try again!")</script>';
					header("Refresh:0; url=ui_changePassword.php");
					die();
					break;
				
				default:
					echo "<script>alert('Invalid!');</script>";
					break;
			}
		} 
		die();
	}

	

	function registrationHandler($data) {
		$registerData = $data;
		$email 		  = $data["email"];
		$contact 	  = $data["contact"];
		$password 	  = $data["password"];
		$conpassword  = $data["repassword"];

		unset($data["contact"], $data["location"]);

		if (validateInput($data) && 
			validatePassword($password, $conpassword) &&
			validateEmail($email)
		) {
			if (!empty($contact) && !validateContact($contact)) {
				error_log("shopify: " . "Invalid Contact!");
				return;
			}
			error_log("shopify: " . "Successfully Validated!" . $data['name']) ;
			$registerData['user_type'] = 'U';
			if(registerUser($registerData)) {
				header("Location:ui_login.php");
				die();
			}
		}
		echo '<script>alert("Registration unsuccessful. Try again!")</script>';
		header("Refresh:0; url=ui_register.php");
		die();
	}

	function loginHandler($data) {
		error_log(json_encode($data));
		if(validateInput($data) &&
			validateEmail($data['email'])) {
			$res = login($data); error_log(json_encode($res));
			if($res != false) {
			
				manageSession($res);
				
				header("Refresh:0; url=ui_list.php");
				die();
			}
		}
		echo "<script>alert('Log in failed!');</script>";
		header("Refresh:0; url=ui_login.php");
		die();

	}

	function changePasswordHandler($data) {
		// print_r($data); die();
		require('session_authenticate.php');
		$newpassword 	= $data['password'];
		$conNewpassword 	= $data['repassword'];
		$user_id 		= $_SESSION['user_id'];
		$csrfToken		= $data['csrfTokenChangePasswordForm'];

		if(!isset($csrfToken) or $_SESSION['csrfTokenChangePasswordForm'] != $csrfToken){
			echo "<script>alert('CSRF attack detected');</script>";
			die();
		 }

		if(validatePassword($newpassword, $conNewpassword) && changePasswordDB($user_id, $newpassword)) {
			echo '<script>alert("Password changed Successfully!")</script>';
			header("Refresh:0; url=ui_list.php");
			die();
		} else {
			echo '<script>alert("Can not change password. Please Try again!")</script>';
			header("Refresh:0; url=ui_changePassword.php");
			die();
		}
	}

	function manageSession($res) {
		require('session_create.php');
		$_SESSION['logged']   	= TRUE;
		$_SESSION['username'] 	= $res['name'];
		$_SESSION['email'] 		= $res['email'];
		$_SESSION['user_id'] 	= $res['id'];
        $_SESSION['browser']  	= $_SERVER['HTTP_USER_AGENT'];
        error_log(json_encode($_SESSION));
	}

	function validatePassword($password, $conpassword) {
		if ($password != $conpassword) {
			return FALSE;
		}
		if (strlen($password) < 8 || strlen($password) > 16) {
			return FALSE;
		}
		$pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,16}$/";
		if(!preg_match($pattern, $password)) {
			return FALSE;
		}
		return TRUE;
	}

	function validateEmail($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  			$emailErr = "Invalid email format";
  			error_log("shopify: " . $emailErr  ." : Email" . $email) ;
  			return FALSE;
		}
		return TRUE;
	}

	function validateInput($data) {
		foreach($data as $key => $input) {
			if (empty($input)) {
				error_log("shopify: " . "$key field is empty!");
				return FALSE;
			}
			if ($key != 'gender' && $key != 'user_type' && strlen($input) < 5 && strlen($input) > 50) {
				error_log($key.' Invalid Input!');
				return FALSE;
			}
		} 
		return TRUE;
	}

	function validateContact($contact) {
		if (strlen($contact) != 10) {
			return FALSE;
		}
		if (!preg_match("/^(\.\d{2,4})?\s?(\d{10})$/", $contact)) {
			return FALSE;
		}
		return TRUE;
	}

	function validateAge($dob) {
		$birthdate = new DateTime($dob);
		$today   = new DateTime('today');
		$age = $birthdate->diff($today)->y;
		return $age < 13 ? FALSE : TRUE;
	}

	function addInventoryHandler($data) {
		require('session_authenticate.php');
		$csrfToken = $data['csrfTokenAddInvt'];
		$inventoryData = $data;

		if(!isset($csrfToken) or $_SESSION['csrfTokenAddInvt'] != $csrfToken){
			echo "<script>alert('CSRF attack detected');</script>";
			die();
		}

		unset($data["description"]);

		if (validateInput($data)) {
			if(createInventory($inventoryData)) {
				header("Location:ui_list.php");
				die();
			}
		}
		echo '<script>alert("Inventory not added. Try again!")</script>';
		header("Refresh:0; url=ui_list.php");
		die();
	}

	function saveInventoryHandler($data) {
		require('session_authenticate.php');
		$csrfToken = $data['csrfTokenEditInvt'];
		$inventoryData = $data;

		unset($data["title"]);

		if(!isset($csrfToken) or $_SESSION['csrfTokenEditInvt'] != $csrfToken){
			echo "<script>alert('CSRF attack detected');</script>";
			die();
		}

		if (validateInput($data)) {
			if(validateInventoryId($data['inventory_id'])) {
				if(updateInventory($inventoryData)) {
					header("Location:ui_list.php");
					die();
				}
			}
		}
		echo '<script>alert("Inventory not updated. Try again!")</script>';
		header("Refresh:0; url=ui_list.php");
		die();
	}

	function deleteInventoryHandler($data) {
		require('session_authenticate.php');
		$csrfToken = $data['csrfTokenDelInvt'];
		$inventory_id = $data['inventory_id'];
		$deleteComment = $data['deleteComment'];

		if(!isset($csrfToken) or $_SESSION['csrfTokenDelInvt'] != $csrfToken){
			echo "<script>alert('CSRF attack detected');</script>";
			die();
		}
		if(validateInput($data)) {
			if(validateInventoryId($inventory_id)) {
			 	$response = deleteInventory($inventory_id, $deleteComment);
			 	if($response != false) {
			        header("Refresh:0; url=ui_list.php");
			        die();
				}
			}
		}
	}
?>