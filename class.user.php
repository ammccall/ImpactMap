<?php

class User
{
    private $db;
 
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
 
    public function register($fname,$lname,$umail,$upass)
    {
       try
       {
           $new_password = password_hash($upass, PASSWORD_DEFAULT);
   
           $stmt = $this->db->prepare("INSERT INTO users(uid, email, firstName, lastName, phone, authenticated, password, root, admin) 
                                                       VALUES('0', :umail, :ufname, :ulname, '123456789', '0', :upass, '0', '0')");
              
           $stmt->bindparam(":umail", $umail);
           $stmt->bindparam(":ufname", $fname);
           $stmt->bindparam(":ulname", $lname);
           $stmt->bindparam(":upass", $new_password);             
           $stmt->execute(); 
   
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
 
    public function login($umail,$upass)
    {
       try
       {
          $stmt = $this->db->prepare("SELECT * FROM users WHERE email=:umail LIMIT 1");
          $stmt->execute(array(':umail'=>$umail));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
             if(password_verify($upass, $userRow['password']))
             {
                $_SESSION['user_session'] = $userRow['email'];
                //echo 'logged in!';
                return true;
             }
             else
             {
                return false;
                //echo 'the error';
             }
          }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }
 
   public function is_loggedin()
   {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }//if
      else
      { 
        return false;
      }//else 
   }
 
   public function redirect($url)
   {
       header("Location: $url");
   }
 
   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   }
}
?>