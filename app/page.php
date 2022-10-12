<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>

<div class="container-fluid">
    <?php include("includes/database.php"); ?>

    <?php
        $username = "";
        $user_id = 0;
        if (array_key_exists('u', $_GET) ) {
            // Stop SQL injection
            // Was having some problems, disabled for now
            // $username = str_replace("'", "\'", $username);
            // $username = str_replace('"', '\"', $username);

            $username = $_GET['u'];
        }

        if (array_key_exists('postid', $_POST) &&  array_key_exists('comment', $_POST)) {
            $query = "SELECT userid FROM users WHERE username='" . $_SESSION['username'] . "'";
            $user_result = $mysqli->query($query);

            if ($user_result->num_rows > 0) {
                $user_data = $user_result->fetch_assoc();
                $userid = $user_data['userid'];

                $comment_query = "INSERT INTO comments (userid, postid, comment) VALUES (" . $userid . ", " . $_POST['postid'] . ", '" .  $_POST['comment'] . "')";
                $mysqli->query($comment_query);
            }
        }
    ?>

    <div class="container">
    
    <?php 

        if ($username != "") {
            echo "<article>";
            $query = "SELECT * FROM users WHERE username='" . $username . "'";

            $result = $mysqli->query($query);

            if ($result->num_rows > 0) {
                $user_data = $result->fetch_assoc();
                $user_id = $user_data['userid'];
                echo "<div id='profile-top'>";
                echo "<h1>" . $user_data['fullname'] . "</h1>";
                echo "<h3>" . $user_data['username'] . "</h2>";
                echo "<div id='description'>" . $user_data['description'] . "</div>";
                echo "</div>";
            } else {
                echo "User not found!";
            }
            echo "</article>";
        } else {
            $users = $mysqli->query("SELECT * FROM users");

            echo "<table id='user-table'>\n<tr><th>User</th><th>Post Count</th></tr>\n";
            while ($row = $users->fetch_assoc()) {
                $user = $row['username'];
                $fullname = $row['fullname'];
                echo "<tr><td><a href='page.php?u=$user'>$fullname</a></td>";
                $query = "SELECT * FROM posts WHERE userid=" . $row['userid'];
                $posts_result = $mysqli->query($query);
                echo "<td>" . $posts_result->num_rows . "</td>";
                echo "</tr>\n";
            }
            echo "</table>";
        }

    ?>
    </div>
    <?php if ($username != ""): ?>
    <div class="grid">
        <div>
            <?php
                echo "<h3>Posts</h3>";

                $query = "SELECT * FROM posts WHERE userid='" . $user_data['userid'] . "'";
                $posts = $mysqli->query($query);
                if ($posts && $posts->num_rows > 0) {
                    while ($post = $posts->fetch_assoc()) {
                        echo "<article>";
                        echo "<h4>" . $post['title'] . "</h4>";
                        echo "<p>" . $post['text'] . "</p>";
                        $comment_query = "SELECT * FROM comments INNER JOIN users ON comments.userid=users.userid WHERE postid='" . $post['postid'] . "' ";
                        $comments = $mysqli->query($comment_query);
                        if ($comments && $comments->num_rows > 0) {
                            echo "<ul>";
                            while ($comment = $comments->fetch_assoc()) {
                                echo "<li>";
                                echo "<strong>" . $comment['fullname'] . "</strong><br>";
                                echo "<p>" . $comment['comment'] . "</p>";
                                echo "</li>";
                            }
                            echo "</ul>";
                        }
                        
                        if (array_key_exists('logged_in', $_SESSION) && $_SESSION['logged_in']) {
                            echo "<form method='post' action='page.php?u=" . $username . "'>";
                            echo "<textarea name='comment'></textarea>";
                            echo "<input type='hidden' name='postid' value='" . $post['postid'] . "' />";
                            // echo "<input type='hidden' name='u' value='" . $post['userid'] . "' />";
                            echo "<input type='submit' value='Comment!' />";
                            echo "</form>";
                        }
                        echo "</article>";
                    }
                    
                }
            ?>
        </div>
        <div>
            <?php
            $usage = exec("du -d 1 -hc ./uploads/" . $_GET['u'] . "* | tail -n 1");
            $usage = trim(str_replace("total", "", $usage));
            echo "<h3>Uploads (" . $usage . ")</h3>";
            $query = "SELECT * FROM uploads WHERE userid='" . $user_data['userid'] . "'";
            $uploads = $mysqli->query($query);
            if ($uploads&&$uploads->num_rows > 0) {
                echo "<ul>";
                while ($upload = $uploads->fetch_assoc()) {
                    echo "<li class='upload'>";
                    echo "<h4><a href='" . $config->upload_dir . "/" . $upload['filename'] . "'>" . $upload['name'] . "</a></h4>";
                    echo "<p>" . $upload['description'] . "</p>";
                    echo "</lidiv>";
                }
                echo "</ul>";
            }
            ?>
        </div>
    </div>
    <?php endif ?>

    

</div>

<?php include 'includes/footer.php' ?>