<?php
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $client_ID = $_POST['client_ID'];
    $handwasher_lspid = $_POST['handwasher_lspid'];
    $trans_No = $_POST['trans_No'];
    $price = $_POST['price'];
    $date = date('Y-m-d');
    require_once ("db_connect.php"); 
    $result = array();

    $db = DB::transact_db( "INSERT INTO receipt
    (trans_No, lsp_ID, client_ID, receipt_AmountToPay, date_Issued)
    values
    (? ,?, ?, ?, ?)",
    array($trans_No, $handwasher_lspid, $client_ID, $price, $date),
    "INSERT");
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