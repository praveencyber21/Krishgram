-- 20250602_create_user_table.sql

CREATE TABLE IF NOT EXISTS users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    user_name VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    name VARCHAR(100),
    bio TEXT,
    profile_picture_url VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

