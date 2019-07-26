<?php include_once("../include/session.php");?>
<?php include("../include/layouts/header.php");?>
<?php require_once("../include/function.php");?>

<?php find_selected_page() ?>
<?php

function password_encrypts($password)
{
    $hashFormat = "$2y$10$";
    $saltLength = 22;
    $salt = generate_salts($saltLength);
    $formatAndSalt = $hashFormat.$salt;
    $hash = crypt($password , $formatAndSalt);
    return $hash;
}
function generate_salts($length)
{
    $uniqueRandomString = md5(uniqid(mt_rand(),true));
    $base64String = base64_decode($uniqueRandomString);
    $modifiedBase64String = str_replace('+','.',$base64String);
    $salt = substr($modifiedBase64String,0,$length);
    return $salt;
}
echo password_encrypts('aaaa');
?>

<div id="main">
    <div id="navigation">
        <?php echo public_navigation($currentSubject,$currentPage); ?>
    </div>
    <div id="page">
        <?php if ($currentPage) { ?>
            <h2><?php foreach ($currentPage as $recordPages) {echo nl2br($recordPages['menu_name']); ?></h2><br>
                <?php echo $recordPages['content'];  ?>
            <?php  } }else { ?>
            <h1>Welcome!</h1>
        <?php } ?>


    </div>
</div>

<?php include("../include/layouts/footer.php");?>
