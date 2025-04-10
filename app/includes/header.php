<!DOCTYPE html>

<html data-theme="dark">

<head>
	<title><?php echo $config->community_name; ?> - SuperCoolCommunity</title>
    <link rel="stylesheet" href="static/pico.min.css">
    <link rel="stylesheet" href="static/site.css">
</head>

<body>
    <nav class="container-fluid topnav">
        <ul>
            <li><?php echo $config->community_name; ?></li>
        </ul>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="page.php">Users</a></li>
            <?php
                $pages = scandir("./pages");
                foreach ($pages as $page) {
                    if ($page != "." && $page != "..") {
                        echo "<li><a href='page.php?p=" . $page . "'>" . ucfirst(pathinfo($page, PATHINFO_FILENAME)) . "</a></li>";
                    }
                }
                if (array_key_exists('logged_in', $_SESSION) && $_SESSION['logged_in'] === true) {
                    echo "<li><a href='me.php'>My Profile</a></li>";
                    echo "<li><a href='logout.php'>Logout</a></li>";
                } else {
                    echo "<li><a href='login.php'>Login</a></li>";
                    echo "<li><a href='signup.php' role='button'>Sign Up</a></li>";
                }
            ?>  
        </ul>
    </nav>