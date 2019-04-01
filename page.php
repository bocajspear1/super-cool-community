<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>

<main>
    <?php include("includes/database.php"); ?>

    <section id="profile-page">
        <?php 


            if (array_key_exists('u', $_GET) ) {
                
                $username = $_GET['u'];

                // Stop SQL injection
                // Was having some problems, disabled for now
                // $username = str_replace("'", "\'", $username);
                // $username = str_replace('"', '\"', $username);

                $query = "SELECT * FROM users WHERE username='" . $username . "'";

                $result = $mysqli->query($query);

                if (!$result || $result->num_rows == 0) {
                    echo "<div class='error'>The user $username does not exist</div>";
                } else {
                    $user_data = $result->fetch_assoc();
                    echo "<h1>" . $user_data['fullname'] . "</h1>";
                    echo "<h3>" . $user_data['username'] . "</h2>";
                    echo "<div id='description'>" . $user_data['description'] . "</div>";
                    echo "<hr>";
                    echo "<div id='posts'>";
                    echo "<h3>Posts</h3>";

                    $query = "SELECT * FROM posts WHERE userid='" . $user_data['userid'] . "'";
                    $posts = $mysqli->query($query);
                    if ($posts&&$posts->num_rows > 0) {
                        while ($post = $posts->fetch_assoc()) {
                            echo "<div class='post'>";
                            echo "<h4>" . $post['title'] . "</h4>";
                            echo "<p>" . $post['text'] . "</p>";
                            echo "</div>";
                        }
                        
                    }

                    echo "</div>";
                    echo "<div id='uploads'>";
                    echo "<h3>Uploads</h3>";
                    $query = "SELECT * FROM uploads WHERE userid='" . $user_data['userid'] . "'";
                    $uploads = $mysqli->query($query);
                    if ($uploads&&$uploads->num_rows > 0) {
                        while ($upload = $uploads->fetch_assoc()) {
                            echo "<div class='upload'>";
                            echo "<h4><a href='" . $config->upload_dir . "/" . $upload['filename'] . "'>" . $upload['name'] . "</a></h4>";
                            echo "<p>" . $upload['description'] . "</p>";
                            echo "</div>";
                        }
                        
                    }
                    echo "</div>";
                }

            } else {
                
                $users = $mysqli->query("SELECT * FROM users");

                while ($row = $users->fetch_assoc()) {
                    $username = $row['username'];
                    $fullname = $row['fullname'];
                    echo "<li><a href='page.php?u=$username'>$fullname</a></li>\n";
                }
                echo "</ul></div>";
            }

        ?>
    </section>

</main>

<?php include 'includes/footer.php' ?>