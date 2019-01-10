<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $fname = $_POST['fname'];
        $midname = $_POST['midname'];
        $lname = $_POST['lname'];
        $addr = $_POST['addr'];
        $bdate = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['bdate'])));
        $gender = $_POST['gender'];
        $cvlstat = $_POST['cvlstat'];
        $phonenumber = $_POST['phonenumber'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $lsp_id = '1';
        require_once ("db_connect.php");
       
           /*  $sql = "INSERT INTO laundryhandwasher
            (handwasher_fname, handwasher_midname, handwasher_lname, handwasher_address, handwasher_bdate, handwasher_gender, handwasher_civilstatus, handwasher_contact, handwasher_username, handwasher_password)
            VALUES ('$fname', '$midname', '$lname', '$addr', '$bdate', '$gender', '$cvlstat', '$phonenumber', '$username', '$password')";
            
            if(mysqli_query($conn, $sql)){
                $result["success"] = "1";
                $result["message"] = "success";

                echo json_encode($result);
                mysqli_close($conn);
            } else {
                $result["success"] = "0";
                $result["message"] = "error";

                echo json_encode($result);
                mysqli_close($conn);
            } */
            
            $db = DB::transact_db( "INSERT INTO laundryhandwasher(lsp_id, handwasher_fname, handwasher_midname, handwasher_lname, handwasher_address, handwasher_bdate, handwasher_gender, handwasher_civilstatus, handwasher_contact, handwasher_username, handwasher_password)
                 values
                 (? ,? ,? ,? ,? ,? ,? ,? ,? ,?, ?)",
                 array($lsp_id, $fname, $midname, $lname, $addr, $bdate, $gender, $cvlstat, $phonenumber, $username, md5($password)),
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