<?php require_once("../include/session.php");?>
<?php require_once("../include/function.php");?>
<?php require_once("../include/validation_functions.php");?>

<?php
if (isset($_POST["submit"]))
{
    $subjectId = $_GET["subjectId"];
    $menuName = $_POST["menuName"];
    $position = $_POST["position"];
    $visible = $_POST["visible"];
    $content = $_POST["content"];
    if (empty($menuName) || empty($position) )
    {
        $_SESSION["message"] = "please following all";
        redirect_to("newPage.php");

    }
    $dbm = new dbManagement();
    $set = $dbm->getConnection();
    $tempSubject = $set->prepare("INSERT INTO `pages` (subject_id, menu_name, position, visible, content) VALUES (:subject_id, :menu_name , :position ,:visible, :content)");
    $subject = $tempSubject->execute(array(':subject_id' => $subjectId, ':menu_name' => $menuName, ':position' => $position , ':visible' => $visible, ':content' => $content));
    if ($subject)
    {
        $_SESSION["message"] = "Page created";
        redirect_to("manageContent.php");
    }else
    {
        $_SESSION["message"] = "Page creation failed";
        redirect_to("newPage.php");
    }
}else
{
    redirect_to("newPage.php");
}

?>
<?php include("../include/layouts/footer.php");?>
