<?php include_once("../include/session.php");?>
<?php require_once("../include/function.php");?>
<?php find_selected_page(); ?>
<?php
    if (isset($_POST["submit"]))
    {
        $editId= $_GET["subject"];
        $menuName = $_POST["menuName"];
        $position = $_POST["position"];
        $visible = $_POST["visible"];
        if (empty($menuName) || empty($position) || empty($visible))
        {
            redirect_to("edit_subject.php?empty=1110");
        }
        $dbm = new dbManagement();
        $set = $dbm->getConnection();
        $tempSubject = $set->prepare("UPDATE `subject` SET `menu_name`= :menu, `position`= :position, `visible`= :visible WHERE `id`=:id");
        $subject = $tempSubject->execute(array(':id' => $editId, ':menu' => $menuName, ':position' => $position , ':visible' => $visible));
        if ($subject)
        {
            $_SESSION["message"] = "Subject updated";
            redirect_to("manageContent.php");
        }else
        {
        $_SESSION["message"] = "Subject update failed";
        redirect_to("newSubject.php");
        }
    }


?>
<?php
    if (!$currentSubject)
    {
        redirect_to("manageContent.php");
    }
?>
<?php $layoutContext ="admin";  ?>
<?php include("../include/layouts/header.php");?>

<?php

$dbm = new dbManagement();
$set = $dbm->getConnection();
$tempPage = $set->prepare("SELECT COUNT(`id`) FROM `subject`");
$tempPage->execute();
$tempFetch = $tempPage->fetchAll(PDO::FETCH_ASSOC);
$tempFetch = $tempFetch[0];
$subjectCount = '';
foreach ($tempFetch as $key => $value)
    $subjectCount = $value;

?>

<div id="main">
    <div id="navigation">
        <?php echo navigation($currentSubject,$currentPage); ?>
    </div>
    <div id="page">
        <?php echo message(); ?>
        <?php
        if (isset($_GET["empty"]))
        {
            echo "Please follow all field! ";
        }

        ?>
        <?php
            $valueId = $_GET["subject"];
            $tempSubject = $set->prepare("SELECT * FROM `subject` WHERE `id`= :id");
            $tempSubject->execute(array(':id' => $valueId));
            $tempFetchSubject = $tempSubject->fetchAll(PDO::FETCH_ASSOC);
            foreach ($tempFetchSubject as $record) {
                ?>

                <h2>Edit Subject: <?php echo $record['menu_name']; ?> </h2>
                <form action="edit_subject.php?subject=<?php echo $record['id']; ?>" method="post">
                    <p>Menu Name:
                        <input type="text" name="menuName" value="<?php echo $record['menu_name']; ?>">
                    </p>
                    <p>Position:
                        <select name="position">
                            <?php
                            for ($count = 1; $count <= $subjectCount ; $count++) {
                                echo "<option value=\"{$count}\"";
                                if ($record['position'] == $count)
                                {
                                   echo "selected";
                                }
                                echo ">{$count}</option>";
                            }
                            ?>
                        </select>
                    </p>
                    <p>Visible:
                        <input type="radio" name="visible" value="0" <?php if ($record['visible'] == 0){echo "checked";}; ?>>No

                        <input type="radio" name="visible" value="1" <?php if ($record['visible'] == 1){echo "checked";}; ?>>Yes
                    </p>
                    <input type="submit" name="submit" value="edit subject">
                </form>
                <br>
                <a href="manageContent.php">Cancel</a>
                &nbsp;
                &nbsp;
                <a name="delete" href="deleteSubject.php?deleteSubject=<?php echo $record['id']; ?>" onclick="return confirm('Are you sure');">Delete subject</a>
                <?php
            }
        ?>
    </div>
</div>

<?php include("../include/layouts/footer.php");?>
