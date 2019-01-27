<?php

   /*  if($_SERVER['REQUEST_METHOD'] == 'POST')
    { */
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
        $last_id = 0;
        
        require_once ("db_connect.php");
            
            $db = DB::transact_db( "INSERT INTO laundry_handwasher(handwasher_FName, handwasher_MidName, handwasher_LName, handwasher_Address, handwasher_BDate, handwasher_Gender, handwasher_CivilStatus, handwasher_Contact, handwasher_Username, handwasher_Password)
                 values
                 (? ,? ,? ,? ,? ,? ,? ,? ,?, ?)",
                 array($fname, $midname, $lname, $addr, $bdate, $gender, $cvlstat, $phonenumber, $username, md5($password)),
                 "INSERT"
            );

            $db2 = DB::transact_db("SELECT LAST_INSERT_ID(handwasher_ID) as last_handwasher_id from laundry_handwasher",
				   array(),
				   "SELECT"
            );

            if($db2 > 0)
            {
                foreach($db2 as $dbs){
                    $last_id = $dbs['last_handwasher_id'];
                }
            }

            $db3 = DB::transact_db( "INSERT INTO laundry_service_provider(handwasher_ID)
                 values
                 (?)",
                 array($last_id),
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
       
       
   
    /* } */

?>