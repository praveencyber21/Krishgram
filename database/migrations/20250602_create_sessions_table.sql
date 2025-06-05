-- 20250602_create_sessions_table.sql

CREATE TABLE sessions (
    session_id   INT AUTO_INCREMENT PRIMARY KEY,
    user_id      INT NOT NULL,
    token        VARCHAR(64) NOT NULL UNIQUE,
    ip           VARCHAR(45) NOT NULL,
    user_agent   VARCHAR(255) NOT NULL,
    active       BOOLEAN NOT NULL DEFAULT TRUE,
    login_time    DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);