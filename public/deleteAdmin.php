<?php include_once("../include/session.php");?>
<?php include_once("../include/function.php");?>

<?php
if (isset($_GET["idDelete"]))
{
    $deleteId = $_GET["idDelete"];
    $dbm = new dbManagement();
    $set = $dbm->getConnection();
    $tempAdmin = $set->prepare("DELETE FROM `admin` WHERE `id` = :id");
    $adminTemp = $tempAdmin->execute(array(':id' => $deleteId));
    if ($adminTemp)
    {
        $_SESSION["message"] = "Admin Deleted";
        redirect_to("manageAdmin.php");
    }else
    {
        $_SESSION["message"] = "Admin deletion failed!";
        redirect_to("manageAdmin.php");

    }

}
?>

<?php $layoutContext = "admin";  ?>
<?php include("../include/layouts/header.php");?>


<?php include("../include/layouts/footer.php");?>

