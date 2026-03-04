CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100),
email VARCHAR(100),
password VARCHAR(255),
role ENUM('admin','user'),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tasks (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT,
title VARCHAR(255),
description TEXT,
deadline DATE,
status ENUM('Pending','Completed'),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);