<?php

//Author: 		Takeshi Ryu
//Last update:	19/05/2015

require_once './Controllers/controller.php';

class Bill {

    private $bill_id;
    private $bill_time;
    private $product_list;  // A 2 dimensions dynamic array 
    // Ex: $product_list = array(
    //							array($product_id_1, $quantity_1)
    //							array($product_id_2, $quantity_2)
    //							...)
    private $username;
    private $total;   // Auto calculate so don't input it when you new a Bill

    function __construct($bill_id, $bill_time, $product_list, $username) {
        $this->bill_id = $bill_id;
        $this->bill_time = $bill_time;
        $this->product_list = $product_list;
        $this->username = $username;
        $this->_total();
    }

    function __destruct() {
        
    }

    public function billID() {
        return $this->bill_id;
    }

    public function _billID($id) {
        $this->bill_id = $id;
    }

    public function billTime() {
        return $this->bill_time;
    }

    public function _billTime($time) {
        $this->bill_time = $time;
    }

    public function productList() {
        return $this->product_list;
    }

    public function _productList($list) {
        $this->product_list = $list;
        $this->_total();
    }

    public function username() {
        return $this->username;
    }

    public function _username($user) {
        $this->username = $user;
    }

    public function total() {
        return $this->total;
    }

    function _total() {
        $tmp = 0;
        global $controller;
        foreach ($this->product_list as $product) {
            $product_id = $product[0];
            $quantity = $product [1];
            $tmp += $quantity * $controller->getPriceByProductID($product_id);
        }
        $this->total = $tmp;
    }

    public function saveBill() {
        global $controller;
        $controller->insertBill($this->bill_id, $this->bill_time, $this->username, $this->total);
        $this->saveProductListInBill();
    }

    function saveProductListInBill() {
        global $controller;
        foreach ($this->product_list as $product) {
            $product_id = $product[0];
            $quantity = $product [1];
            $controller->insertProductByBill($this->bill_id, $product_id, $quantity);
        }
    }

    public function removeBill() {
        global $controller;
        $user = $controller->getUserByName($username);
        if (is_null(user)) {
            $controller->deleteBillByID($this->bill_id); // Phuong's function, not my false if it's doesn't work
        } else {
            return false;
        }
        return true;
    }
}
