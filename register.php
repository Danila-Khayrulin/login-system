<?php
require_once 'Include/connection.php';
/**
 * @var $db
 */

session_start();

if (isset($_REQUEST['register_btn'])) {

    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $password_confirm = $_REQUEST['password_confirm'];

    if (empty($name)) {
        $errorMsg[0][] = "Поле 'Имя' обязательно к заполнению";
    }

    if (empty($email)) {
        $errorMsg[1][] = "Поле 'Адрес почты' обязательно к заполнению";
    }

    if (empty($password)) {
        $errorMsg[2][] = "Поле обязательно к заполнению";
    }

    if (empty($password_confirm)) {
        $errorMsg[3][] = "Поле обязательно к заполнению";
    }

    if (!($password === $password_confirm) and !empty($password) and !empty($password_confirm)) {
        $errorMsg[3][] = "Пароли должны совпадать";
    }

    if (empty($errorMsg)) {
        try {
            $select_stmt = $db->prepare("SELECT email FROM users WHERE email = :email");
            $select_stmt->execute(['email' => $email]);
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if (isset($row['email']) == $email) {
                $errorMsg[1][] = "Пользователь с такой почтой уже зарегестрирован!";
            }
            else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $insert_stmt = $db->prepare("INSERT INTO users(name, email, password) VALUES (:name, :email, :password)");
                $insert_stmt->execute([':name' => $name, ':email' => $email, ':password' => $hashed_password]);
                $_SESSION['message'] = "Регистрация выполнена успешно";
                header("Location: index.php");
            }
        }
        catch (PDOException $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Регистрация</title>
</head>
<body>
<div class="container">
    <form action="register.php" method="post">
        <div class="mb-3">
            <?php
            if (isset($errorMsg[0])) {
                foreach ($errorMsg[0] as $nameErrors) {
                    echo "<p class='text-danger'>".$nameErrors."</p>";
                }
            }
            ?>
            <label for="name" class="form-label">Имя</label>
            <input type="text" name="name" class="form-control" placeholder="">
        </div>
        <div class="mb-3">
            <?php
            if (isset($errorMsg[1])) {
                foreach ($errorMsg[1] as $mailErrors) {
                    echo "<p class='text-danger'>".$mailErrors."</p>";
                }
            }
            ?>
            <label for="email" class="form-label">Адрес почты</label>
            <input type="email" name="email" class="form-control" placeholder="test@test.ru">
        </div>
        <div class="mb-3">
            <?php
            if (isset($errorMsg[2])) {
                foreach ($errorMsg[2] as $passwordErrors) {
                    echo "<p class='text-danger'>".$passwordErrors."</p>";
                }
            }
            ?>
            <label for="password" class="form-label">Пароль</label>
            <input type="password" name="password" class="form-control" placeholder="">
        </div>
        <div class="mb-3">
            <?php
            if (isset($errorMsg[3])) {
                foreach ($errorMsg[3] as $passwordErrors) {
                    echo "<p class='text-danger'>".$passwordErrors."</p>";
                }
            }
            ?>
            <label for="password_confirm" class="form-label">Введите пароль еще раз</label>
            <input type="password" name="password_confirm" class="form-control" placeholder="">
        </div>
        <button type="submit" name="register_btn" class="btn btn-primary">Зарегестрироваться</button>
    </form>
    Уже есть аккаунт? <a class="register" href="index.php">Войти</a>
</div>
</body>
</html>