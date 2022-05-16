<?php
	require('db_inventory.php');

    $statistics = getInventoryCount(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="icon.png" rel="icon">
    <title>Shopify Challenge</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel = "stylesheet" href = "style.css"> 
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        table {
            color: black;
            border: 1px solid black;
        }
        td, thead {
            text-align: center;
        }
        .bg {
            background-color: #d0a9ec80;
        }
        .rowbg {
            background-color: white;
        }
    </style>
</head>

<body class="profile_body">

    <div class="container">

        <!-- Profile Header -->
        <div class="panel profile-cover">
            <div class="profile-cover__img">
                <img src="postProfile.png" alt="" />
                <h3 class="h3"><b>
                <?php 
                    echo $_SESSION['username'];
                ?></b></h3>
            </div>
            <div class="profile-cover__action bg--img" data-overlay="0.3">
                <button class="btn btn-rounded btn-info" onclick="document.location.href='ui_list.php';">
                    <i class="fa fa-book"></i>
                    <span>Inventory List</span>
                </button>
                <button class="btn btn-rounded btn-info" onclick="document.location.href='ui_changePassword.php';">
                    <i class="fa fa-lock"></i>
                    <span>Change Password</span>
                </button>
                <button class="btn btn-rounded btn-info" onclick="document.location.href='Auth_logout.php';">
                    <i class="fa fa-sign-out"></i>
                    <span>Logout</span>
                </button>
            </div>
            <div class="profile-cover__info">
                <ul class="nav">
                    <!-- <li><strong><?php //echo $value['count_user']; ?></strong>Users</li> -->
                    <li><strong><?php echo $statistics; ?></strong><b>Total Inventories</b></li>
                </ul>
             <?php
                //     }
                // }
            ?>
            </div>
        </div> <!-- End of Profile Header -->