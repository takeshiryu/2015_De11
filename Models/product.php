<?php

class Product {

    public $product_id;
    public $product_name;
    public $price;
    public $sale_rate;
    public $image_link;
    public $product_info;
    public $url_name;

    public function __construct($product_id, $product_name, $price, $sale_rate, $image_link, $product_info, $url_name) {
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->price = $price;
        $this->sale_rate = $sale_rate;
        $this->image_link = $image_link;
        $this->product_info = $product_info;
        $this->url_name = $url_name;
    }

}
