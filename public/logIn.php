<?php include_once("../include/session.php");?>
<?php include_once("../include/function.php");?>

<?php
$userName = "";
if (isset($_POST['submit']))
{
    $userName = $_POST["userName"];
    $password = $_POST["password"];
    if (empty($password) || empty($userName))
    {
        $_SESSION["message"] = "Please fixed the following error";
        redirect_to("logIn.php");
    }

    $admin = attempt_login($userName,$password);
    if ($admin)
    {
        $_SESSION["message"] = "welcome!";
        redirect_to("admin.php");
    }else
    {
        $_SESSION["message"] = "username or password not found!";
        redirect_to("logIn.php");
    }

}
?>

<?php $layoutContext = "admin";  ?>
<?php include("../include/layouts/header.php");?>

<div id="main">
    <div id="navigation">
        &nbsp;
    </div>
    <div id="page">
        <?php echo message(); ?>
        <h2>Login</h2>
        <form action="logIn.php" method="post">
            <p>User Name:
                <input type="text" name="userName" value="<?php echo $userName ?>">
            </p>
            <p>Password:
                <input type="text" name="password" value="">
            </p>
            <input type="submit" name="submit" value="login">
        </form>
    </div>
</div>
<?php include("../include/layouts/footer.php");?>

