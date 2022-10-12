<?php include 'includes/head.php'; ?>
<?php include "includes/database.php"; ?>

<?php

$ERROR = "";

if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST))  {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

	$result = $mysqli->query($query);

	if (!$result) {
		$ERROR = "Failed to query: (" . $mysqli->errno . ") " . $mysqli->error;
	} else {
        if ($result->num_rows > 0) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            header('Location: index.php');
        }
    }
    $ERROR = "Invalid login!";

}
?>



<?php include 'includes/header.php'; ?>

<main class="container">

    <?php if ($ERROR != "") : ?>
    <div class="error">
        <?php echo $ERROR; ?>
    </div>
    <?php endif; ?>

    <div id="login">
        <form method="post" action="login.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="username">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</main>

<?php include 'includes/footer.php' ?>