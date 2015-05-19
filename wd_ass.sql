-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2015 at 09:49 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wd_ass`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteBill`(in billId int)
begin

delete from bill_products where bill_id = billId;
delete from bill where bill_id = billId;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteCategoryByName`(IN `cat_name` VARCHAR(50))
begin
declare uncat int default 1;
declare incat int default -1;

if cat_name != 'uncategorized' then

select category_id into incat from category where category_name = cat_name;

update category_products
set category_id = uncat
where category_products.product_id in
(
    select * from (
        select product_id from category_products where category_id = incat
    		and product_id not in 
        (
        	select product_id from category_products cp where cp.category_id = uncat
        )
     ) as `view`
);

delete from category_products where category_id = incat;
delete from category where category_id = incat;
end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteProduct`(in productId int)
begin
delete from category_products where category_products.product_id = productID;
delete from product where product.product_id = productID;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteUser`(IN `u_name` VARCHAR(50))
begin

if u_name <> 'anonymous' then

delete from bill where bill.username = u_name;

delete from `user` where `user`.username = u_name;
end if;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllBill`()
begin

select * from bill;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllBillOf`(IN `u_name` VARCHAR(50))
begin
select * from Bill where username = u_name;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllCategories`()
begin

select * from category;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllProduct`()
begin

select * from product;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllUser`()
begin

select * from user;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductsByCategory`(in cat_name varchar(50))
begin

declare cat_id int default -1;

select category_id into cat_id from category  where category.category_name = cat_name;

select * from product where product_id in (select product_id from category_products where category_id = cat_id);

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUser`(IN `u_name` VARCHAR(50))
begin

select * from user where username = u_name;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `newCategory`(in cat_name varchar(50))
begin

insert into category(category_name) values (cat_name);
select * from category where category_name = cat_name;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `newProduct`(IN `p_name` VARCHAR(60), IN `p_price` FLOAT(10,2), IN `p_sale` INT(2), IN `p_thumb` TEXT, IN `p_info` TEXT, IN `p_url` VARCHAR(128))
begin

INSERT INTO product(product_name, price, sale_rate, image_link, product_info, url_name) VALUES (
    							p_name, p_price, p_sale, p_thumb, p_info, p_url);
                                

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateProduct`(IN `p_id` INT, IN `p_name` VARCHAR(60), IN `p_price` FLOAT(10,2), IN `p_sale` INT(2), IN `p_thumb` TEXT, IN `p_info` TEXT, IN `p_url` VARCHAR(128))
begin

declare appendStr text default '';
declare e_id int default -1;

select product_id into e_id from product where url_name = p_url;

select url_name into appendStr from product where url_name like concat(p_url, '%') order by url_name desc limit 1;

if e_id > 0 and e_id != p_id then
	select concat(appendStr, '_') into p_url;
end if;

update product 
set product_name = p_name, price = p_price, sale_rate = p_sale, image_link = p_thumb, product_info = p_info, url_name = p_url
where product_id = p_id;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUser`(in u_name varchar(50),
                            in u_passwod varchar(60),
                            in u_role int(1),
                            in u_email varchar(60),
                            in u_phoneNum varchar(60),
                            in u_address text,
                            in u_thumb varchar(500)
                            )
begin

update `user`
set `password` = u_password, role = u_role, email = u_email, phonenumber = u_phoneNum, address = u_address, thumbnail_link = u_thumb
where username = u_name;

end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE IF NOT EXISTS `bill` (
`bill_id` int(11) NOT NULL,
  `bill_time` bigint(20) NOT NULL DEFAULT '0',
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Total` float(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`bill_id`, `bill_time`, `username`, `Total`) VALUES
(2, 0, 'anonymous', 10000.00),
(3, 0, 'anonymous', 10000.00);

-- --------------------------------------------------------

--
-- Table structure for table `bill_products`
--

CREATE TABLE IF NOT EXISTS `bill_products` (
  `bill_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
`category_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_name`, `category_id`) VALUES
('đây là u tờ ép 8 tếch', 6),
('đây là u tờ ép 8 tếch 1', 7),
('Đây là u tờ ép tám tếch', 8),
('sieu-nhan-dien-quang', 5),
('uncategorized', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_products`
--

CREATE TABLE IF NOT EXISTS `category_products` (
  `product_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category_products`
--

INSERT INTO `category_products` (`product_id`, `category_id`) VALUES
(12, 1),
(13, 1),
(15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
`product_id` int(11) NOT NULL,
  `product_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `price` float(10,2) DEFAULT '0.00',
  `sale_rate` int(2) DEFAULT '0',
  `image_link` text COLLATE utf8_unicode_ci,
  `product_info` text COLLATE utf8_unicode_ci,
  `url_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `time_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `price`, `sale_rate`, `image_link`, `product_info`, `url_name`, `time_insert`) VALUES
(12, 'điện thoại siêu nhơn', 99999.99, 0, NULL, 'Điện thoại giành cho siêu nhân.', 'dien-thoai-sieu-nhon-2', '2015-05-09 10:49:16'),
(13, 'new product name', 0.00, 0, 'www.anime4you.net', 'information', 'dien-thoai-sieu-nhon-2__', '2015-05-09 11:06:47'),
(15, 'new product name', 0.00, 0, 'www.anime4you.net', 'information', 'dien-thoai-sieu-nhon-2_', '2015-05-09 11:10:55');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(1) NOT NULL DEFAULT '0',
  `email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phonenumber` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `thumnail_link` varchar(500) COLLATE utf8_unicode_ci DEFAULT 'http://www.quickmeme.com/img/18/185d0e08b3cec5dc279ce6b8750720a7eaf7c7ce48babea32ef8ecc8a63e120a.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `role`, `email`, `phonenumber`, `address`, `thumnail_link`) VALUES
('anonymous', 'abcdef', 0, NULL, NULL, NULL, 'http://www.quickmeme.com/img/18/185d0e08b3cec5dc279ce6b8750720a7eaf7c7ce48babea32ef8ecc8a63e120a.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
 ADD PRIMARY KEY (`bill_id`,`bill_time`,`username`), ADD KEY `username` (`username`);

--
-- Indexes for table `bill_products`
--
ALTER TABLE `bill_products`
 ADD PRIMARY KEY (`bill_id`,`product_id`), ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`category_id`), ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `category_products`
--
ALTER TABLE `category_products`
 ADD PRIMARY KEY (`product_id`,`category_id`), ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
 ADD PRIMARY KEY (`product_id`), ADD UNIQUE KEY `url_name` (`url_name`), ADD UNIQUE KEY `url_name_2` (`url_name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `bill_products`
--
ALTER TABLE `bill_products`
ADD CONSTRAINT `bill_products_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`bill_id`),
ADD CONSTRAINT `bill_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `category_products`
--
ALTER TABLE `category_products`
ADD CONSTRAINT `category_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
ADD CONSTRAINT `category_products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
