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

        
        $servicetype = json_decode($_POST['servicetype'], true);
        $serviceprice = json_decode($_POST['pricesve'], true);
        $measure = json_decode($_POST['measure'], true);
        require_once ("db_connect.php");
        foreach($servicetype as $servicetypes){
            foreach($serviceprice as $serviceprices){
                foreach($measure as $measures) {
                    $db = DB::transact_db( "INSERT INTO service
                    (lsp_ID, service_Type, service_Label, service_Price)
                    values
                    (? , ?, ?, ?)",
                    array($lsp_id, $servicetypes['servtype'], $measures['unitmeasure'], $serviceprices['priceserve']),
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
        }
          
          
   
    }

?>