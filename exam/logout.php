<?php
session_start();
$_SESSION=array();
if(isset($_COOKIE[session_name()])){
    setcookie(session_name(),1,  time()+(1*0*0*2));
    header("location: index.php");
}

?>
