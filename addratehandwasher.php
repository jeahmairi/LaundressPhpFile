<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $client_ID = $_POST['client_ID'];
        $handwasher_lspid = $_POST['handwasher_lspid'];
        $trans_No = $_POST['trans_No'];
        $accommodation = $_POST['accommodation'];
        $qualityofservice = $_POST['qualityofservice'];
        $ontime = $_POST['ontime'];
        $overall = $_POST['overall'];
        $comments = $_POST['comments'];
        $date = date('Y-m-d');
        require_once ("db_connect.php");
            

            
            $db = DB::transact_db( "INSERT INTO rating_handwasher
            (client_ID, lsp_ID, trans_No, rating_Accommodation, rating_QualityService, rating_Ontime, rating_Overall, rating_Comment, rating_Date)
                 values
                 (? ,?, ?, ? ,?, ?, ?, ?, ?)",
                 array($client_ID, $handwasher_lspid, $trans_No, $accommodation, $qualityofservice, $ontime, $overall, $comments, $date),
                 "INSERT"
            );
            $db2 = DB::transact_db("SELECT LAST_INSERT_ID(rating_No) as last_rating_No from rating_handwasher",
                array(),
                "SELECT"
            );

            if($db2 > 0)
            {
                foreach($db2 as $dbs){
                    $last_rating_No = $dbs['last_rating_No'];
                }
            }
            $db3 = DB::transact_db( "update notification set rating_Nohw = ? where trans_No = ?",
                    array($last_rating_No, $trans_No),
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