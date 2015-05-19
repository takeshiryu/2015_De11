<?php

class User {

    public $username;
    public $password;
    public $role;
    public $email;
    public $phoneNumber;
    public $address;
    public $thumbnailLink;

    public function __construct($username, $password, $role, $email, $phoneNumber, $address, $thumbnailLink) {
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->thumbnailLink = $thumbnailLink;
    }

    public function __destruct() {
        
    }

}
