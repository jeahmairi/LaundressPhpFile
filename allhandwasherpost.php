<?php
error_reporting(E_ALL);

    require_once ("db_connect.php");
    $result = array();
    //$result['allpostclient'] = array();
   $result['allhandwasherpost'] = array();
/*         
        $db2 = DB::transact_db("SELECT TIMESTAMPDIFF(MINUTE,p.handwasher_date,CURRENT_TIMESTAMP)as minute, p.post_handwasher_no, p.handwasher_message, p.handwasher_show_location, p.handwasher_ID, CONCAT(hw.handwasher_FName, ' ', hw.handwasher_MidName, ' ', hw.handwasher_LName) AS name, hw.handwasher_Address as address, hw.handwasher_Contact,hw.handwasher_Photo  FROM handwasher_post p , laundry_handwasher hw 
                                where p.handwasher_ID = hw.handwasher_ID",
                            array(),
                            "SELECT"
                        ); */
        $db3 = DB::transact_db("SELECT * FROM shop_post sp, laundry_shop ls where sp.shop_ID = ls.shop_ID and sp.post_Status='A'",
                    array(),
                    "SELECT"
                );  
        if(count($db3)>0){
            foreach($db3 as $db3s){
            $index['post_no'] = $db3s['post_shop_no'];
            $index['post_message'] = $db3s['post_Message'];
            //$index['post_datetime'] = $db3s['post_Date'];
            $index['post_showAddress'] = "Yes";
            $index['handwasher_Contact'] = $db3s['shop_ContactNo1'];
            $index['handwasher_Photo'] = $db3s['shop_Photo'];
            $index['address'] = $db3s['shop_Address'];
        
            $index['poster_name'] = $db3s['shop_Name'];
            array_push($result['allhandwasherpost'], $index); 
            }
            $result['success'] = "1";
            $result['message'] = "success"; 
            echo json_encode($result);
        }
       else {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
       }

       /* $db2 = DB::transact_db("SELECT * FROM posthandwasher",
                array(),
                "SELECT"
            );
            if(count($db2) > 0) {
                foreach($db2 as $dbs){
          
                $indexs['post_no'] = $dbs['post_no'];
                $indexs['post_message'] = $dbs['post_message'];
                $indexs['post_datetime'] = $dbs['post_datetime'];
                $indexs['post_showAddress'] = $dbs['post_showAddress'];
                array_push($result['allhandwasher'], $indexs); 
            }
                $result['success'] = "1";
                $result['message'] = "success"; 
                echo json_encode($result);
            } 
           else {
                $result['success'] = "0";
                $result['message'] = "error";
                echo json_encode($result);
                exit;
           }
 */
?>