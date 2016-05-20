<?php
session_start();

if(!isset($_SESSION['user_session']))
{
 header("Location: index.htm");
}
else if(isset($_SESSION['user'])!="")
{
 header("Location: index.htm");
}

if(isset($_GET['logout']))
{
 session_destroy();
 unset($_SESSION['user_session']);
 //unset($_SESSION['logged_in']);
 //set($_SESSION['logged_in']="");
 set($_SESSION['user_session']="");
 header("Location: index.htm");
}
?>