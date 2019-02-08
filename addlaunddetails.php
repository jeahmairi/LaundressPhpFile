<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(!isset($_POST['client_id'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
         } else {
             $client_id = $_POST['client_id'];
         }
        $cinv_id = json_decode($_POST['cinv_id'], true);
        $noofpieces = json_decode($_POST['noofpiecess'], true);
        require_once ("db_connect.php");
$date = date('Y-m-d');
        foreach($cinv_id as $cinv_ids){
            //array($serviceoffer['serviceoffered']);
                foreach($noofpieces as $noofpiecess) {
                    $db = DB::transact_db( "INSERT INTO laundry_details
                    (cinv_No, client_ID, detail_Count, date)
                    values
                    (?, ?, ?, ?)",
                    array($cinv_ids['cinvid'], $client_id, $noofpiecess['noofpieces'], $date),
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

?>