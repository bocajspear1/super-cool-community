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

                $resp = $mysqli->multi_query($query);
                

                if (!$resp) {
                    echo "<div class='error'>Failed to query: (" . $mysqli->errno . ") " . $mysqli->error . "</div>";
                } else {
                    do {
                        $result = $mysqli->store_result();
                        if ($result) {
                            if ($result->num_rows == 0) {
                                echo "<div class='error'>The user $username does not exist</div>";
                            } else {
                                $user_data = $result->fetch_assoc();
                                echo "<div id='profile-top'>";
                                echo "<h1>" . $user_data['fullname'] . "</h1>";
                                echo "<h3>" . $user_data['username'] . "</h2>";
                                echo "<div id='description'>" . $user_data['description'] . "</div>";
                                echo "</div><hr>";
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
                            $result->free();
                        }
                    } while ($mysqli->next_result());
                }

            } else {
                
                $users = $mysqli->query("SELECT * FROM users");

                echo "<table id='user-table'>\n<tr><th>User</th><th>Post Count</th></tr>\n";
                while ($row = $users->fetch_assoc()) {
                    $username = $row['username'];
                    $fullname = $row['fullname'];
                    echo "<tr><td><img class='user-icon' src='static/user.png'><a href='page.php?u=$username'>$fullname</a></td>";
                    $query = "SELECT * FROM posts WHERE userid=" . $row['userid'];
                    $posts_result = $mysqli->query($query);
                    echo "<td>" . $posts_result->num_rows . "</td>";
                    echo "</tr>\n";
                }
                echo "</table>";
            }

        ?>
    </section>

</main>

<?php include 'includes/footer.php' ?>