<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(!isset($_POST['lsp_id'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
         } else {
             $lsp_id = $_POST['lsp_id'];
         }
         if(!isset($_POST['servetype'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
         } else {
             $servetype = $_POST['servetype'];
         }
        require_once ("db_connect.php");
        $db = DB::transact_db( "INSERT INTO service
        (lsp_ID, service_Type)
        values
        (? , ?)",
        array($lsp_id, $servetype),
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