<?php include_once("../include/session.php");?>
<?php include_once("../include/function.php");?>

<?php
if (isset($_POST["editSubmit"]))
{
    $editId = $_GET["idEdit"];
    $userName = $_POST["userName"];
    $password = $_POST["password"];
    if (empty($password) || empty($userName))
    {
        $_SESSION["message"] = "Empty";
    }
    $dbm = new dbManagement();
    $set = $dbm->getConnection();
    $tempAdmin = $set->prepare("UPDATE  `admin` SET `userName` = :userName , `password` = :password WHERE `admin`.`id`=:id");
    $adminTemp = $tempAdmin->execute(array(':id' => $editId , ':userName' => $userName, ':password' => md5($password)));
    if ($adminTemp)
    {
        $_SESSION["massage"] = "Admin Edited";
        redirect_to("manageAdmin.php");
    }else
    {
        $_SESSION["message"] = "Admin edition failed!";
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
        <h2>Edit Admin</h2>
        <?php
        $editId = $_GET["idEdit"];
        $dbm = new dbManagement();
        $set = $dbm->getConnection();
        $temp = $set->prepare("SELECT * FROM `admin` WHERE `id`= :id");
        $temp->execute(array(':id' => $editId));
        $tempFetch = $temp->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tempFetch as $record){
        ?>
        <form action="editAdmin.php?idEdit=<?php echo $editId; ?>" method="post">
            <p>User Name:
                <input type="text" name="userName" value="<?php echo $record['userName']; ?>">
            </p>
            <p>Password:
                <input type="text" name="password" value="">
            </p>
            <input type="submit" name="editSubmit" value="Edit Admin">
        </form>
        <?php } ?>
        <br>
        <a href="manageAdmin.php">Cancel</a>
    </div>
</div>

<?php include("../include/layouts/footer.php");?>

