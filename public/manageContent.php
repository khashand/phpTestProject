<?php include_once("../include/session.php");?>
<?php $layoutContext ="admin";  ?>
<?php include("../include/layouts/header.php");?>
<?php require_once("../include/function.php");?>

<?php find_selected_page() ?>


<div id="main">
    <div id="navigation">
        <a href="admin.php"> &laquo; Main Menu</a>
        <?php echo navigation($currentSubject,$currentPage); ?>
        <br>
        <a href="newSubject.php"> + Add a Subject</a>
    </div>
    <div id="page">
        <?php echo message(); ?>

        <?php if ($currentSubject) { ?>
        <h2>Manage Subject</h2>
        Menu name: <?php
            foreach ($currentSubject as $record) {echo $record['menu_name']; ?><br>
                position: <?php echo $record['position']; ?><br>
                visible: <?php echo $record['visible'] ==1 ?'yes':'no'; ?><br><br>
                <a href="edit_subject.php?subject=<?php echo $record['id']; ?>">Edit Subject</a>
                <br><hr><br>
                <div style="margin-top: 2em; border-top=1px solid #000000;">
                <h3>Pages in this subject:</h3>
                <ul>
                    <?php
                        $dbm = new dbManagement();
                        $set = $dbm->getConnection();
                        $tempPage = $set->prepare("SELECT * FROM `pages` WHERE `subject_id`= :subject_id");
                        $tempPage->execute(array(':subject_id' => $record['id']));
                        $tempFetch = $tempPage->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($tempFetch as $recordPage){
                    ?>
                    <li><a href="manageContent.php?page=<?php echo $recordPage['id']; ?>"><?php echo $recordPage['menu_name']; ?></a> </li>
                    <?php } ?>
                </ul>
                +<a href="newPage.php?subject=<?php echo $record['id']; ?>"> Add a new page to this subject</a>
                </div>
        <?php } }elseif($currentPage) { ?>
        <h2>Manage Page</h2>
        Menu name: <?php
            foreach ($currentPage as $recordPages) { echo $recordPages['menu_name']; ?><br>
                position: <?php echo $recordPages['position']; ?><br>
                visible: <?php echo $recordPages['visible'] ==1 ?'yes':'no'; ?><br>
                content:<br>
                <div class="view-content">
                    <?php echo $recordPages['content']; ?><br>
                </div>
                <a href="editPage.php?page=<?php echo $recordPages['id']; ?>">Edit Page</a>
            <?php }  }else { ?>
        Please select a subject or a page.<br><br>

        <?php } ?>


    </div>
</div>

<?php include("../include/layouts/footer.php");?>
