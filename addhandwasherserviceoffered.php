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

        require_once ("db_connect.php");

        $serviceoffered = json_decode($_POST['serviceoff'], true);
        foreach($serviceoffered as $serviceoffer){
            $db = DB::transact_db( "INSERT INTO services_offered
            (lsp_ID, service_offered_name)
            values
            (? , ?)",
            array($lsp_id,$serviceoffer['serviceoffered']),
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
        $prices = json_decode($_POST['prices'], true);
        foreach($prices as $pricess){
            $db =  DB::transact_db("update services_offered set service_offered_price = ? where lsp_ID = ? and service_offered_price is null",
            array($pricess['priceserve'],$lsp_id),
            "UPDATE");
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);							
        }    
        
        $uomeasure = json_decode($_POST['uomeasure'], true);
        foreach($uomeasure as $uomeasures){
            $db =  DB::transact_db("update services_offered set service_offered_uom = ? where lsp_ID = ? and service_offered_uom is null",
            array($uomeasures['unitmeasure'],$lsp_id),
            "UPDATE");
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);							
        }    
   
    }

?>