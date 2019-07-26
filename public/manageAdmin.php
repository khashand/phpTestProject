<?php include_once("../include/session.php");?>
<?php require_once("../include/function.php");?>

<?php
    $adminSet = find_all_admins();
?>
<?php $layoutContext = "admin";  ?>
<?php include("../include/layouts/header.php");?>

<div id="main">

    <div id="navigation">
        <br>
        <a href="admin.php"> &laquo; Main Menu</a>
        &nbsp;
    </div>
    <div id="page">
        <?php echo message(); ?>
        <h2>Manage Admin</h2>
        <table>
            <tr>
                <th style="text-align: left;width: 200px;">UserName</th>
                <th style="text-align: left;colspan=2;">Action</th>
            </tr>
            <?php  foreach ($adminSet as $admin) { ?>
            <tr>
                <td><?php echo htmlentities($admin['userName']); ?></td>
                <td><a href="editAdmin.php?idEdit=<?php echo $admin['id']; ?>">Edit</a></td>
                <td><a href="deleteAdmin.php?idDelete=<?php echo $admin['id']; ?>" onclick="return confirm('Are you sure')">Delete</a></td>
            </tr>
                <br>
                <?php //echo htmlentities($admin['password']); ?>
            <?php } ?>
        </table>
        <br>
        <a href="newAdmin.php">Add new admin</a>
        <hr>
    </div>
</div>
<?php include("../include/layouts/footer.php");?>
