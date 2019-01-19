<?php

function is_admin($user) {
    return (false);
}

session_start();
//session_destroy();
//echo $_SESSION['logged_on_user'];

$is_logged = $_SESSION['logged_on_user'] != '';
if ($is_logged)
    $is_admin = is_admin($_SESSION['logged_on_user']);
else
    $is_admin = false;

?>

<!DOCTYPE <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>42 Music Store</title>
    <link rel="shortcut icon" href="/img/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/css/main.css" />
    <!--
    <style>
        @media screen and (max-width:500px) {
            .sidebar {
                display: none;
            }
        }
    </style>
    -->
</head>
<body>
    <header class="header">
        <a class="home" href="/" title="Home">
            <img class="logo" src="/img/logo.png" alt="Logo">
            <div class="storename">42 Music Store</div>
        </a>

<?php if ($is_logged): ?>
        <a class="userbutton" href="/logout.php">
            Log Out
        </a>        
<?php else: ?>
        <a class="userbutton" href="/register/">
            Register
        </a>
        <a class="userbutton" href="/login.php">
            Log In
        </a>
<?php endif; ?>

<?php if ($is_admin): ?>
        <a class="userbutton" href="/admin/index.php">
            Admin
        </a>
<?php endif; ?>

        <div class="usermenu">
            <a class="cart" href="cart.php">
                <img src="/img/cart.png" title="My cart" height="100%"><br/>
                My Cart
            </a>
        </div>
    </header>