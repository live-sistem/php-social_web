Comand MySQL


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(255) NOT NULL,
    name VARCHAR(255),
    surname VARCHAR(255),
    password VARCHAR(255) NOT NULL
);

id — уникальный идентификатор, который автоматически увеличивается при добавлении новых записей (AUTO_INCREMENT).
login и password — обязательные поля, не могут быть пустыми, так как для них указано NOT NULL.
name и surname — необязательные поля, для которых не установлено ограничение NOT NULL, поэтому они могут быть пустыми.


CREATE TABLE messages (
    msg_id INT AUTO_INCREMENT PRIMARY KEY,
    incoming_msg_id INT,
    outgoing_msg_id INT,
    msg TEXT NOT NULL
);

msg_id — уникальный идентификатор сообщения, автоматически увеличивается при добавлении новых записей (AUTO_INCREMENT).
incoming_msg_id и outgoing_msg_id — необязательные поля, для которых можно оставить значение NULL (так как для них не указано ограничение NOT NULL).
msg — обязательное поле, содержащее текст сообщения, для которого установлено ограничение NOT NULL, чтобы оно не могло быть пустым.
