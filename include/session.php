
<?php
    session_start();
    function message()
    {
        if (isset($_SESSION["message"]))
        {
            $output =  "<div class=\"message\">";
            $output .= htmlentities($_SESSION["message"]);
            $output .= "</div>";
            $_SESSION["message"] = null; //clear message
            return $output;
        }
    }

function errors()
{
    if (isset($_SESSION["empty"]))
    {
        $error = htmlentities($_SESSION["message"]);
        $_SESSION["error"] = null; //clear message
        return $error;
    }
}

