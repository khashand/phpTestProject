<?php
include_once("../include/session.php");
include_once("../include/function.php");
?>
<?php
    $_SESSION["adminId"] = null;
    $_SESSION["userName"] = null;
    redirect_to("logIn.php");

//    session_start();
//    $_SESSION = array();
//    if (isset($_COOKIE[session_name()]))
//    {
//        setcookie(session_name() , '',time()-42000,'/');
//    }
//    session_destroy();
//    redirect_to("logIn.php");

    ?>
