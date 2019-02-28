<?php
    require_once ("db_connect.php");
	$shopID;
	$id;
    $result['shopHistory'] = array();
	
	if ($_SERVER['REQUEST_METHOD']=='POST')
	{
		if(!isset($_POST['shop_id'])) 
		{
			$result['success'] = "0";
			$result['message'] = "error";
			echo json_encode($result);
			exit;
		}
		else 
			$id = $_POST['shop_id'];
		
		$db_lspID = DB::transact_db("SELECT lsp_ID FROM laundry_service_provider where shop_ID = ?",
								array($id),
								"SELECT");
		if(count($db_lspID) > 0)
		{
            foreach($db_lspID as $db_lspIDs)
				$shopID = $db_lspIDs['lsp_ID'];
        }
	
        // $db = DB::transact_db("SELECT h.*, t.*, CONCAT(c.client_FName, ' ', c.client_MidName, ' ', c.client_LName) AS name FROM history h, laundry_transaction t, laundry_client c WHERE h.lsp_ID = ? AND h.trans_No = t.trans_No AND h.client_ID = c.client_ID AND t.trans_Status = 'Finished' OR t.trans_Status = 'Canceled' OR t.trans_Status = 'Declined' GROUP By h.client_ID ORDER BY t.trans_DateOfRequest DESC",
								// array($shopID),
								// "SELECT"
                            // );
        $db = DB::transact_db("SELECT * FROM laundry_transaction WHERE lsp_ID = ? AND (trans_Status = 'Finished' OR trans_Status = 'Claimed' OR trans_Status = 'Cancelled')",
								array($shopID),
								"SELECT"
                            );
        if(count($db) > 0) 
		{
            foreach($db as $dbs)
			{
				$index['trans_No'] = $dbs['trans_No'];
				$index['client_ID'] = $dbs['client_ID'];
				$index['date'] = $dbs['trans_DateOfRequest'];
				$index['trans_Status'] = $dbs['trans_Status'];
				
				$db2 = DB::transact_db("SELECT CONCAT(client_FName, ' ', client_MidName, ' ', client_LName) AS name FROM laundry_client WHERE client_ID = ?",
									array($dbs['client_ID']),
									"SELECT"
								);
				if(count($db2) > 0) {
					foreach($db2 as $dbs2){
						$index['name'] = $dbs2['name'];
					}
				}
				array_push($result['shopHistory'], $index); 
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
	}

?>