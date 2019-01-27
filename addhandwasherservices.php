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

        $serviceoffered = json_decode($_POST['serviceoffereds'], true);
        foreach($serviceoffered as $serviceoffer){
            //array($serviceoffer['serviceoffered']);
            require_once ("db_connect.php");
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
        
        $extraservices = json_decode($_POST['extraservice'], true);
        foreach($extraservices as $extraservicess){
            //array($serviceoffer['serviceoffered']);
            require_once ("db_connect.php");
            $db = DB::transact_db( "INSERT INTO extra_services
            (lsp_ID, extra_service_name)
            values
            (? , ?)",
            array($lsp_id,$extraservicess['extraservices']),
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

        $servicetype = json_decode($_POST['servicetype'], true);
        $serviceprice = json_decode($_POST['pricesve'], true);
        $measure = json_decode($_POST['measure'], true);

        foreach($servicetype as $servicetypes){
            foreach($measure as $measures) {
                foreach($serviceprice as $serviceprices){
                    require_once ("db_connect.php");
                    $db = DB::transact_db( "INSERT INTO service
                    (lsp_ID, service_Type, service_Label, service_Price)
                    values
                    (? , ?, ?, ?)",
                    array($lsp_id,$servicetypes['servtype'], $measures['unitmeasure'], $serviceprices['priceserve']),
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