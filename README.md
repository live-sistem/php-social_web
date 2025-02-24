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


CREATE TABLE friends (
  user_id int(11) NOT NULL,
  friend_id int(11) NOT NULL,
  status enum(pending, accepted, rejected) NOT NULL DEFAULT pending,
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, friend_id),
  KEY friend_id (friend_id),
  CONSTRAINT friends_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT friends_ibfk_2 FOREIGN KEY (friend_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

Таблица friends:
user_id — уникальный идентификатор пользователя, который отправил запрос на добавление в друзья. Это поле является обязательным и не может быть пустым (NOT NULL).
friend_id — уникальный идентификатор друга, с которым пользователь пытается установить связь. Также обязательное поле (NOT NULL).
status — поле, которое определяет статус дружбы между двумя пользователями. Оно может принимать одно из трех значений:
pending — запрос на добавление в друзья еще не принят.
accepted — запрос на добавление в друзья был принят.
rejected — запрос на добавление в друзья был отклонен.
Значение по умолчанию — pending. Поле обязательно для заполнения (NOT NULL).
created_at — временная метка, которая автоматически устанавливает время и дату создания записи о дружбе. Это поле может быть пустым (NULL), но если оно не заполнено, то по умолчанию будет использоваться текущая временная метка (CURRENT_TIMESTAMP).

