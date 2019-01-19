<?php

function connect_db($db_name) {
    return (mysqli_connect('localhost', 'store', '0000', $db_name));
}

function hash_password($password) {
    return hash('whirlpool', substr($passwd, 0, 1)."salty".$password);
}


?>