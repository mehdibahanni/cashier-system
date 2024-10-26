CREATE DATABASE cashier_system;

USE cashier_system;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(250) NOT NULL,
    account_status ENUM('open', 'closed') DEFAULT 'open'
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    order_item_id INT,
    product_name VARCHAR(255)
    quantity INT,
    total_price DECIMAL(10, 2),
    order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(id),
    FOREIGN KEY (order_item_id) REFERENCES products(id)
);
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,       
    name VARCHAR(255) NOT NULL,              
    description TEXT,                        
    price DECIMAL(10, 2) NOT NULL,           
    quantity INT NOT NULL DEFAULT 0,         
    image VARCHAR(255),                      
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

-- CREATE TABLE order_items (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     order_id INT NOT NULL,
--     item_name VARCHAR(255) NOT NULL,
--     item_price DECIMAL(10, 2) NOT NULL,
--     quantity INT NOT NULL,
--     describtion VARCHAR(255) NOT NULL,
--     image VARCHAR(255) NOT NULL,
--     FOREIGN KEY (order_id) REFERENCES orders(id)
-- );
