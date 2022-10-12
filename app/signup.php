<?php include 'includes/head.php' ?>

<?php include("includes/database.php"); ?>

<?php

$ERROR = "";
$OKAY = FALSE;

if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST) && array_key_exists('description', $_POST) && array_key_exists('fullname', $_POST))  {

    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $description = $_POST['description'];
	$password = $_POST['password'];

	// Stop SQL injection
    // Was having some problems, disabled for now
	// $username = str_replace("'", "\'", $username);
	// $username = str_replace('"', '\"', $username);

	$query = "SELECT * FROM users WHERE username='" . $username . "'";

	$result = $mysqli->query($query);

	if (!$result) {
		$ERROR = "Failed to query: (" . $mysqli->errno . ") " . $mysqli->error;
	} else {
        if ($result->num_rows > 0) {
            $ERROR = "The username you selected is already being used, please try another.";
        } else {
            $query = "INSERT INTO users (username, fullname, password, description) VALUES ('$username', '$fullname', '$password', '$description')";
            $result = $mysqli->query($query);

            if ($result === TRUE) {
                $OKAY = TRUE;
            } else {
                $ERROR = "Insert failed (" . $mysqli->errno . ") " . $mysqli->error;
            }
        }
    }

    if (!$mysqli->connect_errno) {
        $mysqli->close();
    }

}

?>
<?php include 'includes/header.php' ?>

<main class="container">

    <p>
    Signing up for an account is fast and easy!
    </p>


    <?php if ($ERROR != "") : ?>
    <div class="error">
        <?php echo($ERROR); ?>
    </div>
    <?php endif; ?>

    <?php if ($OKAY) : ?>
    <div class="alert alert-success">
        Account created! Welcome to <?php echo $config->community_name; ?>
    </div>
    <?php endif; ?>

    <form method="post" action="signup.php" id="signup-form">
        
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
    
        <label for="fullname">Full Name</label>
        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name">

        <label for="username">Password</label>
        <input type="password" class="form-control" name="password" id="password">

        <label for="username">Description of You!</label>
        <textarea name="description" id="description" rows="2", cols="100"></textarea>
        <button type="submit" class="btn btn-primary">Sign Up!</button>
    </form>

</main>

<?php include 'includes/footer.php' ?>