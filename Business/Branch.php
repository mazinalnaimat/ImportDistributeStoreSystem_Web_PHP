<?php
declare(strict_types=1);
require_once __DIR__ . "/../DataAccess/Branch_DataAccess.php";


    function GetAllBranches_Business(string $Order = "ASC", int $Limit = -1, int $Offset = -1)
    {
        return  GetAllBranches_DataAccess($Order, $Limit, $Offset);
    }

    function SearchBranchesByName_Business(string $BranchName,  string $Order = "ASC",  int $Limit = -1,    int $Offset = -1)
    {
        return SearchBranchesByName_DataAccess($BranchName, $Order, $Limit, $Offset);
    }

    function SearchBranchesByColumnAndValue_Business(string $SearchText,  string $ColName,string $Order = "ASC",  int $Limit = -1,    int $Offset = -1)
    {
        return SearchBranchesByColumnAndValue_DataAccess($SearchText, $ColName,$Order, $Limit, $Offset);
    }


    function GetBranchByBranchId_Business(int $BranchId)
    {
        return GetBranchByBranchId_DataAccess($BranchId);
    }

    function AddNewBranch_Business($BranchInfo)
    {
        return AddNewBranch_DataAccess($BranchInfo);
    }

    function UpdateBranchByBranchId_Business(int $BranchId, $UpdatedBranchInfo)
    {
        return UpdateBranchByBranchId_DataAccess($BranchId, $UpdatedBranchInfo);
    }
    function DeleteBranchByBranchId_Business(int $BranchId)
    {
        return DeleteBranchByBranchId_DataAccess($BranchId);
    }

?>