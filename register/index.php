<?php

// If data form POST - validate input
// else show empty form

// If input is not correct - show pre-filled form (except password)
// If input is correct - call add_new_user().

// add_new_user() should try to add user to database.
// if user added sucsessfully - redirect to login page
// else show error

include ('../tools.php');
include ('create.php');

function check_input($str) {
    $str = trim($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str);
    return $str;
}

include ('../templ/header.php');

$firstname = $lastname = $email = $passwd = $phone = "";
$fname_err = $lname_err = $email_err = $passwd_err = $passwdconf_err = $phone_err = $db_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // First Name
    if (!empty($_POST["firstname"])) {
        $firstname = check_input($_POST["firstname"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
            $fname_err = "Only alphabetical symbols allowed";
        }
    } else {
        $fname_err = "First Name is required";
    }
    // Last Name
    if (!empty($_POST["lastname"])) {
        $lastname = check_input($_POST["lastname"]);
        if (!preg_match("/^([[:alpha:]]|[ ])*$/", $lastname)) {
            $lname_err = "Only alphabetical symbols allowed";
        }
    } else {
        $lname_err = "Last Name is required";
    }
    // Email
    if (!empty($_POST["email"])) {
        $email = check_input($_POST["email"]);
        if (!preg_match("/^[A-Za-z]+[.]?[A-Za-z]*@[A-Za-z]+([.]?[A-Za-z]+)+$/", $email)) {
            $email_err = "Email pattern is not correct";
        } else if (check_email_exists($email)) {
            $email_err = "User with email ".$email." already registered on this site";
        }
    } else {
        $email_err = "Email is required";
    }
    // Password
    if (!empty($_POST["passwd"])) {
        $passwd = $_POST["passwd"];
    } else {
        $passwd_err = "Password can not be empty";
    }
    // Password Confirm
    if (empty($_POST["passwdconf"]) || $_POST["passwdconf"] != $passwd) {
        $passwdconf_err = "Passwords do not match";
    }
    // Phone
    if (!empty($_POST["phone"])) {
        $phone = check_input($_POST["phone"]);
        if (!preg_match("/^\+?[0-9\-]*[0-9]$/", $phone)) {
            $phone_err = "Wrong format";
        }
    } else {
        $phone_err = "Phone is required";
    }
}

/*
$arr = array($firstname, $lastname, $email, $passwd, $phone);
print_r($arr);
$err = array($fname_err, $lname_err, $email_err, $passwd_err, $passwdconf_err, $phone_err);
print_r($err);
*/

if (empty($fname_err) && empty($lname_err) && empty($email_err) &&
    empty($passwd_err) && empty($passwdconf_err) && empty($phone_err))
    $input_correct = true;
else
    $input_correct = false;

// If all input is filled - add to database
if ($_SERVER['REQUEST_METHOD'] == "POST" && $input_correct == 1) {
    echo "Adding user";
    $db_err = create_user($firstname, $lastname, $email, $passwd, $phone);
    if ($db_err != '')
    {
        echo $db_err . "<br/>";
    }
    else
    {
        echo "Thank you for registration!\n";
        echo '<a href="/login.php">Login</a> to continue.';
    }
}
else
{
    echo "SOMETHING WRONG";
    if (!$input_correct)
    {
        if ($fname_err)
            $fname_err = "- ".$fname_err;
        if ($lname_err)
            $lname_err = "- ".$lname_err;
        if ($email_err)
            $email_err = "- ".$email_err;
        if ($passwd_err)
            $passwd_err = "- ".$passwd_err;
        if ($passwdconf_err)
            $passwdconf_err = "- ".$passwdconf_err;
        if ($phone_err)
            $phone_err = "- ".$phone_err;
    }
?>
    
    <div>All fields are required.</div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label class="inpcaption">First Name:</label>
        <input type="text" name="firstname" placeholder="John" class="txtinp" value="<?php echo $firstname; ?>">
        <label class="warning"><?php echo $fname_err; ?></label>
        <br/>

        <label class="inpcaption">Last Name:</label>
        <input type="text" name="lastname" placeholder="Smith" class="txtinp" value="<?php echo $lastname; ?>">
        <label class="warning"><?php echo $lname_err; ?></label>
        <br/>

        <label class="inpcaption">Phone:</label>
        <input type="text" name="phone" placeholder="+38044-123-45-67" class="txtinp" value="<?php echo $phone; ?>">
        <label class="warning"><?php echo $phone_err; ?></label>
        <br/>

        <label class="inpcaption">Email:</label>
        <input type="text" name="email" placeholder="email@example.com" class="txtinp" value="<?php echo $email; ?>">
        <label class="warning"><?php echo $email_err; ?></label>
        <br/>

        <label class="inpcaption">Password:</label>
        <input type="password" name='passwd' class="txtinp" value="">
        <label class="warning"><?php echo $passwd_err; ?></label>
        <br/>
        
        <label class="inpcaption">Confirm Password:</label>
        <input type="password" name="passwdconf" class="txtinp" value="">
        <label class="warning"><?php echo $passwdconf_err; ?></label>
        <br/>

        <br/>
        <input type="submit" value="Register">
    </form>

<?php
}
include ('../templ/footer.html');
?>
