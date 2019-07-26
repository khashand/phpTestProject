<?php include_once("../include/session.php");?>
<?php include_once("../include/function.php");?>

<?php
    if (isset($_POST['submit']))
    {
        $userName = $_POST["userName"];
        $password = $_POST["password"];
        if (empty($password) || empty($userName))
        {
            $_SESSION["message"] = "Empty";
        }
        $dbm = new dbManagement();
        $set = $dbm->getConnection();
        $tempAdmin = $set->prepare("INSERT INTO `admin` (userName , password) VALUES (:userName, :password)");
        $adminTemp = $tempAdmin->execute(array(':userName' => $userName, ':password' => md5($password)));
        if ($adminTemp)
        {
            $_SESSION["massage"] = "Admin Created";
            redirect_to("manageAdmin.php");
        }else
        {
            $_SESSION["message"] = "Admin creation failed!";
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
        <h2>Create Admin</h2>
        <form action="newAdmin.php" method="post">
            <p>User Name:
                <input type="text" name="userName" value="">
            </p>
            <p>Password:
                <input type="text" name="password" value="">
            </p>
            <input type="submit" name="submit" value="Create Admin">
        </form>
        <br>
        <a href="manageAdmin.php">Cancel</a>
    </div>
</div>
<?php include("../include/layouts/footer.php");?>

