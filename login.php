<?php

include('auth.php');

include ('templ/header.php');

$email = $_POST['email'];
$passwd = $_POST['passwd'];

if (!empty($email) && !empty($passwd)) {
    $authorized = auth($email, $passwd);
}
else if (empty($email))
{
    $email_err = "Email not spesified";
} else
{
    $passwd_err = "Password not specified";
}

if () {

}
else {
?>


    <form action="login.php" method="post">
        Email: <input type="text" name="email" value="<?php echo $email; ?>">
        <br/>
        Password: <input type="passwd" name="passwd" value="">
        <br/>
        <input type="submit" name="submit" value="OK">
    </form>


<?php
}
include ('templ/footer.php');
?>