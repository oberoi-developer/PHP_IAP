CREATE DATABASE banking;

USE banking;

CREATE TABLE accounts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  account_number VARCHAR(20),
  holder_name VARCHAR(100),
  balance DECIMAL(12,2) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  account_id INT,
  type ENUM('deposit','withdraw'),
  amount DECIMAL(12,2),
  note TEXT,
  done_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);