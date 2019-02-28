<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $fname = $_POST['fname'];
        $midname = $_POST['midname'];
        $lname = $_POST['lname'];
        $addr = $_POST['addr'];
        //$bdate = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['bdate'])));
        $bdate =  $_POST['bdate'];
       
        $gender = $_POST['gender'];
        $phonenumber = $_POST['phonenumber'];
        if(!isset($_POST['client_id'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $client_id = $_POST['client_id'];
        }
        $profilepic =  $_POST['profilepic'];

        $path = "image_client/".$lname.".jpeg";
        $finalPath = "http://192.168.254.117/laundress/".$path;

       /*  $originalImgName= $_FILES['profilepic']['name'];
        $tempName= $_FILES['profilepic']['tmp_name'];
        $folder="image_client";
        $url = "http://192.168.254.117/laundress/".$folder."/".$originalImgName; */

        require_once ("db_connect.php");
        $db = DB::transact_db( "UPDATE laundry_client SET 
            client_FName = ?, client_MidName = ?, client_LName = ?, client_Address = ?, client_BDate = ?, client_Gender = ?, client_Contact = ?, client_Photo = ? WHERE client_ID = ?",
            array($fname, $midname, $lname, $addr, $bdate, $gender, $phonenumber, $finalPath, $client_id),
            "UPDATE"
            );
        if (file_put_contents( $path, base64_decode($profilepic))) {
            
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

?>