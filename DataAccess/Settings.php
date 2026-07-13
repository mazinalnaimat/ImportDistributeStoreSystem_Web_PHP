<?php



    function Get_PDO_Connection()
    {
        $ConnectionString = "mysql:host=localhost;dbname=basic_dgs_db";
        $UserName = "root";
        $Password = "";
        try 
        {
            $Connection = new PDO($ConnectionString, $UserName, $Password);
            $Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            return  $Connection;

        } 
        catch (PDOException $e) 
        {
            return null;
        }
    }

?>