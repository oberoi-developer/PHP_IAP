CREATE DATABASE IF NOT EXISTS inventory_db;
USE inventory_db;

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  category VARCHAR(50),
  quantity INT DEFAULT 0,
  price DECIMAL(10,2) DEFAULT 0,
  added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, category, quantity, price) VALUES
('Laptop', 'Electronics', 12, 850000),
('Office Chair', 'Furniture', 8, 45000),
('Notebook A4', 'Stationery', 200, 1500),
('USB Flash Drive', 'Electronics', 3, 8000);
