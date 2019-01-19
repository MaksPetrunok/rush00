<?php

function check_email_exists($email) {
    $result = false;
    $dbc = connect_db('store');
    if ($dbc) {
        $query = "SELECT Email from users";
        if ($result = mysqli_query($dbc, $query))
        {
            while ($row = mysqli_fetch_row($result)) {
                if ($row[0] === $email) {
                    $result = true;
                    break;
                }
            }
            mysqli_free_result($result);
        }
        mysqli_close($dbc);
    }
    return ($result);
}

function create_user($firstname, $lastname, $email, $passwd, $phone) {
    $err_msg = "";
    $dbc = connect_db('store');
    if ($dbc) {
        $hash = hash_password($passwd);
        $query = "INSERT INTO users (" .
                 "Email, Password, FirstName, LastName, PhoneNumber)" .
                 "VALUES (" .
                 "'$email', '$hash', '$firstname', '$lastname', '$phone')";
        $result = mysqli_query($dbc, $query);
        if (!$result) {
            $err_msg = "Cannot write data to database.<br/>";
        }
    } else {
        $err_msg = "Error " . mysqli_connect_errno() . ": " . mysqli_connect_error() . ".<br/>";
    }
    mysqli_close($dbc);
    return ($err_msg);
}

?>