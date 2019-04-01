<!DOCTYPE html>

<html>

<head>
	<title><?php echo $config->community_name; ?> - SuperCoolCommunity</title>
    <link rel="stylesheet" href="static/site.css">
</head>

<body>
<header>
    <div>SuperCoolCommunity for <?php echo $config->community_name; ?></div>

    <ul>
        <?php
            if (array_key_exists('logged_in', $_SESSION) && $_SESSION['logged_in'] === true) {
                echo "<li><a href='logout.php'>Logout</a></li>";
                echo "<li><a href='me.php'>My Profile</a></li>";
            } else {
                echo "<li><a href='login.php'>Login</a></li>";
                echo "<li><a href='signup.php'>Sign Up</a></li>";
            }

        ?>
            <li><a href="page.php">Users</a></li>
    </ul>
</header>