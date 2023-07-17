<?php
require_once __DIR__ . "/connect.php";

$loginErr = '';

function checkInput($data): string
{
    $data = trim($data);
    $data = stripslashes($data);

    return htmlspecialchars($data);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = checkInput($_POST['login']);
    $password = checkInput($_POST['psd']);

    $hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = connectDb()->prepare("SELECT `login` FROM `user`");
    $stmt->execute();
    $var = $stmt->fetchAll();

    foreach ($var as $value) {
        if ($value['login'] === $_POST['login']) {
            $loginErr = "Данный логин занят. Выберите другой";
        }
    }

    $db = connectDb()->prepare("INSERT INTO ntest.user(`login`, `password`) VALUES (:login, :password)");
    $db->bindParam(':login', $login);
    $db->bindParam(':password', $hash);
    $db->execute();

    header('Location: /test.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
    <label for="login">
        Enter login: <input type="text" name="login" id="login"> <span> <?= $loginErr ?> </span>
    </label>

    <label for="psd">
        Enter password: <input type="password" name="psd" id="psd">
    </label>

    <input type="submit" value="send">
</form>
</body>
</html>
