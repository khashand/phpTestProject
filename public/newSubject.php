<?php include_once("../include/session.php");?>
<?php $layoutContext ="admin";  ?>
<?php include("../include/layouts/header.php");?>
<?php include_once("../include/function.php");?>
<?php find_selected_page(); ?>

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
        <h2>Creat Subject</h2>
        <form action="createSubject.php" method="post">
            <p>Menu Name:
                <input type="text" name="menuName" value="">
            </p>
            <p>Position:
                <select name="position">
                    <?php
                        for ($count = 1 ;$count <= ($subjectCount +1) ;$count++)
                        {
                            echo "<option value=\"{$count}\">{$count}</option>";
                        }
                    ?>
                </select>
            </p>
            <p>Visible:
                <input type="radio" name="visible" value="0">No

                <input type="radio" name="visible" value="1">Yes
            </p>
            <input type="submit" name="submit" value="create submit">
        </form>
        <br>
        <a href="manageContent.php">Cancel</a>
    </div>
</div>

<?php include("../include/layouts/footer.php");?>
