<?php

require_once './includes/Config.php';

function CovertVn($str) {
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    $str = preg_replace("/( )/", '-', $str);
    return $str;
}

class Controller {

    //-------------------------Phuong-------------------------------------------
    function getProductsByCategoryName($category_name) {
        global $conn;
        $stmt = $conn->prepare("CALL getProductsByCategory(:cat_name)");
        $stmt->execute(array(':cat_name' => $category_name));
        $res = array();
        while ($row = $stmt->fetch()) {
            $product = new Product($row['product_id'], $row['product_name'], $row['price'], $row['sale_rate'], $row['image_link'], $row['product_info'], $row['url_name']);
            array_push($res, $product);
        }
        return $res;
    }

    function newCategory($category_name) {
        global $conn;
        try {
            $stmt = $conn->prepare("CALL newCategory(:cat_name)");
            $stmt->execute(array(':cat_name' => $category_name));
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    function getUserByName($username) {
        global $conn;
        $stmt = $conn->prepare('SELECT * ' . ' FROM ' . TABLE_USER . ' WHERE username=:username');
        $stmt->execute(array(':username' => $username));
        $row = $stmt->fetch();
        if ($row == null) {
            return null;
        } else {
            return new User($row['username'], $row['password'], $row['role'], $row['email'], $row['phonenumber'], $row['address'], $row['thumnail_link']);
        }
    }

    function deleteBillById($bill_id) {
        global $conn;
        try {
            $stmt = $conn->prepare("CALL deleteBill(:billId)");
            $stmt->execute(array(':billId' => $bill_id));
            return true;
        } catch (Exception $ex) {
            echo $ex;
            return false;
        }
    }

    function deleteCategoryByNameCate($category_name) {
        global $conn;
        try {
            $stmt = $conn->prepare("CALL deleteCategoryByName(:cat_name)");
            $stmt->execute(array(':cat_name' => $category_name));
            return true;
        } catch (Exception $ex) {
            echo $ex;
            return false;
        }
    }

    function deleteProductById($product_id) {
        global $conn;
        try {
            $stmt = $conn->prepare("CALL deleteProduct(:productId)");
            $stmt->execute(array(':productId' => $product_id));
            return true;
        } catch (Exception $ex) {
            echo $ex;
            return false;
        }
    }

    function deleteUserByName($user_name) {
        global $conn;
        try {
            $stmt = $conn->prepare("CALL deleteUser(:u_name)");
            $stmt->execute(array(':u_name' => $user_name));
            return true;
        } catch (Exception $ex) {
            echo $ex;
            return false;
        }
    }

    function getAllBills() {
        global $conn;
        $stmt = $conn->prepare("CALL getAllBill()");
        $stmt->execute();
        $res = array();
        while ($row = $stmt->fetch()) {
            $bill = new Bill($row['bill_id'], $row['bill_time'], $row['username'], $row['Total']);
            array_push($res, $bill);
        }
        return $res;
    }

    function getAllBillsOfUser($user_name) {
        global $conn;
        $stmt = $conn->prepare("CALL getAllBillOf(:u_name)");
        $stmt->execute(array(':u_name' => $user_name));
        $res = array();
        while ($row = $stmt->fetch()) {
            $bill = new Bill($row['bill_id'], $row['bill_time'], $row['username'], $row['Total']);
            array_push($res, $bill);
        }
        return $res;
    }

    function getAllCategory() {
        global $conn;
        $stmt = $conn->prepare("CALL getAllCategories()");
        $stmt->execute();
        $res = array();
        while ($row = $stmt->fetch()) {
            $category = new Category($row['category_id'], $row['category_name']);
            array_push($res, $category);
        }
        return $res;
    }

    function getAllProducts() {
        global $conn;
        $stmt = $conn->prepare("CALL getAllProduct()");
        $stmt->execute();
        $res = array();
        while ($row = $stmt->fetch()) {
            $product = new Product($row['product_id'], $row['product_name'], $row['price'], $row['sale_rate'], $row['image_link'], $row['product_info'], $row['url_name']);
            array_push($res, $product);
        }
        return $res;
    }

    function getAllUsers() {
        global $conn;
        $stmt = $conn->prepare("CALL getAllUser()");
        $stmt->execute();
        $res = array();
        while ($row = $stmt->fetch()) {
            $user = new User($row['username'], $row['password'], $row['role'], $row['email'], $row['phonenumber'], $row['address'], $row['thumnail_link']);
            array_push($res, $user);
        }
        return $res;
    }

    function createNewCategory($category_name) {
        global $conn;
        $stmt = $conn->prepare("CALL newCategory(:cat_name)");
        try {
            $stmt->execute(array(':cat_name' => $category_name));
            $res = array();
            while ($row = $stmt->fetch()) {
                $category = new Category($row['category_id'], $row['category_name']);
                array_push($res, $category);
            }
            return $res;
        } catch (Exception $ex) {
            var_dump($ex);
        }
        return false;
    }

    function createNewProduct($productName, $productPrice, $saleRate, $imageLink, $productInfo, $urlName) {
        global $conn;
        $stmt = $conn->prepare("CALL newProduct(:p_name, :p_price, :p_sale, :p_thumb, :p_info, :p_url)");
        try {
            $stmt->execute(array(':p_name' => $productName, ':p_price' => $productPrice, ':p_sale' => $saleRate, ':p_thumb' => $imageLink, ':p_info' => $productInfo, ':p_url' => $urlName));
        } catch (Exception $ex) {
            echo $ex;
            return false;
        }
        return true;
    }

    function updateProducts($productId, $productName, $productPrice, $saleRate, $imageLink, $productInfo) {
        global $conn;
        try {
            $stmt = $conn->prepare("CALL updateProduct(:p_id, :p_name, :p_price, :p_sale, :p_thumb, :p_info, :p_url)");
            $stmt->execute(array(':p_id' => $productId, ':p_name' => $productName, ':p_price' => $productPrice, ':p_sale' => $saleRate, ':p_thumb' => $imageLink, ':p_info' => $productInfo, ':p_url' => CovertVn($productName)));
        } catch (Exception $ex) {
            echo $ex;
            return false;
        }
        return true;
    }

    function updateUsers($userName, $userPassword, $userRole, $userEmail, $userPhoneNumber, $userAddress, $userThumb) {
        global $conn;
        try {
            $stmt = $conn->prepare("CALL updateUser(:u_name, :u_passwod, :u_role, :u_email, :u_phoneNum, :u_address, :u_thumb)");
            $stmt->execute(array(':u_name' => $userName, ':u_passwod' => $userPassword, ':u_role' => $userRole, ':u_email' => $userEmail, ':u_phoneNum' => $userPhoneNumber, ':u_address' => $userAddress, ':u_thumb' => $userThumb));
        } catch (Exception $ex) {
            echo $ex;
            return false;
        }
        return true;
    }

    //------------------------#Phuong-------------------------------------------
    //---Ryu's functions---
    public function insertProductByBill($bill_id, $product_id, $quantity) {
        global $conn;
        $data = array('bill_id' => $bill_id, 'product_id' => $product_id, 'quantity' => $quantity);
        $stmt = $conn->prepare('INSERT ' . 'INTO ' . TABLE_BILL_PRODUCT
                . ' (bill_id, product_id, quantity) VALUES (:bill_id, :product_id, :quantity)');
        $stmt->execute($data);
    }

    public function insertBill($bill_id, $bill_time, $username, $total) {
        global $conn;
        $data = array('bill_id' => $bill_id, 'bill_time' => $bill_time, 'username' => $username, 'total' => $total);
        $stmt = $conn->prepare('INSERT ' . 'INTO ' . TABLE_BILL
                . ' (bill_id, bill_time, username, Total) VALUES (:bill_id, :bill_time, :username, :total)');
        $stmt->execute($data);
    }

    //--#Ryu's functions---
}

global $controller;
$controller = new Controller();
