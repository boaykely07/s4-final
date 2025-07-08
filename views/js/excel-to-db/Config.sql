mkdir excel-to-db && cd excel-to-db
npm init -y
npm install exceljs mysql2

CREATE DATABASE test_db;
USE test_db;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(50),
  email VARCHAR(100)
);
