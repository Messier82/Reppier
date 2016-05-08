DROP TABLE IF EXISTS users;
CREATE TABLE users(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email varchar(30) NOT NULL,
    password varchar(255) NOT NULL,
    first_name varchar(15) NOT NULL,
    last_name varchar(20) NOT NULL,
    phone_number varchar(15) NOT NULL
) ENGINE = INNODB;

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions(
    id varchar(32) NOT NULL PRIMARY KEY,
    user_id int NOT NULL,
    ip_address varchar(15) NOT NULL,
    start_time datetime NOT NULL,
    last_activity datetime NOT NULL,
    remember boolean NOT NULL
) ENGINE = INNODB;

DROP TABLE IF EXISTS supported_manufacturers;
CREATE TABLE supported_manufacturers(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(30) NOT NULL
);

DROP TABLE IF EXISTS supported_models;
CREATE TABLE supported_models(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    manufacturer_id int NOT NULL,
    name varchar(30) NOT NULL,
    code varchar(20) NOT NULL
);

DROP TABLE IF EXISTS groups;
CREATE TABLE groups(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(15) NOT NULL,
    flags varchar(255),
    immunity_flags varchar(255),
    level int NOT NULL
);

DROP TABLE IF EXISTS user_access_overrides;
CREATE TABLE user_access_overrides(
    user_id int NOT NULL PRIMARY KEY,
    flags varchar(255),
    immunity_flags varchar(255),
    level int NOT NULL
);

DROP TABLE IF EXISTS admin_sessions;
CREATE TABLE admin_sessions(
    id varchar(32) NOT NULL PRIMARY KEY,
    user_id int NOT NULL,
    ip_address varchar(15) NOT NULL,
    start_time datetime NOT NULL,
    last_activity datetime NOT NULL
);