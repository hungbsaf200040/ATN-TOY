-- Tạo bảng products
CREATE TABLE products (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
prod_name VARCHAR(255) NOT NULL,
price DECIMAL(10, 2) NOT NULL,
category_id INT(11) UNSIGNED,
thumbnail TEXT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (category_id) REFERENCES category(id)
);
-- Tạo bảng orders
CREATE TABLE orders (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
customer_id INT(11) UNSIGNED,
total_amount DECIMAL(10, 2) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (customer_id) REFERENCES customers(id)
);
-- Tạo bảng customers
CREATE TABLE customers (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
cus_name VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
cus_address TEXT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Tạo bảng category
CREATE TABLE category (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
cate_name VARCHAR(255) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
