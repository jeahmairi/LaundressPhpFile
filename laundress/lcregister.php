<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $fname = $_POST['fname'];
        $midname = $_POST['midname'];
        $lname = $_POST['lname'];
        $addr = $_POST['addr'];
        $bdate = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['bdate'])));
        $bdate =  $_POST['bdate'];
        $gender = $_POST['gender'];
        $phonenumber = $_POST['phonenumber'];
        $email = $_POST['email'];
        $password = $_POST['password'];


        require_once ("db_connect.php");
            $db = DB::transact_db( "INSERT INTO laundryclient
            (client_fname, client_midname, client_lname, client_address, client_bdate, client_gender, client_contact, client_email, client_password)
            values
            (? ,? ,? ,? ,? ,? ,? ,? ,?)",
            array($fname, $midname, $lname, $addr, $bdate, $gender, $phonenumber, $email, md5($password)),
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