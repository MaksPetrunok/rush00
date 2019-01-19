<?php

function user_exists($name, $all) {
    foreach($all as $usr) {
        if ($usr['login'] == $name)
            return (true);
    }
    return (false);
}

function create_account($name, $pass) {
    $new_user = array(
        'login' => $name,
        'passwd' => hash('whirlpool', substr($pass, 0, 1).substr($name, 1, 0).$pass)
    );
    return ($new_user);
}

$users_data_dir = "../private";
$users_data = $users_data_dir."/passwd";
$login = $_POST['login'];
$pw = $_POST['passwd'];

if ($_POST['submit'] != 'OK' || $login == '' || $pw == '') {
    echo "ERROR\n";
    exit();
}

if (file_exists($users_data))
{
    $users = unserialize(file_get_contents($users_data));
    if (!user_exists($login, $users)) {
        $users[] = create_account($login, $pw);
        file_put_contents($users_data, serialize($users));
    }
    else
    {
        echo "ERROR\n";
        exit();
    }
}
else
{
    mkdir($users_data_dir);
    $users = array();
    $users[] = create_account($login, $pw);
    file_put_contents($users_data, serialize($users));
}
echo "OK\n";

?>