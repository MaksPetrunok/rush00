<?php

include ('auth.php');

include ('templ/header.php');
include ('tools.php');

$email = $_POST['email'];
$passwd = $_POST['passwd'];


$authorized = false;

if (!empty($email) && !empty($passwd)) {
    $authorized = auth($email, $passwd);
}
else if (empty($email)) {
    $email_err = "Email not spesified";
}
else {
    $passwd_err = "Password not specified";
}

if ($authorized) {
    $_SESSION['logged_on_user'] = $email;
    header("Location: index.php");
}
else
{
    
    if (!$authorized && $_SERVER['REQUEST_METHOD'] == "POST") {
        echo "Email or password is not correct.\n";
    }
?>


    <form action="login.php" method="post">
        Email: <input type="text" name="email" value="<?php echo $email; ?>">
        <span><?php echo $email_err; ?></span>
        <br/>
        Password: <input type="passwd" name="passwd" value="">
        <span><?php echo $passwd_err; ?></span>
        <br/>
        <input type="submit" name="submit" value="OK">
    </form>


<?php
}
include ('templ/footer.html');
?>