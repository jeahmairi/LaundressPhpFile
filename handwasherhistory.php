<?php
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD']=='POST') 
{
    if(!isset($_POST['lspid'])) {
       $result['success'] = "0";
       $result['message'] = "error";
       echo json_encode($result);
       exit;
    } else {
        $lspid = $_POST['lspid'];
    }
	$lspid;
    require_once ("db_connect.php");
    $result = array();
    $result['history'] = array();
        $db = DB::transact_db("SELECT * FROM laundry_transaction WHERE lsp_ID = ? AND (trans_Status = 'Finished' OR trans_Status = 'Claimed' OR trans_Status = 'Cancelled')",
								array($lspid ),
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
				if(count($db2) > 0)
				{
					foreach($db2 as $dbs2)
					{
						$index['name'] = $dbs2['name'];
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