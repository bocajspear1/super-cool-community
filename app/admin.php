<?php 
include("includes/head.php"); 


// TODO: Use database instead of config file credentials
if (
    (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) ||
    ($_SERVER['PHP_AUTH_USER'] != $config->admin_username && $_SERVER['PHP_AUTH_PW'] != $config->admin_password)
   ) {
    header('WWW-Authenticate: Basic realm="SuperCoolCommunity"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Not authenticated, check your config.json file!';
    exit;
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Site Admin</title>
    <link rel="stylesheet" href="static/pico.min.css">
    <link rel="stylesheet" href="static/site.css">
</head>

<body>
<nav class="container-fluid topnav">
    <ul><li>SuperCoolCommunity - Admin</li></ul>
    <ul><li></li></ul>
    <ul><li><a href="/">Go to site</a></li></ul>
</nav>

<div class="container-fluid">
    <section id="users">
        <?php include("includes/database.php"); ?>
        <h3>Users</h3>
        <table>
            <tr><th>Username</th><th>Full Name</th><th>Password</th><th>Post Count</th><th>Usage</th></tr>

            <?php
                 $query = "SELECT * FROM users";

                 $result = $mysqli->query($query);
 
                 if (!$result) {
                    echo "<div class='error'>Failed to query: (" . $mysqli->errno . ") " . $mysqli->error . "</div>";
                 } else if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row['username'] . "</td><td>" . $row['fullname'] . "</td><td>" . $row['password'] . "</td>";
                        $query = "SELECT * FROM posts WHERE userid=" . $row['userid'];
                        $posts_result = $mysqli->query($query);
                        echo "<td>" . $posts_result->num_rows . "</td>";
                        $usage = exec("du -d 1 -hc ./uploads/" . $row['username'] . "* | tail -n 1");
                        $usage = trim(str_replace("total", "", $usage));
                        echo "<td>" . $usage . "</td>";
                        echo "</tr>\n";
                    }
                 } 
                     
            ?>
            
        </table>
    </section>
    <section id="processes">
        <h3>Server Processes</h3>
        <form method="get" action="">
            <label>Filter:</label><input type="text" placeholder="Process filter" name="psfilter">
            <input type="submit" value="Filter">
        </form>
        <pre><?php 
if (isset($_GET['psfilter'])) {
echo trim(passthru("ps aux | grep " . $_GET['psfilter']));
} else {
passthru("ps aux");
}
?>
        </pre>
    </section>
    <section id="files">
        <h3>Uploaded Files</h3>
        <form method="get" action="">
            <label>Filter:</label><input type="text" placeholder="File filter" name="filefilter">
            <input type="submit" value="Filter">
        </form>
        <pre><?php 
if (isset($_GET['filefilter'])) {
echo trim(passthru("ls -la ./uploads | grep " . $_GET['filefilter']));
} else {
passthru("ls -la ./uploads");
}?>
        </pre>
    </section>
</div>
<?php

?>


<footer>
&copy; 1994 SuperCoolCommunity

</footer>
</body>

</html>



