<?php include_once("../include/session.php");?>
<?php include("../include/function.php");?>
<?php require_once("../public/config.php");?>

<?php

/*if (isset($_GET["deletePage"])) {
    $deleteId = $_GET["deletePage"];
    $dbm = new dbManagement();
    $set = $dbm->getConnection();
    $tempPage = $set->prepare("SELECT COUNT(`id`) FROM `pages` WHERE `subject_id`= :subject_id");
    $tempPage->execute(array(':subject_id' => $deleteId));
    $tempFetch = $tempPage->fetchAll(PDO::FETCH_ASSOC);
    $tempFetch = $tempFetch[0];
    $pageCount = '';
    foreach ($tempFetch as $key => $value)
        $pageCount = $value;
    if ($pageCount > 0)
    {
        redirect_to(" manageContent.php?noDelete=5454");
        exit;
    }
}*/
if (isset($_GET["deletePage"]))
{
    $deleteId = $_GET["deletePage"];
    $dbm = new dbManagement();
    $set = $dbm->getConnection();
    $tempSubject = $set->prepare("DELETE FROM `pages` WHERE `id` = :id");
    $subject = $tempSubject->execute(array(':id' => $deleteId));
    if ($subject)
    {
        $_SESSION["message"] = "Page deleted";
        redirect_to("manageContent.php");
    }else
    {
        $_SESSION["message"] = "Page deletion failed";
        redirect_to("manageContent.php");
    }
}


