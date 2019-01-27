<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $itemTag = $_POST['itemTag'];
        $itemBrand = $_POST['itemBrand'];
        $itemColor = $_POST['itemColor'];
        $itemDescription = $_POST['itemDescription'];
        $itemNoofPieces = $_POST['itemNoofPieces'];
        $client_id = $_POST['client_id'];
        $category_no = $_POST['categ_id']; 

        require_once ("db_connect.php");
            $db = DB::transact_db( "INSERT INTO client_inventory
            (client_ID, category_No, cinv_ItemTag, cinv_ItemBrand, cinv_ItemColor, cinv_ItemDescription, cinv_NoOfPieces)
            values
            (? ,? ,? ,? ,?, ?, ?)",
            array($client_id, $category_no, $itemTag, $itemBrand, $itemColor, $itemDescription, $itemNoofPieces),
            "INSERT"
            );
            if($db)
            {
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);					
            }
            else 
            {
                $result["success"] = "0";
                $result["message"] = "error";

                echo json_encode($result);
                mysqli_close($conn);				
            }
       
   
    }

?>