-- Create table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    age INT
);

-- Insert data
INSERT INTO users (name, email, age) VALUES 
('Alice', 'alice@email.com', 25),
('Bob', 'bob@email.com', 30);

-- Select data
SELECT * FROM users;
SELECT name, email FROM users WHERE age > 25;

-- Update data
UPDATE users SET age = 31 WHERE name = 'Bob';

-- Delete data
DELETE FROM users WHERE id = 1;