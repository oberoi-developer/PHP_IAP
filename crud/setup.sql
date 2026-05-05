CREATE DATABASE IF NOT EXISTS crud_db;
USE crud_db;

CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  course VARCHAR(80),
  year INT DEFAULT 1,
  gpa DECIMAL(3,2) DEFAULT 0.00,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (full_name, email, course, year, gpa) VALUES
('Alice Uwimana', 'alice@email.com', 'Computer Science', 2, 3.8),
('Bob Nkurunziza', 'bob@email.com', 'Information Systems', 1, 3.2),
('Chloe Mutesi', 'chloe@email.com', 'Software Engineering', 3, 3.6);
