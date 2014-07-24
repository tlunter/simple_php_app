<?php

include("includes/database.php");

include("includes/header.php");

?>

<p>
<?php
$current_user = null;

if ($_COOKIE['login']) {
    $find_user = $db->prepare("SELECT * FROM user WHERE token = ?");
    $find_user->bind_param("s", $_COOKIE['login']);
    $find_user->execute();

    $result = $find_user->get_result();

    $current_user = $result->fetch_assoc();

?>
    Hello <?= $current_user['name']?>
<?php

    $result->free();

    $find_user->close();
}
?>
</p>

<a href="login.php">Login</a> | <a href="register.php">Register</a>

<?php

include("includes/footer.php");

?>
