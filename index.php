<?php
require_once 'Include/connection.php';
/**
 * @var $db
 */

session_start();

if (isset($_REQUEST['login_btn'])) {
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];

    if (empty($email)) {
        $errorMsg[0][] = "Поле 'Почта' обязательно к заполнению";
    }

    if (empty($password)) {
        $errorMsg[1][] = "Поле 'Пароль' обязательно к заполнению";
    }

    else {
        try {
            $select_stmt = $db->prepare("SELECT * from users WHERE email = :email LIMIT 1");
            $select_stmt->execute([':email' => $email]);
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if ($select_stmt->rowCount() > 0) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['message'] = "Авторизация успешна";
                }
                else {
                    $_SESSION['login_message'] = "Неверный пароль или логин";
                }
            }
            else {
                $_SESSION['login_message'] = "Неверный пароль или логин";
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
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
    <title>Авторизация</title>
</head>
<body>
<div class="container">
    <form action="index.php" method="post">
        <div class="mb-3">
            <?php
            if (isset($errorMsg[0])) {
                foreach ($errorMsg[0] as $mailErrors) {
                    echo "<p class='text-danger'>".$mailErrors."</p>";
                }
            }
            ?>
            <label for="email" class="form-label">Адрес почты</label>
            <input type="email" name="email" class="form-control" placeholder="test@test.ru">
        </div>
        <div class="mb-3">
            <?php
            if (isset($errorMsg[1])) {
                foreach ($errorMsg[1] as $passwordErrors) {
                    echo "<p class='text-danger'>".$passwordErrors."</p>";
                }
            }
            ?>
            <label for="password" class="form-label">Пароль</label>
            <input type="password" name="password" class="form-control" placeholder="">
        </div>
        <button type="submit" name="login_btn" class="btn btn-primary">Войти</button>
    </form>
    Нет аккаунта?<a class="register" href="register.php">Зарегестрироваться</a>
    <?php
    if (!empty($_SESSION['message'])) {
        echo ("<p class='text-success'>".$_SESSION['message']."</p>");
    }
    unset($_SESSION['message']);

    if (!empty($_SESSION['login_message'])) {
        echo ("<p class='text-danger'>".$_SESSION['login_message']."</p>");
    }
    unset($_SESSION['login_message']);
    ?>
</div>
</body>
</html>