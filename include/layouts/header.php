<?php
if (!isset($layoutContext)) {
    $layoutContext = "public";
}
?>

<html lang="en">
<head>
    <title>widget crop <?php if ($layoutContext == "admin"){echo "Admin";} ?> </title>
    <link href="../../public/stylesheet/public.css" media="all" rel="stylesheet" type="text/css">
</head>
<body>
<div id="header">
    <h1>Widget Crop <?php if ($layoutContext == "admin"){echo "Admin";} ?></h1>
</div>