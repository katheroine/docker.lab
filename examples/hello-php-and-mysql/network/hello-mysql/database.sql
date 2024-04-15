CREATE DATABASE hello;

CREATE USER 'hello' IDENTIFIED BY 'hello';
GRANT ALL ON hello.* TO 'hello'@'%';

USE hello;
CREATE TABLE fruits (
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(255),
    colour varchar(255)
);
INSERT INTO fruits
    (name, colour)
VALUES
    ('orange', 'orange'),
    ('apple', 'red'),
    ('pear', 'yellow');
