DROP TABLE users;
CREATE TABLE users(
  id int NOT NULL AUTO_INCREMENT,
  email varchar(30) NOT NULL,
  password varchar(255),
  PRIMARY KEY(id)
) ENGINE = INNODB;
