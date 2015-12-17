DROP TABLE IF EXISTS users;
CREATE TABLE users(
    id int NOT NULL AUTO_INCREMENT,
    email varchar(30) NOT NULL,
    password varchar(255) NOT NULL,
    first_name varchar(15) NOT NULL,
    last_name varchar(20) NOT NULL,
    phone_number varchar(15) NOT NULL,
    PRIMARY KEY(id)
) ENGINE = INNODB;

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions(
    id varchar(32) NOT NULL PRIMARY KEY,
    user_id int NOT NULL,
    ip_address varchar(15) NOT NULL,
    start_time datetime NOT NULL,
    last_activity datetime NOT NULL,
    remember boolean NOT NULL,
    FOREIGN KEY user_id REFERENCES ON users.id = user_id ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = INNODB;

DROP TABLE IF EXISTS supported_manufacturers;
CREATE TABLE supported_manufacturers(
    id int NOT NULL AUTO_INCREMENT,
    name varchar(30) NOT NULL
);

DROP TABLE IF EXISTS supported_models;
CREATE TABLE supported_models(
    id int NOT NULL AUTO_INCREMENT,
    manufacturer_id int NOT NULL,
    name varchar(30) NOT NULL,
    code varchar(20) NOT NULL,
    FOREIGN KEY manufacturer_id REFERENCES ON supported_manufacturers.id = manufacturer_id ON UPDATE CASCADE ON DELETE CASCADE
);