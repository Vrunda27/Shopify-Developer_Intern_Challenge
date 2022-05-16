<?php
    require('session_authenticate.php');

    /* Delete inventory CSRF token */
    $csrfTokenAddInvt = bin2hex(openssl_random_pseudo_bytes(16));
    $_SESSION["csrfTokenAddInvt"] = $csrfTokenAddInvt;


    // $statistics = getStatistics(); 
    // $response  = getInventoryList();

    require('ui_header.php');
?>


        <!-- Inventory Form -->
        <div class="panel">
            <!-- <div class="panel-heading">
                <h3 class="panel-title">Add Inventory</h3>
            </div> -->

            <div class="panel-content panel-activity" align="center">

                <div class="heading regForm">Add Inventory</div><br>
            
               <form name="dform" method="POST" onsubmit="return validate()" action="Auth.php">
                    <input type="hidden" name="csrfTokenAddInvt" value="<?php echo $csrfTokenAddInvt; ?>">
                  <table class="regForm" style="font-size: 18px">
                     <tr>
                        <th>Title <span class="star">*</span><br><input type="text" name="title" class="input" maxlength="30" required pattern = "^[a-zA-Z ]*$" title="Title should only contain alphabets"></th>
                        <th rowspan="2">Description <br><textarea type="text" name="description" class="input" maxlength="50"></textarea></th>
                     </tr>
                     <tr>
                       <th>Price <span class="star">*</span><br><input type="number" name="price" id="mycont" class="input"></th>
                     </tr>
                     <tr>
                        <th>Quantity <span class="star">*</span><br><input type="number" name="quantity" id="mycont" class="input" ></th>
                        <th>Seller <span class="star">*</span><br><input type="text" name="seller" class="input" maxlength="30" required pattern = "^[a-zA-Z ]*$" title="Title should only contain alphabets"></th>
                     </tr>
                     <tr>
                        <th><br><span class="star">* Mandatory Fields</span><br></br>
                     </tr>
                     <tr class="subbtn">
                        <th  colspan="2"><input class="button" type="submit" name="form_type" value="Add Inventory" style="background-color:#1c18ab;"></th>
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