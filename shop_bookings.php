<?php
	error_reporting(E_ALL);
	require_once ("db_connect.php");
	$id;
	$name;
	$shopID;
	$book;
	$clientID;
	$extraserves="";
	$transNo;
	$result = array();
	$lspID = array();
    $result['shopBookings'] = array();
	
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
		$db4 = DB::transact_db("SELECT * from extra_services es, laundry_service ls, laundry_transaction lt where lt.lsp_ID = ? and es.extraserv_ID = ls.extraserv_ID and ls.trans_No = lt.trans_No",
            array($shopID),
            "SELECT"
        );
        if(count($db4)>0){
            foreach($db4 as $db4s){
            $extraserves = $extraserves." ".$db4s['extra_service_name']; 
            //$index['shop_ContactNo1'] = $db3s['trans_ExtService']; 
            }
        }
        $db = DB::transact_db("SELECT *, CONCAT(lc.client_FName, ' ', lc.client_MidName, ' ', lc.client_LName) AS name from laundry_transaction lt, laundry_service_provider lsp, laundry_client lc, laundry_service ls, service s, services_offered so, extra_services es where lt.trans_Status ='Accepted' and lt.lsp_ID = ? and lt.lsp_ID = lsp.lsp_ID and lt.client_ID = lc.client_ID and lt.trans_No = ls.trans_No and ls.seroffer_ID = so.seroffer_ID and ls.service_No = s.service_No and ls.extraserv_ID = es.extraserv_ID Group by lt.trans_No",
								array($shopID),
								"SELECT"
                            );
		$transNos = "";
		$transServ = "";
		$transExtra = "";
		$transType = "";
        if(count($db) > 0)
		{
            foreach($db as $dbs)
			{
				$index['shop_id'] = $id;
				$index['lspID'] = $shopID;
				$index['transNo'] = $dbs['trans_No'];
				$index['clientID'] = $dbs['client_ID'];
				$index['clientName'] = $dbs['name'];
				$index['client_Address'] = $dbs['client_Address'];
				$index['client_Contact'] = $dbs['client_Contact'];
				$index['client_Photo'] = $dbs['client_Photo'];
				$index['transService'] = $dbs['service_offered_name'];
				$index['transExtra'] = $extraserves;
				$index['transServType'] = $dbs['service_Type'];
				$index['lsp_ID'] = $dbs['lsp_ID'];
				// $transServ = $dbs['service_offered_name'];
				// $transExtra = $dbs['extra_service_name'];
				// $transType = $dbs['service_Type'];
				// if($index['transNo']==$transNos)
				// {
					// $transServ = $transServ." ".$dbs['service_offered_name'];
					// $transExtra = $transExtra." ".$dbs['extra_service_name'];
					// $transType = $transType." ".$dbs['service_Type'];
				// }
				// else
				// {
					// $index['transService'] = $transServ;
					// $index['transExtra'] = $transExtra;
					// $index['transServType'] = $transType;
					// $transServ = "";
					// $transExtra = "";
					// $transType = "";
				// }
				$index['transWeight'] = $dbs['trans_EstWeight']." kgs";
				$index['transDateTime'] = $dbs['trans_EstDateTime'];
				$index['transStat'] = $dbs['trans_Status'];
				//$transNos = $index['transNo'];
				array_push($result['shopBookings'], $index); 
			}
            $result['success'] = "1";
            $result['message'] = "success"; 
            echo json_encode($result);
        }
       else 
	   {
            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
            exit;
       }
	}
?>