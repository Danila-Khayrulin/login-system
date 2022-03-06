# Тестовое задание на позицию "PHP разработчик (стажер)"

Задание
Регистрация и авторизация
Написать формы регистрации и авторизации:
 1. В форме регистрации пользователь должен указать Имя, почту, пароль и повтор пароля.
 2. Почта должна быть уникальна и если такая в базе уже есть - уведомлять пользователя об этом.
 3. Пароли в обеих полях должны совпадать, иначе уведомлять пользователя об этом.
 4. Авторизованные пользователи могут авторизоваться в форме авторизации и получить сообщение об успешной авторизации.

# Создание MySQL Database

```sql
CREATE TABLE `users` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `email` varchar(100) NOT NULL DEFAULT '""',
    `name` varchar(100) NOT NULL DEFAULT '""',
    `password` varchar(60) NOT NULL DEFAULT '""',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
```

# Настройка файла <code>Include/connection.php</code>

```php
<?php

$db_host = "localhost"; // Host name
$db_user = "root"; // MySQL name
$db_password = "root"; // // MySQL password
$db_name = "users"; // Database name
```






