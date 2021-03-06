<?php
    require_once ("db_connect.php");
	$lspID;
	$id;
	$transNo;
	$clientID;
	$ratingComment;
	$ratingDate;
	$ratingScore;
	$last_rating_No;
    $result['shopRate'] = array();
	
	if ($_SERVER['REQUEST_METHOD']=='POST')
	{
		if(!isset($_POST['ratingScore'])) 
		{
			$result['success'] = "0";
			$result['message'] = "error";
			echo json_encode($result);
			exit;
		}
		else 
			$ratingScore = $_POST['ratingScore'];
		
		if(!isset($_POST['ratingComment'])) 
		{
			$result['success'] = "0";
			$result['message'] = "error";
			echo json_encode($result);
			exit;
		}
		else 
			$ratingComment = $_POST['ratingComment'];
		
		$ratingDate = date("Y/m/d");
		
		if(!isset($_POST['clientID'])) 
		{
			$result['success'] = "0";
			$result['message'] = "error";
			echo json_encode($result);
			exit;
		}
		else 
			$clientID = $_POST['clientID'];
		
	    if(!isset($_POST['transNo'])) 
		{
			$result['success'] = "0";
			$result['message'] = "error";
			echo json_encode($result);
			exit;
		}
		else 
			$transNo = $_POST['transNo'];
		
	    if(!isset($_POST['shopID'])) 
		{
			$result['success'] = "0";
			$result['message'] = "error";
			echo json_encode($result);
			exit;
		}
		else 
			$id = $_POST['shopID'];
		
		$db_lspID = DB::transact_db("SELECT lsp_ID FROM laundry_service_provider where shop_ID = ?",
								array($id),
								"SELECT");
		if(count($db_lspID) > 0)
		{
            foreach($db_lspID as $db_lspIDs)
				$lspID = $db_lspIDs['lsp_ID'];
        }
	
        $db = DB::transact_db("INSERT INTO rating (rating_No, client_ID, lsp_ID, trans_No, rating_Score, rating_Comment, rating_Date) VALUES (NULL, ?, ?, ?, ?, ?, ?);",
								array($clientID, $lspID, $transNo, $ratingScore, $ratingComment, $ratingDate),
								"INSERT"
							);
							
		$db2 = DB::transact_db("SELECT LAST_INSERT_ID(rating_No) as last_rating_No from rating",
                array(),
                "SELECT"
            );
			$result["success"] = "1";
			$result["message"] = "success";

			echo json_encode($result);
			mysqli_close($conn);	
            if($db2 > 0)
            {
                foreach($db2 as $dbs){
                    $last_rating_No = $dbs['last_rating_No'];
                }
            }
            $db3 = DB::transact_db( "update notification set rating_No = ? where trans_No = ?",
                    array($last_rating_No, $transNo),
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