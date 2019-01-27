<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $fname = $_POST['fname'];
        $midname = $_POST['midname'];
        $lname = $_POST['lname'];
        $addr = $_POST['addr'];
        //$bdate = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['bdate'])));
        $bdate =  $_POST['bdate'];
        if(!isset($_POST['client_id'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $client_id = $_POST['client_id'];
        }
        $gender = $_POST['gender'];
        $phonenumber = $_POST['phonenumber'];


        require_once ("db_connect.php");
            $db = DB::transact_db( "UPDATE laundry_client SET 
            client_FName = ?, client_MidName = ?, client_LName = ?, client_Address = ?, client_BDate = ?, client_Gender = ?, client_Contact = ? WHERE client_ID = ?",
            array($fname, $midname, $lname, $addr, $bdate, $gender, $phonenumber, $client_id),
            "UPDATE"
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