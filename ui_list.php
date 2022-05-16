<?php

    require('session_authenticate.php');

    require('ui_header.php');

    /* Delete inventory CSRF token */
    $csrfTokenDelInvt = bin2hex(openssl_random_pseudo_bytes(16));
    $_SESSION["csrfTokenDelInvt"] = $csrfTokenDelInvt;

    $response  = getInventoryList();

?>


        <!-- Inventory List -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Inventory List</h3>
                <button class="btn btn-rounded btn-info" style="float:right;" onclick="document.location.href='ui_createInventory.php';">
                    <i class="fa fa-user-plus"></i>
                    <span>Add Inventory</span>
                </button>
            </div>

            <div class="panel-content panel-activity">
                <table class="table table-bordered">
                    <?php if(!empty($response)) {?>
                    <thead class="bg">
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Seller</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php foreach($response as $inventory) {?>
                        <tr class="rowbg">
                            <td><?php echo $inventory['title'];?> </td>
                            <td><?php echo $inventory['description'];?></td>
                            <td><?php echo $inventory['price'];?></td>
                            <td><?php echo $inventory['quantity'];?></td>
                            <td><?php echo $inventory['seller'];?></td>
                            <td><?php echo date('d M Y, h:i A', strtotime($inventory['created']));?></td>
                            <td>
                                <a href="ui_editInventory.php?id=<?php echo $inventory['inventory_id']?>">
                                <button class="btn btn-rounded btn-primary" width="200px">
                                    Edit
                                </button></a>
                                <button class="btn btn-rounded btn-danger" onclick="confirmation(<?php echo $inventory['inventory_id']; ?>)">
                                    Delete
                                </button>
                                <form id="deleteForm_<?php echo $inventory['inventory_id']; ?>" style="display: none;" method="POST" action="Auth.php">
                                    <input type="hidden" name="csrfTokenDelInvt" value="<?php echo $csrfTokenDelInvt; ?>">
                                    <input type="hidden" name="inventory_id" value="<?php echo $inventory['inventory_id']; ?>">
                                    <input type="comment" name="deleteComment" id="delComment_<?php echo $inventory['inventory_id']; ?>">
                                    <input name="form_type" value="delete_inventory">
                                </form>
                            </td>
                        </tr>
                        <?php 
                            } // end of  empty response
                        ?>
                    </tbody>
                    <?php 
                        } // end of  empty response
                    ?>
                </table>
            </div>

        </div> <!-- End of Inventory List -->
    </div>
    <script type="text/javascript">
        function confirmation(inventory_id) {

            let comment = prompt("Enter your comments for deletion:");
            if (comment != null && comment != "") {
                document.getElementById("delComment_"+inventory_id).value = comment;
                document.getElementById('deleteForm_'+inventory_id).submit();
                return true;
            }
            return false;
        }
    </script>
</body>
</html>