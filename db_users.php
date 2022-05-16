<?php
	require('db.php');

	function registerUser($registerData) {

		$name 		 = htmlspecialchars($registerData["name"]);
		$email 		 = htmlspecialchars($registerData["email"]);
		$contact 	 = htmlspecialchars($registerData["contact"]);
		$location 	 = htmlspecialchars($registerData["location"]);
		$password 	 = md5($registerData["password"]);

		$dob = empty($dob) ? NULL : $dob;

		global $mysqli;

		$insertUser = "INSERT INTO users(name, email, contact, location, password) VALUES (?, ?, ?, ?, ?)";

		if(!$stmt = $mysqli->prepare($insertUser))
			error_log("shopify: " . "Register Prepared Statement Error!");

		$stmt->bind_param("ssiss", $name, $email, $contact, $location, $password);

		if(!$stmt->execute()) {
			error_log("shopify: " . "Registration Failed : stmt->execute:" . $stmt->error) ;
			return false;
		}

		if(!$stmt->store_result()) {
			error_log("shopify: " . "Registration Failed " ."Store_result Error");
			return false;
		}

		return true;
	}

	function login($data) {
		error_log(json_encode($data));
		$emailID = $data['email'];
		$password = md5($data['password']);

		global $mysqli;

		$selectUser = "SELECT name, email, user_id FROM users WHERE email = ? AND password=?";

		if(!$stmt = $mysqli->prepare($selectUser))
			error_log("shopify: " . "Login Prepared Statement Error!");

		$stmt->bind_param("ss", $emailID, $password);

		if(!$stmt->execute()) {
			error_log("shopify: " . "Login Failed : stmt->execute:" . $stmt->error) ;
			return false;
		}

		$stmt->bind_result($name, $email, $userid);

		if(!$stmt->store_result()) {
			error_log("shopify: " . "Login Failed " ."Store_result Error");
			return false;
		}
		if($stmt->num_rows == 1) {
			if($stmt->fetch())  {
            	return array(
            		'name'		=> htmlentities($name), 
            		'email'		=> htmlentities($email), 
            		'id'		=> htmlentities($userid)
            		);
			}
		}
		return false;
		
	}

	function changePasswordDB($user_id, $newpassword) {
		global $mysqli;
		$preparedSql = "UPDATE users SET password=md5(?) WHERE user_id = ?;";

		if(!$stmt = $mysqli->prepare($preparedSql))
			echo "Prepared statement error";

		$stmt->bind_param("si", $newpassword, $user_id);

		if(!$stmt->execute())  {
			echo "Execute Error";
			return false;
		}
		if(!$stmt->store_result()) {
			echo "Store result Error";
			return false;
		}
		return true;
	}

	function getUsers() {

		global $mysqli;

		$getUsers = "SELECT user_type, name, email, user_id, status, created FROM users";

		if(!$stmt = $mysqli->prepare($getUsers))
			error_log("shopify: " . "Login Prepared Statement Error!");

		if(!$stmt->execute()) {
			error_log("shopify: " . "get users Failed : stmt->execute:" . $stmt->error) ;
			return false;
		}

		$stmt->bind_result($user_type, $name, $email, $userid, $status, $created);
		$response = array();
		while($stmt->fetch()) {
			array_push($response, 
				array(
				"user_id" 	  => htmlentities($userid),
				"name"		  => htmlentities($name),
				"email"		  => htmlentities($email),
				"user_type"   => htmlentities($user_type),
				"status"      => htmlentities($status),
				"created"	  => htmlentities($created)
			)
			);
		}
		// echo "<pre>";	
		// print_r($response);die();
		return $response;
	}

	function operation($user_id, $operation) {
		global $mysqli;

		$preparedSql = "UPDATE users SET status=? WHERE user_id = ?;";

		if(!$stmt = $mysqli->prepare($preparedSql))
			echo "Prepared statement error";

		$stmt->bind_param("si", $operation, $user_id);

		if(!$stmt->execute())  {
			echo "Execute Error";
			return false;
		}
		if(!$stmt->store_result()) {
			echo "Store result Error";
			return false;
		}
		return true;
	}
?>