<?php

    require('session_authenticate.php');
    require('ui_header.php');
    
    /* Edit inventory CSRF token */
    $csrfTokenEditInvt = bin2hex(openssl_random_pseudo_bytes(16));
    $_SESSION["csrfTokenEditInvt"] = $csrfTokenEditInvt;

    if(!isset($_GET) || empty($_GET['id'])) {
        die();
    }
    $inventory_id = $_GET['id'];
    $response  = getInventory($inventory_id);
?>


       <!-- Inventory Form -->
        <div class="panel">
            <!-- <div class="panel-heading">
                <h3 class="panel-title">Add Inventory</h3>
            </div> -->

            <div class="panel-content panel-activity" align="center">

                <div class="heading regForm">Edit Inventory - <?php echo $response['title']?></div><br>
            
               <form name="dform" method="POST" onsubmit="return validate()" action="Auth.php">
                      <input type="hidden" name="csrfTokenEditInvt" value="<?php echo $csrfTokenEditInvt; ?>">
                      <input type="hidden" name="inventory_id" value="<?php echo $response['inventory_id']?>">
                      <table class="regForm" style="font-size: 18px">
                         <tr>
                           <th>Price <br><input type="number" name="price" id="mycont" class="input" value="<?php echo $response['price']?>"></th>
                           <th>Quantity <br><input type="number" name="quantity" id="mycont" class="input" value="<?php echo $response['quantity']?>"></th>
                         </tr>
                        
                         <tr class="subbtn">
                            <th  colspan="2"><input class="button" type="submit" name="form_type" value="Save Inventory" style="background-color:#1c18ab;"></th>
                         </tr>
                      </table>
               </form>
            </div>

            </div>

        </div> <!-- End of Inventory Form -->
    </div>
    <script type="text/javascript">
    </script>
</body>
</html>
