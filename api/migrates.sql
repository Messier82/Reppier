DROP TABLE users;
CREATE TABLE users(
  id int NOT NULL AUTO_INCREMENT,
  email varchar(30) NOT NULL,
  password varchar(255) NOT NULL,
  first_name varchar(15) NOT NULL,
  last_name varchar(20) NOT NULL,
  phone_number varchar(15) NOT NULL,
  PRIMARY KEY(id)
) ENGINE = INNODB;

DROP TABLE sessions;
CREATE TABLE sessions(
	id varchar(20) NOT NULL,
	user_id int NOT NULL,
	ip_adress varchar(15) NOT NULL,
	start_time datetime NOT NULL,
	last_activity datetime NOT NULL
) ENGINE = INNODB;