<?php
include "DBConn.php";

class CompanyOrder extends DBConn{
    function getOrdersByCompany($company){
        $result = $this->connect()->query('SELECT * FROM orders WHERE company="'.$company.'"');
        $this->disconect();
        return $result;
    }

    function getOrdersByDate($date){
        $result = $this->connect()->query('SELECT * FROM orders WHERE date>"'.$date.'"');
        $this->disconect();
        return $result;
    }
}
?>