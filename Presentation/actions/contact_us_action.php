<?php
require_once __DIR__ . "/../includes/auth.php";


require_once __DIR__ . "/../../Business/Note.php";


function GoBack()
{
    unset($_SESSION["PageVars"]);
    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/dashboard.php");
    exit();

}

function AddNote($NoteInfo)
{
    return AddNote_Business($NoteInfo);
}

function Redirect()
{
    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/contact_us.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
   
    // Go back
    if (isset($_GET['go_back']))
    {
        GoBack();
    }

   Redirect();

}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if (isset($_POST['add_note']))
    {
        $CreatedUserId = $_SESSION['CurrentUser']['UserId'];
        $Title = trim($_POST['note_title']);
        $Text  = trim($_POST['note_text']);

        $NoteInfo['CreatedUserId'] = 1;
        $NoteInfo['Title'] = $Title;
        $NoteInfo['Text'] = $Text;



        if ($Title == "" || $Text == "")
        {
            $_SESSION["PageVars"]["NoteStatus"] = false;
        }

        else 
        {
            $NoteId = AddNote($NoteInfo);
            if( $NoteId != null && $NoteId != 0)
            {
                $_SESSION["PageVars"]["NoteStatus"] = true;
                $_SESSION["PageVars"]["NoteId"] = $NoteId;
        
            }
            else
            {
                $_SESSION["PageVars"]["NoteStatus"] = false;

            }
        }

    }
    Redirect();

}

?>