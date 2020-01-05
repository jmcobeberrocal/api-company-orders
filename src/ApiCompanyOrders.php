<?php

include "CompanyOrder.php";

class ApiCompanyOrders{
    function get($mode, $value){
        $companyOrder = new CompanyOrder();
        $companyOrders = array();
        $companyOrders["register"] = array();

        if ($mode=="date") $result = $companyOrder->getOrdersByDate($value);
        if ($mode=="company") $result = $companyOrder->getOrdersByCompany($value);

        if($result->rowCount()){
            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                $register = array(
                    "id_order" => $row["id_order"],
                    "date" => $row["date"],
                    "company" => $row["company"],
                    "qty" => $row["qty"],
                );
                array_push($companyOrders['register'], $register);
            }
            http_response_code(200);
            echo json_encode($companyOrders);
        }else{
            http_response_code(404);
            echo json_encode(array("message" => "Element not found"));
        }
    }
}

$api = new ApiCompanyOrders();

if(isset($_GET['date']) || isset($_GET['company'])){
    if (isset($_GET['date'])) 
        if($_GET['date']!="") {
            //compruebo que se ha introducido un formato de fecha correcto
            if ( preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\z/',$_GET['date'])) $api->get("date",$_GET['date']);     
                else echo json_encode(array("message" => "Incorret Date format, it must be like YYYY-MM-DD"));
        }
        else echo json_encode(array("message" => "Date value is empty."));
        

    if (isset($_GET['company']))
        if ($_GET['company']!=""){
            //si se ha introducido el nombre entre comillas 
            if (strpos($_GET['company'],'"')!==false) $_GET['company'] = str_replace('"','',$_GET['company']);
            $api->get("company", $_GET['company']);
        } 
        else echo json_encode(array("message" => "Company name is empty."));

} else echo json_encode(array("message" => "No filter set."));

?>