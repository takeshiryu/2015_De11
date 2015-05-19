<?php

class Category {

    public $category_name;
    public $category_id;

    public function __construct($category_id, $category_name) {
        $this->category_id = $category_id;
        $this->category_name = $category_name;
    }

}
