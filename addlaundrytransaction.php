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
         if(!isset($_POST['client_id'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
         } else {
             $client_id = $_POST['client_id'];
         }
         if(!isset($_POST['service'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
         } else {
             $service = $_POST['service'];
         }
         if(!isset($_POST['serviceoff'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
         } else {
             $serviceoff = $_POST['serviceoff'];
         }
         if(!isset($_POST['estdatetime'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
         } else {
             $estdatetime= $_POST['estdatetime'];
         }
        
          if(!isset($_POST['weight'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
         } else {
             $weight = $_POST['weight'];
         }

        $date = date('Y-m-d');
        $last_trans_No = 0;
        $transstat = '';
        require_once ("db_connect.php");
        $extraservice = json_decode($_POST['extraserve'], true);

        $db = DB::transact_db( "INSERT INTO laundry_transaction
        (client_ID, lsp_ID, trans_EstWeight, trans_EstDateTime, trans_DateOfRequest, trans_Status)
        values
        (?, ?, ?, ?, ?, ?)",
        array($client_id, $lsp_id, $weight, $estdatetime, $date,'Pending'),
        "INSERT"
        );

        $db2 = DB::transact_db("SELECT LAST_INSERT_ID(trans_No) as last_trans_No, trans_Status from laundry_transaction",
        array(),
        "SELECT"
        );

        if($db2 > 0)
        {
            foreach($db2 as $dbs){
                $last_trans_No = $dbs['last_trans_No'];
                $transstat = $dbs['trans_Status'];
            }
        }
        $db3 = DB::transact_db( "update laundry_details set trans_No = ?, lsp_ID = ? where trans_No IS NULL",
                 array($last_trans_No, $lsp_id),
                 "UPDATE"
            );
        $db4 = DB::transact_db( "INSERT INTO notification
            (client_ID, lsp_ID, trans_No, notification_Message)
            values
            (?, ?, ?, ?)",
            array($client_id, $lsp_id, $last_trans_No, $transstat),
            "INSERT"
            );

        foreach($extraservice as $extraservices){
            $db5 = DB::transact_db( "INSERT INTO laundry_service
                (seroffer_ID, service_No, extraserv_ID, trans_No)
                values
                (?, ?, ?, ?)",
                array($serviceoff, $service, $extraservices['xtraserve'], $last_trans_No),
                "INSERT"
                );
        }
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