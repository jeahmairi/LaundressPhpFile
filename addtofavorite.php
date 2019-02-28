<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
            $client_id = $_POST['client_id'];
            $lsp_id = $_POST['lsp_id'];

        require_once ("db_connect.php");
            $db2 = DB::transact_db("SELECT * from favorites where client_id = ? and lsp_id = ?",
            array($client_id, $lsp_id),
            "SELECT");
            if(count($db2) > 0) {
                $result["success"] = "0";
                $result["message"] = "error";

                echo json_encode($result);
                mysqli_close($conn);		
            }else{
                $db = DB::transact_db( "INSERT INTO favorites
                (lsp_id, client_id)
                values
                (? ,?)",
                array($lsp_id, $client_id),
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
            
       
   
    }

?>