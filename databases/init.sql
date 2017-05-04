DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS images;

CREATE TABLE users (
    id SERIAL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE images (
    id SERIAL,
    hash VARCHAR(255) NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);