<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
            $reason = $_POST['reason'];
            $trans_No = $_POST['trans_No'];
            $date = date('Y-m-d');

        require_once ("db_connect.php");
            $db = DB::transact_db( "INSERT INTO cancel_booking
            (trans_No, cancel_reason, cancel_date)
            values
            (? ,?, ?)",
            array($trans_No, $reason, $date),
            "INSERT"
            );
        $update = "Cancelled";
        $update2 = "Cancelled";
        DB::transact_db("update laundry_transaction set trans_Status = ? where trans_No = ?",
            array($update, $trans_No),
            "UPDATE");
        DB::transact_db("update notification set notification_Message = ? where trans_No = ?",
            array($update2, $trans_No),
            "UPDATE");   
        DB::transact_db("update laundry_details set detail_status = ? where trans_No = ?",
            array($update, $trans_No),
            "UPDATE");  
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