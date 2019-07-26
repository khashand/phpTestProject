<?php include("../public/config.php");

function redirect_to($newLocation)
{
    header("location: ".$newLocation);
    exit;
}

function dynamic_select($table,$id)
{
    $dbm = new dbManagement();
    $set = $dbm->getConnection();
    $tempPage = $set->prepare("SELECT * FROM `$table` WHERE `id`= :id LIMIT 1");
    $tempPage->execute(array(':id' => $id));
    if ($page = $tempPage->fetchAll(PDO::FETCH_ASSOC))
        return $page;
    return null;

}

function find_selected_page()
{
    global $currentSubject,$currentPage;
    $currentPage =$currentSubject = null;
    if (isset($_GET["subject"]))
        $currentSubject = dynamic_select("subject",$_GET["subject"]);
    elseif (isset($_GET["page"]))
        $currentPage = dynamic_select("pages",$_GET["page"]);
}

function default_page_for_subject($subjectId)
{

    $visible2 = '1';
    $dbm = new dbManagement();
    $set = $dbm->getConnection();
    $tempPage = $set->prepare("SELECT * FROM `pages` WHERE `visible`= :visible AND `subject_id`= :subject_id ORDER BY `position` ASC");
    $tempPage->execute(array(':visible' => $visible2, ':subject_id' => $subjectId));
    $pageFetch = $tempPage->fetchAll(PDO::FETCH_ASSOC);
    if ($pageFetch)
    {
        return $pageFetch;
    }else{
        return null;
    }

}

function find_all_admins()
{
    $dbm = new dbManagement();
    $set = $dbm->getConnection();
    $adminSet = $set->prepare("SELECT * FROM `admin` ORDER BY `userName` ASC");
    $adminSet->execute();
    $admin = $adminSet->fetchAll(PDO::FETCH_ASSOC);
    return $admin;
}

function navigation($subjectArray,$pageArray)
{

    $dbm = new dbManagement();
    $set = $dbm->getConnection();
    $output = "<ul class=\"subjects\">";
    $visible = '';
    $tempSubject = $set->prepare("SELECT * FROM `subject` ORDER BY `position` ASC");
    $tempSubject->execute();
    $navigationFetch = $tempSubject->fetchAll(PDO::FETCH_ASSOC);
    foreach ($navigationFetch as $recordSubject)
    {
        $output .= "<li";
        if ($subjectArray && $recordSubject['id'] == $subjectArray)
        {
            $output .=  "class=\"selected\"";
        }
        $output .= ">";
        $output .="<a href=\"manageContent.php?subject=";
        $output .= urlencode($recordSubject['id']) ;
        $output .= "\">";
        $output .= $recordSubject['menu_name'] ;
        $output .= "</a>";
        $output .="<ul class=\"pages\">";
        $tempPage = $set->prepare("SELECT * FROM `pages` WHERE `subject_id`= :subject_id ORDER BY `position` ASC");
        $tempPage->execute(array(':subject_id' => $recordSubject['id'] ));
        $pageFetch = $tempPage->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pageFetch as $recordPage)
        {
            $output .="<li";
            if ($pageArray && $recordPage['id'] == $pageArray)
            {
                $output .= "class=\"selected\"";
            }
            $output .= ">";
            $output .= "<a href=\"manageContent.php?page=";
            $output .= urlencode($recordPage['id']);
            $output .="\">";
            $output .= $recordPage['menu_name'];
            $output .= "</a>" ;
            $output .="</li>";
        }
        $output .="</ul>";
        $output .="</li>";
    }
    $output .="</ul>";
    return $output;
}

function public_navigation($subjectArray,$pageArray)
{
    $subjectArray = $subjectArray[0];
    $pageArray = $pageArray[0];
    $dbm = new dbManagement();
    $set = $dbm->getConnection();
    $visible = '1';
    $output = "<ul class=\"subjects\">";
    $tempSubject = $set->prepare("SELECT * FROM `subject` WHERE `visible`= :visible ORDER BY `position` ASC");
    $tempSubject->execute(array(':visible' => $visible));
    $navigationFetch = $tempSubject->fetchAll(PDO::FETCH_ASSOC);
    foreach ($navigationFetch as $recordSubject)
    {

        $output .= "<li";
        if ($subjectArray && $recordSubject['id'] == $subjectArray['id'])
        {
            $output .=  "class=\"selected\"";
        }
        $output .= ">";
        $output .="<a href=\"index.php?subject=";
        $output .= urlencode($recordSubject['id']) ;
        $output .= "\">";
        $output .= $recordSubject['menu_name'] ;
        $output .= "</a>";

        if ( $recordSubject['id'] == $subjectArray["id"] || $recordSubject['id'] == $pageArray["subject_id"])
        {
            $output .= "<ul class=\"pages\">";
            $visible2 = 1;
            $tempPage = $set->prepare("SELECT * FROM `pages` WHERE `visible`= :visible AND `subject_id`= :subject_id ORDER BY `position` ASC");
            $tempPage->execute(array(':visible' => $visible2, ':subject_id' => $recordSubject['id']));
            $pageFetch = $tempPage->fetchAll(PDO::FETCH_ASSOC);
            foreach ($pageFetch as $recordPage)
            {
                $output .= "<li";
                if ($pageArray && $recordPage['id'] == $pageArray['id'])
                {
                    $output .= "class=\"selected\"";
                }
                $output .= ">";
                $output .= "<a href=\"index.php?page=";
                $output .= urlencode($recordPage['id']);
                $output .= "\">";
                $output .= $recordPage['menu_name'];
                $output .= "</a>";
                $output .= "</li>";
            }
            $output .="</ul>";
        }
        $output .="</li>";
    }
    $output .="</ul>";
    return $output;
}

function password_encrypt($password)
{
    $hashFormat = "$2y$10$";
    $saltLength = 22;
    $salt = generate_salt($saltLength);
    $formatAndSalt = $hashFormat.$salt;
    $hash = crypt($password,$formatAndSalt);
    return $hash;
}

function generate_salt($length)
{
    $uniqueRandomString = md5(uniqid(mt_rand(),true));
    $base64String = base64_decode($uniqueRandomString);
    $modifiedBase64String = str_replace('+','.',$base64String);
    $salt = substr($modifiedBase64String,0,$length);
    return $salt;
}


function attempt_login($userName,$password)
{
    $dbm = new dbManagement();
    $set = $dbm->getConnection();
    $tempAdmin = $set->prepare("SELECT * FROM `admin` WHERE `userName`= :userName");
    $tempAdmin->execute(array(':userName' => $userName));
    $adminFetch = $tempAdmin->fetchAll(PDO::FETCH_ASSOC);
    foreach ($adminFetch as $admin)
    {
        if ($adminFetch)
            if (md5($password)==$admin['password'])
                return $admin;
        return false;
    }
}
