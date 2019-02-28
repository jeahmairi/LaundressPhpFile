<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $client_ID = $_POST['client_ID'];
        $handwasher_lspid = $_POST['handwasher_lspid'];
        $trans_No = $_POST['trans_No'];
        $comments = $_POST['comments'];
        $date = date('Y-m-d');
        require_once ("db_connect.php");
            
           
            
            $db = DB::transact_db( "INSERT INTO rating
            (lsp_ID, client_ID, trans_No, dispute_message, dispute_date)
                 values
                 (? ,?, ?, ? ,?)",
                 array($handwasher_lspid, $client_ID, $trans_No, $comments, $date),
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