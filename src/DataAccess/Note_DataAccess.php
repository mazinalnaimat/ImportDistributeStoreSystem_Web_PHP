<?php
declare(strict_types=1);
require_once __DIR__ . "/Settings.php";

    function AddNote_DataAccess($NoteInfo)      
    {        
        $Connection = null;
        $Stmt = null;

        try 
        {
            $Connection = Get_PDO_Connection();
            if ($Connection === null) 
            {
                return null;
            }

            $Stmt = $Connection->prepare
            (
                "INSERT INTO 
                            notes( CreatedUserId, CreatedDateTime, Title, Text)
                            VALUES 
                            (
                                :CreatedUserId,
                                :CreatedDateTime,
                                :Title,
                                :Text
                            )
                "
            );
            $Stmt->bindValue(":CreatedUserId", $NoteInfo['CreatedUserId']);

            $Date = new DateTime('now', new DateTimeZone('Asia/Amman'));
            $CurrentDateTime = $Date->format('Y-m-d H:i:s');
            $Stmt->bindValue(":CreatedDateTime", $CurrentDateTime);

            $Stmt->bindValue(":Title", $NoteInfo['Title']);
            $Stmt->bindValue(":Text", $NoteInfo['Text']);


            $Stmt->execute();
            $NoteId = $Connection->lastInsertId();  

            return $NoteId; //if no insert row return 0
        } 
        catch (PDOException $e)
        {
            return null;
        } 
        finally 
        {
            $Stmt = null;
            $Connection = null;
        }
    }

   
?>