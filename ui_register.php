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
   </head>

   <body class="container-auth">

      <div class="container">

           <div class="panel-activity_status" align="center">

               <div class="heading regForm">Registration</div><br>
			
               <form name="dform" method="POST" onsubmit="return validate()" action="Auth.php">
                  <table class="regForm" style="font-size: 18px">
                     <tr>
                        <th>Name <span class="star">*</span><br><input type="text" name="name" class="input" maxlength="30" required pattern = "^[a-zA-Z ]*$" title="Name should only contain alphabets"></th>
                        <th>Location <br><textarea type="text" name="location" class="input" maxlength="50"></textarea></th>
                     </tr>
                     <tr>
                        <th>Email <span class="star">*</span><br><input type="email" name="email" id="myEmail"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" class="input" required></th>
                        <th>Contact <br><input type="text" name="contact" id="mycont" class="input" pattern="^(\+\d{2,4})?\s?(\d{10})$"></th>
                     </tr>
                     <tr>
                        <th>Password <span class="star">*</span><br><input type="password" name="password" class="input" minlength="8" maxlength="16" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,16}$" title="Password must have at least 8 and maximum 16 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE"  onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');
                        form.repassword.pattern = this.value;"></th>
                        <th>Confirm Password <span class="star">*</span><br><input type="password" name="repassword" class="input" minlength="8" maxlength="16" required  required title="Password does not match" onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');"></th>
                     </tr>
                     <tr>
                        <th><br><span class="star">* Mandatory Fields</span><br></br>
                        <th><br>Already a User?  <a href="index.php">Sign In!</a><br></br>
                     </tr>
                     <tr class="subbtn">
                        <th  colspan="2"><input class="button" type="submit" name="form_type" value="Register" style="background-color:#1c18ab;"></th>
                     </tr>
                  </table>
               </form>
            </div>
			
			</div>
		
	  </div>
   </body>
</html>