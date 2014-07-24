<?php

include("includes/database.php");

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    $query = $db->prepare("SELECT id, email, token FROM user WHERE email = ? AND password = ?") or die($db->error);

    $query->bind_param("ss", $email, sha1($_POST['password']));
    $query->execute();

    $result = $query->get_result();
    if ($account = $result->fetch_assoc()) {

        if (strlen(trim($account['token'])) == 0) {
            srand(time());
            $account['token'] = sha1(rand());
            $set_token = $db->prepare("UPDATE user SET token = ? WHERE email = ?");
            $set_token->bind_param("ss", $account['token'], $account['email']);
            $set_token->execute();

            if ($set_token->affected_rows == 0) {
                array_push($errors, "Couldn't set a token: " . $set_token->error);
            }
        }

        if (count($errors) == 0) {
            header('Location: index.php');
            setcookie("login", $account['token']);
        }
    } else {
        array_push($errors, "Bad login :\\");
    }

    $query->close();
}

include("includes/header.php");

?>

<ul>
<?php

foreach ($errors as $e) {
?>
    <li><?= $e ?></li>
<?php
}
?>
</ul>

<form action="login.php" method="post">
    <fieldset>
        <input type="text" name="email" placeholder="E-mail">
        <input type="password" name="password" placeholder="Password" />
        <button type="submit">Login!</submit>
    </fieldset>
</form>

<?php

include("includes/footer.php");

?>
