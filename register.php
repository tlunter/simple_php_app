<?php

include("includes/database.php");

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $name  = trim($_POST['name']);

    if (strlen($email) == 0) {
        array_push($errors, "Email is too short :(");
    } else {
        $check_email = $db->prepare("SELECT * FROM user WHERE email = ?");
        $check_email->bind_param("s", $_POST['email']);
        $check_email->execute();
        $check_email->close();

        if ($check_email->num_rows > 0) {
            array_push($errors, "Email already exists");
        } else {
            $create_user = $db->prepare("INSERT INTO user (id, email, name, password) VALUES (NULL, ?, ?, ?)");
            $create_user->bind_param("sss", $email, $name, sha1($_POST['password']));
            $create_user->execute();

            if ($create_user->affected_rows == 0) {
                array_push($errors, "Couldn't create user for some reason :(");
            } else {
                header("Location: index.php");
            }
            $create_user->close();
        }
    }
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

<form action="register.php" method="post">
    <fieldset>
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Register!</submit>
    </fieldset>
</form>

<?php

include("includes/footer.php");

?>
