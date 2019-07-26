<?php
include_once("../include/session.php");
require_once("../include/function.php");
find_selected_page();
if (isset($_POST["submitPage"]))
{
    $editId         = $_GET["page"];
    $menuName       = $_POST["menuName"];
    $position       = $_POST["position"];
    $visible        = $_POST["visible"];
    $content        = $_POST["content"];
    if (empty($menuName) || empty($position) || empty($visible) || empty($content))
        redirect_to("editPage.php?empty=1110");
    $dbm = new dbManagement();
    $set = $dbm->getConnection();
    $tempPage = $set->prepare("UPDATE `pages` SET `menu_name`= :menu, `position`= :position,`visible`= :visible, `content`= :content WHERE `id`=:id");
    $page = $tempPage->execute(
            array(
                    ':id' => $editId,
                    ':menu' => $menuName,
                    ':position' => $position ,
                    ':visible' => $visible,
                    ':content' => $content
            ));
    if ($page)
    {
        $_SESSION["message"] = "Page updated";
        redirect_to("manageContent.php");
    }else
    {
        $_SESSION["message"] = "Page update failed";
        redirect_to("newPage.php");
    }
}
if (!$currentPage)
    redirect_to("manageContent.php");
$layoutContext ="admin";
include("../include/layouts/header.php");
$dbm = new dbManagement();
$set = $dbm->getConnection();
$tempPage = $set->prepare("SELECT COUNT(`position`) FROM `pages`");
$tempPage->execute();
$tempFetch = $tempPage->fetchAll(PDO::FETCH_ASSOC);
$tempFetch = $tempFetch[0];
$pageCount = '';
foreach ($tempFetch as $key => $value)
    $pageCount = $value;

?>

<div id="main">
    <div id="navigation">
        <?php echo navigation($currentSubject,$currentPage); ?>
    </div>
    <div id="page">
        <?php
            echo message();
            if (isset($_GET["empty"]))
                echo "Please follow all field! ";
            $valueId = $_GET["page"];
            $tempPage = $set->prepare("SELECT * FROM `pages` WHERE `id`= :id");
            $tempPage->execute(array(':id' => $valueId));
            $tempFetchPage = $tempPage->fetchAll(PDO::FETCH_ASSOC);
            foreach ($tempFetchPage as $record)
            {
        ?>
                <h2>Edit Page: <?php echo $record['menu_name']; ?> </h2>
                <form action="editPage.php?page=<?php echo $record['id']; ?>" method="post">
                    <p>Menu Name:
                        <input type="text" name="menuName" value="<?php echo $record['menu_name']; ?>">
                    </p>
                    <p>Position:
                        <select name="position">
                            <?php
                                for ($count = 1; $count <= $pageCount ; $count++)
                                {
                                    echo "<option value=\"{$count}\"";
                                    if ($record['position'] == $count)
                                        echo "selected";
                                    echo ">{$count}</option>";
                                }
                            ?>
                        </select
                    </p>
                    <p>Visible:
                        <input type="radio" name="visible" value="0" <?php if ($record['visible'] == 0){echo "checked";}; ?>>No
                        <input type="radio" name="visible" value="1" <?php if ($record['visible'] == 1){echo "checked";}; ?>>Yes
                    </p>
                    <p>
                        <label>Content:</label><br>
                        <textarea name="content" rows="20" cols="80"><?php echo $record['content']; ; ?></textarea>
                    </p>
                    <input type="submit" name="submitPage" value="edit page">
                </form>
                <br>
                <a href="manageContent.php">Cancel</a>
                <a name="delete" href="deletePage.php?deletePage=<?php echo $record['id']; ?>" onclick="return confirm('Are you sure');">Delete page</a>
        <?php } ?>
    </div>
</div>
<?php include("../include/layouts/footer.php");?>