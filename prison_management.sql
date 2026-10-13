USE prison_management;
CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(50) NOT NULL,
  role ENUM('admin','officer') DEFAULT 'officer'
);
CREATE TABLE prisoners (
  prisoner_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  age INT,
  gender VARCHAR(10),
  crime VARCHAR(255),
  sentence_years INT,
  cell_no VARCHAR(10),
  status VARCHAR(20)
);
CREATE TABLE cells (
  cell_id INT AUTO_INCREMENT PRIMARY KEY,
  block VARCHAR(10),
  capacity INT,
  current_occupancy INT
);