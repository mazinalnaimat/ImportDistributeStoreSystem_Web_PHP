<?php


    function InitPageStack() 
    {
        if (!isset($_SESSION['page_stack'])) 
        {
            $_SESSION['page_stack'] = [];
        }
    }

    function GoBackPage() 
    {
        if (isset($_SESSION['page_stack']) && count($_SESSION['page_stack']) > 1) 
        {
            array_pop($_SESSION['page_stack']);
            $previous_page = end($_SESSION['page_stack']);
            header("Location: $previous_page");
            exit;
        } 
    }


?>
