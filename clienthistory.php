<?php
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD']=='POST') 
{
     if(!isset($_POST['client_id'])) {
        $result['success'] = "0";
       $result['message'] = "error";
        echo json_encode($result);
       exit;
     } else {
         $client_id = $_POST['client_id'];
     }
	//$client_id;
    require_once ("db_connect.php");
    $result = array();
    $result['history'] = array();
    $handwasher_ID = 0;
    $shop_ID = 0;
        $db = DB::transact_db("SELECT * FROM laundry_transaction WHERE client_ID = 1 AND (trans_Status = 'Finished' OR trans_Status = 'Claimed' OR trans_Status = 'Cancelled')",
								array($client_id ),
								"SELECT"
                            );
        if(count($db) > 0) {
            foreach($db as $dbs)
			{
				$index['trans_No'] = $dbs['trans_No'];
				$index['lsp_ID'] = $dbs['lsp_ID'];
				$index['date'] = $dbs['trans_DateOfRequest'];
				$index['trans_Status'] = $dbs['trans_Status'];
				
				$db2 = DB::transact_db("SELECT * FROM laundry_service_provider WHERE lsp_ID = ?",
									array($dbs['lsp_ID']),
									"SELECT"
								);
				if(count($db2) > 0)
				{
					foreach($db2 as $dbs2)
					{
						if($dbs2['shop_ID'] != null)
						{
							$db3 = DB::transact_db("SELECT shop_Name as name FROM laundry_shop WHERE shop_ID = ?",
										array($dbs2['shop_ID']),
										"SELECT"
									);
							if(count($db3) > 0)
							{
								foreach($db3 as $dbs3)
								{
									$index['name'] = $dbs3['name'];
								}
							}
						}
						else
						{
							$db4 = DB::transact_db("SELECT CONCAT(handwasher_FName, ' ', handwasher_MidName, ' ', handwasher_LName) AS name FROM laundry_handwasher WHERE handwasher_ID = ?",
										array($dbs2['handwasher_ID']),
										"SELECT"
									);
							if(count($db4) > 0)
							{
								foreach($db4 as $dbs4)
								{
									$index['name'] = $dbs4['name'];
								}
							}
						}
					}
				}
				
				array_push($result['history'], $index); 
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