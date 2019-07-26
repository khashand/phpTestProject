<?php include("../include/layouts/header.php");?>
<?php $layoutContext ="admin";  ?>
<?php require_once("../include/function.php");?>



<div id="main">
    <div id="navigation">
        &nbsp;
    </div>
    <div id="page">
        <h2>Admin Menu</h2>
        <p>Welcome to the admin area</p>
        <ul>
            <li><a href="manageContent.php">Manage Website Content</a> </li>
            <li><a href="manageAdmin.php">Manage Admin User</a> </li>
            <li><a href="logOut.php">LogOut</a> </li>
        </ul>
    </div>
</div>


<?php include("../include/layouts/footer.php");?>
