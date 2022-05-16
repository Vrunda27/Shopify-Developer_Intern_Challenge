<?php
	require('db.php');


	function getInventoryList() { // All active posts 

		global $mysqli;

		$response = array();

		$selectInventory = "SELECT inventory_id, title, description, price, quantity, seller, created 
					   FROM inventory
					   WHERE status='A'
					   ORDER BY created DESC;";

		if(!$stmt = $mysqli->prepare($selectInventory))
			error_log("shopify: " . "Inventory get Prepared Statement Error!" . $stmt->error );

		if(!$stmt->execute()) {
			error_log("shopify: " . "Inventory get Failed : stmt->execute:" . $stmt->error) ;
			return $response;
		}

		if(!$stmt->bind_result($inventory_id, $title, $description, $price, $quantity, $seller, $created)) {
			error_log("shopify: " . "Inventory get Failed : stmt->bind result:" . $stmt->error) ;
			return $response;
		}

		while($stmt->fetch()) {
			array_push($response, 
				array(
					"inventory_id" 	=> htmlentities($inventory_id),
					"title" 		=> htmlentities($title),
					"description"	=> htmlentities($description),
					"price"			=> htmlentities($price),
					"quantity" 		=> htmlentities($quantity),
					"seller"		=> htmlentities($seller),
					"created"		=> htmlentities($created)
				)
			);

		}	
		return $response;
	}

	function getInventory($id) { 

		global $mysqli;

		$response = array();


		$selectInventory = "SELECT inventory_id, title, price, quantity 
					   FROM inventory
					   WHERE status='A' and inventory_id = ?;";

		// echo $selectInventory;

		if(!$stmt = $mysqli->prepare($selectInventory))
			error_log("shopify: " . "Inventory get Prepared Statement Error!" . $stmt->error );

		$stmt->bind_param("i", $id);
		// var_dump($stmt);
		if(!$stmt->execute()) {
			error_log("shopify: " . "Inventory get Failed : stmt->execute:" . $stmt->error) ;
			return $response;
		}

		if(!$stmt->bind_result($inventory_id, $title, $price, $quantity)) {
			error_log("shopify: " . "Inventory get Failed : stmt->bind result:" . $stmt->error) ;
			return $response;
		}
		if(!$stmt->store_result()) {
			error_log("shopify: " . "Login Failed " ."Store_result Error");
			return false;
		}
		if($stmt->num_rows == 1) {
			if($stmt->fetch())  {
            	return array(
					"inventory_id" 	=> htmlentities($inventory_id),
					"title" 		=> htmlentities($title),
					"price"			=> htmlentities($price),
					"quantity" 		=> htmlentities($quantity)
				);
			}
		}
		return $response;
	}

	function getInventoryCount() {
		global $mysqli;
		$countInventory = "SELECT COUNT(inventory_id) as inventory_count FROM inventory WHERE status='A'";
		if(!$stmt = $mysqli->prepare($countInventory))
			error_log("shopify: " . "Stats get Prepared Statement Error!" . $stmt->error );

		if(!$stmt->execute()) {
			error_log("shopify: " . "Stats get Failed : stmt->execute:" . $stmt->error) ;
			return $stats;
		}

		if(!$stmt->bind_result($inventory_count)) {
			error_log("shopify: " . "Stats get Failed : stmt->bind result:" . $stmt->error) ;
			return $stats;
		}
		if($stmt->fetch())  {
			return htmlentities($inventory_count);
		} 
	}


	function createInventory($data) {
		$title			= htmlspecialchars($data["title"]);
		$description	= htmlspecialchars($data["description"]);
		$price			= htmlspecialchars($data["price"]);
		$quantity		= htmlspecialchars($data["quantity"]);
		$seller			= htmlspecialchars($data["seller"]);

		global $mysqli;

		$insertInventory = "INSERT INTO inventory(title, description, price, quantity, seller) VALUES (?, ?, ?, ?, ?)";

		if(!$stmt = $mysqli->prepare($insertPost))
			error_log("shopify: " . "Inventory insert Prepared Statement Error!");

		$stmt->bind_param("ssiis", $title, $description, $price, $quantity, $seller);

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

	function updateInventory($data) { // Only owner can edit
		$inventory_id	= htmlspecialchars($data['inventory_id']);
		$price   		= htmlspecialchars($data["price"]);
		$quantity 		= htmlspecialchars($data['quantity']);

		global $mysqli;

		$saveInventory = "UPDATE inventory set price=?, quantity=? where inventory_id =?;";

		if(!$stmt = $mysqli->prepare($savePost))
			error_log("shopify: " . "Inventory edit Prepared Statement Error!");

		$stmt->bind_param("iii", $price, $quantity, $inventory_id);

		if(!$stmt->execute()) {
			error_log("shopify: " . "Inventory change failed : stmt->execute:" . $stmt->error) ;
			return false;
		}

		if(!$stmt->store_result()) {
			error_log("shopify: " . "Inventory change failed" ."Store_result Error");
			return false;
		}

		return true;
	}

	function deleteInventory($inventory_id, $deleteComment) { // Change Status as Deleted, Only owner and superuser delete

		global $mysqli;

		$comment = htmlspecialchars($deleteComment);

		$saveInventory = "UPDATE inventory set delete_comment= ?, status='D' WHERE inventory_id = ?;";

		if(!$stmt = $mysqli->prepare($savePost))
			error_log("shopify: " . "Inventory edit Prepared Statement Error!");

		$stmt->bind_param("si", $deleteComment, $inventory_id);

		if(!$stmt->execute()) {
			error_log("shopify: " . "Inventory change failed : stmt->execute:" . $stmt->error) ;
			return false;
		}

		if(!$stmt->store_result()) {
			error_log("shopify: " . "Inventory change failed" ."Store_result Error");
			return false;
		}

		return true;
	}

	function deleteInventory_old($inventory_id) { // Change Status as Deleted, Only owner and superuser delete

		global $mysqli;

		$saveInventory = "DELETE from inventory WHERE inventory_id = ?;";

		if(!$stmt = $mysqli->prepare($savePost))
			error_log("shopify: " . "Inventory edit Prepared Statement Error!");

		$stmt->bind_param("i", $inventory_id);

		if(!$stmt->execute()) {
			error_log("shopify: " . "Inventory change failed : stmt->execute:" . $stmt->error) ;
			return false;
		}

		if(!$stmt->store_result()) {
			error_log("shopify: " . "Inventory change failed" ."Store_result Error");
			return false;
		}

		return true;
	}

	function validateInventoryId($Id) {

		if(empty($Id)) return FALSE;

		if(!is_numeric($Id)) return FALSE;

		if ($Id == 0) return FALSE;

		return TRUE;
	}

?>