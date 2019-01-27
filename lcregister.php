<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $fname = $_POST['fname'];
        $midname = $_POST['midname'];
        $lname = $_POST['lname'];
        $addr = $_POST['addr'];
       // $bdate = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['bdate'])));
        $bdate =  $_POST['bdate'];
        $gender = $_POST['gender'];
        $phonenumber = $_POST['phonenumber'];
        $email = $_POST['email'];
        $password = $_POST['password'];


        require_once ("db_connect.php");
            $db = DB::transact_db( "INSERT INTO laundry_client
            (client_FName, client_MidName, client_LName, client_Address, client_BDate, client_Gender, client_Contact, client_Email, client_Password)
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