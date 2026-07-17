<?php
declare(strict_types=1);
require_once __DIR__ . "/../DataAccess/Note_DataAccess.php";


    function AddNote_Business($NoteInfo)
    {
        return  AddNote_DataAccess($NoteInfo);
    }
?>