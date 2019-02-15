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
        $cvstat = $_POST['cvstat'];
        $phonenumber = $_POST['phonenumber'];
        
        $profilepic =  $_POST['profilepic'];
        if(!isset($_POST['handwasher_id'])) {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
        } else {
            $handwasher_id = $_POST['handwasher_id'];
        }
        $path = "handwasher_image/".$fname."_".$lname.".jpeg";
        $finalPath = "http://192.168.254.117/laundress/".$path;

       /*  $originalImgName= $_FILES['profilepic']['name'];
        $tempName= $_FILES['profilepic']['tmp_name'];
        $folder="image_client";
        $url = "http://192.168.254.117/laundress/".$folder."/".$originalImgName; */

        require_once ("db_connect.php");
        $db = DB::transact_db( "UPDATE laundry_handwasher SET 
            handwasher_FName = ?, handwasher_MidName = ?, handwasher_LName = ?, handwasher_Address = ?, handwasher_BDate = ?, handwasher_Gender = ?, handwasher_CivilStatus = ?, handwasher_Contact = ?, handwasher_Photo = ? WHERE handwasher_ID = ?",
            array($fname, $midname, $lname, $addr, $bdate, $gender, $cvstat, $phonenumber, $finalPath, $handwasher_id),
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