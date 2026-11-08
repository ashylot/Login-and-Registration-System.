-- Run this in phpMyAdmin (SQL tab) or the MySQL console
CREATE DATABASE IF NOT EXISTS db_login;
USE db_login;

CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    fullname   VARCHAR(100) NOT NULL,
    username   VARCHAR(50)  NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,          -- stores the HASH, never the plain password
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);