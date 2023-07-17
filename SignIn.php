<?php
require_once __DIR__ . "/connect.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = connectDb()->prepare("SELECT `login` FROM `user`");
    $stmt->execute();
    $user = $stmt->fetchAll();

    foreach ($user as $value) {
        if ($value['login'] === ($_POST['login'])) {
            header('Location: test.php');
        } else {
            $error = "Данный пользователь не найден";
        }

        if (password_verify(empty(($_POST['password'])), empty($user['password']))) {
            $_SESSION['id'] = $user['id'];
        }
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авторизация</title>
</head>
<body>
<form action="SignIn.php" method="post">
    <label for="login">
        Login: <input type="text" name="login" id="login">
    </label>

    <label for="password">
        Password: <input type="password" name="password" id="password">
    </label>

    <input type="submit" name="Войти">
</form>

<div class="exp">
    <?= $error ?>
</div>
</body>
</html>
