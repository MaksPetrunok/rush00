<?php

function connect_db($db_name) {
    return (mysqli_connect('localhost', 'store', '0000', $db_name));
}

function hash_password($password) {
    return hash('whirlpool', substr($passwd, 0, 1)."salty".$password);
}

function auth($email, $passwd) {
    $ret = false;
    $dbc = connect_db('store');
    if ($dbc) {
        $query = 'SELECT Email, Password from users';
        if ($result = mysqli_query($dbc, $query))
        {
            $hash = hash_password($passwd);
            while ($row = mysqli_fetch_row($result)) {
                if ($row[0] == $email) {
                    if ($row[1] == $hash) {
                        $ret = true;
                        break;
                    }
                }
            }
            
            mysqli_free_result($result);
        }
        mysqli_close($dbc);
    }
    return ($ret);
}

?>