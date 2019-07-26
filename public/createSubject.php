<?php require_once("../include/session.php");?>
<?php require_once("../include/function.php");?>
<?php require_once("../include/validation_functions.php");?>

<?php
    if (isset($_POST["submit"]))
    {
        $menuName = $_POST["menuName"];
        $position = $_POST["position"];
        $visible = $_POST["visible"];
        if (empty($menuName) || empty($position) )
        {
            redirect_to("newSubject.php?empty=1110");

        }
        $dbm = new dbManagement();
        $set = $dbm->getConnection();
        $tempSubject = $set->prepare("INSERT INTO `subject` (menu_name, position, visible) VALUES (:menu_name , :position ,:visible)");
        $subject = $tempSubject->execute(array(':menu_name' => $menuName, ':position' => $position , ':visible' => $visible));
        if ($subject)
        {
            $_SESSION["message"] = "Subject create";
            redirect_to("manageContent.php");
        }else
        {
            $_SESSION["message"] = "Subject creation failed";
            redirect_to("newSubject.php");
        }
    }else
    {
        redirect_to("newSubject.php");
    }

?>
<?php include("../include/layouts/footer.php");?>
