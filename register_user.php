<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ipm/php/common/dbConnect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/ipm/php/common/class.user.php";

//$user = new User($db);

if($user->is_loggedin()!="")
{
    $user->redirect('admin.php');
}

if(isset($_POST['btn-signup']))
{
   //$uname = trim($_POST['txt_uname']);
   $umail = trim($_POST['txt_umail']);
   $upass = trim($_POST['txt_upass']);
   $fname = trim($_POST['txt_fname']);
   $lname = trim($_POST['txt_lname']); 
 
   //if($uname=="") {
     // $error[] = "provide username !"; 
   //}
   if($fname=="") {
      $error[] = "Please enter your first name."; 
   }
   else if($lname=="") {
      $error[] = "Please enter your last name."; 
   }
   else if($umail=="") {
      $error[] = "Please enter an email address."; 
   }
   else if(!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'Please enter a valid email address !';
   }
   else if($upass=="") {
      $error[] = "Please enter a password.";
   }
   else if(strlen($upass) < 6){
      $error[] = "Password must be at least 6 characters."; 
   }
   else
   {
      try
      {
         $stmt = $db->prepare("SELECT email FROM users WHERE email=:umail");
         $stmt->execute(array(':umail'=>$umail));
         $row=$stmt->fetch(PDO::FETCH_ASSOC);
    
         //if($row['user_name']==$uname) {
           // $error[] = "sorry username already taken !";
         //}
         if($row['email']==$umail) {
            $error[] = "Sorry, this email address is already in use.";
         }
         else
         {
            if($user->register($fname,$lname,$umail,$upass)) 
            {
                $user->redirect('login_user.php?joined');
                
            }
         }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
  } 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register</title>
<!--<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css"  />-->
</head>
<body>
<div class="container">
     <div class="form-container">
        <form method="post">
            <h2>Register</h2><hr />
            <?php
            if(isset($error))
            {
               foreach($error as $error)
               {
                  ?>
                  <div class="alert alert-danger">
                      <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                  </div>
                  <?php
               }
            }
            else if(isset($_GET['joined']))
            {
                 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                 </div>
                 <?php
            }
            ?>
            <!--<div class="form-group">
            <input type="text" class="form-control" name="txt_uname" placeholder="Enter Username" value="<?php if(isset($error)){echo $uname;}?>" />
            </div> -->
            <div class="form-group">
             <input type="text" class="form-control" name="txt_fname" placeholder="First Name" />
            </div>

            <div class="form-group">
             <input type="text" class="form-control" name="txt_lname" placeholder="Last Name" />
            </div>

            <div class="form-group">
            <input type="text" class="form-control" name="txt_umail" placeholder="Enter E-Mail ID" value="<?php if(isset($error)){echo $umail;}?>" />
            </div>
            <div class="form-group">
             <input type="password" class="form-control" name="txt_upass" placeholder="Enter Password" />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-signup">
                 <i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
                </button>
            </div>
            <br />
            <label>Already have an account? <a href="login_user.php">Sign In</a></label>
        </form>
       </div>
</div>

</body>
</html>