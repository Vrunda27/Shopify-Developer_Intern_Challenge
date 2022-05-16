<?php
    require('session_authenticate.php');
    $rand = bin2hex(openssl_random_pseudo_bytes(16));
    $_SESSION["csrfTokenChangePasswordForm"] = $rand;
    require('ui_header.php');
?>

        <!-- Activity Feed -->
        <div class="panel">
            
            <div class="panel-content panel-activity">
                <div class="panel-activity_status" align="center">
                    <div class="heading regForm">Change Password</div><br>
                    <form name="dform" method="POST" action="../Auth.php">
                      <input type="hidden" name="csrfTokenChangePasswordForm" value="<?php echo $rand; ?>">
                      <table class="regForm" style="font-size: 18px">
                         <tr>
                            <th>Password <span class="star">*</span><br><input type="password" name="password" class="input" minlength="8" maxlength="16" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,16}$" title="Password must have at least 8 and maximum 16 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE"  onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');
                            form.repassword.pattern = this.value;"></th>
                            <th>Confirm Password <span class="star">*</span><br><input type="password" name="repassword" class="input" minlength="8" maxlength="16" required  required title="Password does not match" onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');"></th>
                         </tr>
                         <tr>
                            <th><br><span class="star">* Mandatory Fields</span><br></br>
                         </tr>
                         <tr class="subbtn">
                            <th  colspan="2"><input class="button" type="submit" name="form_type" value="Change Password"></th>
                         </tr>
                      </table>
                   </form>
                </div>
            </div>

        </div> <!-- End of Activity Feed -->
    </div>
    
</body>
</html>