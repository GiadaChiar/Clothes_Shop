
/*
Calcolator Site Database Migration
Author: Chiara
Description:
Creates the database structure for user,
items, and AI valutations.
*/



/* USER TABLE */
CREATE TABLE users (
    id BIGINT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) DEFAULT NULL,
    name VARCHAR(100) DEFAULT NULL,
    surname VARCHAR(100) DEFAULT NULL,
    password_hash VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


/*CHAT TABLE*/

CREATE TABLE chats(
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_activity_at TIMESTAMP NULL,
    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



/*ITEM TABLE*/

CREATE TABLE items (

    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    category VARCHAR(100) NOT NULL,
    brand VARCHAR(100) NOT NULL,
    state ENUM('nuovo','buono','usato') NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) 
    REFERENCES users(id)
    ON DELETE CASCADE,
        INDEX idx_user (user_id)
        
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



/*VALUTATION TABLE */

CREATE TABLE valuations (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    item_id BIGINT NOT NULL,
    chat_id BIGINT NOT NULL,

    suggested_price DECIMAL(10,2) NOT NULL,

    range_min DECIMAL(10,2) NOT NULL,
    range_max DECIMAL(10,2) NOT NULL,

    motivation TEXT NOT NULL,
    season  VARCHAR(100) NOT NULL,
    rarity ENUM('alta', 'media','bassa') NOT NULL,
    demand ENUM('alta', 'media','bassa') NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (item_id)
        REFERENCES items(id)
        ON DELETE CASCADE,
        
        FOREIGN KEY (chat_id)
        REFERENCES chats(id)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


/*VALUTATION TIPS*/

CREATE TABLE valuation_tips (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    valuation_id BIGINT NOT NULL,
    tip TEXT NOT NULL,

FOREIGN KEY (valuation_id)
REFERENCES valuations(id)
ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;