<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>

<main>
    <?php include("includes/database.php"); ?>

    <section id="my-page">
        <?php 

            if (array_key_exists('logged_in', $_SESSION) && $_SESSION['logged_in'] === true) {

                $query = "SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'";
                $result = $mysqli->query($query);

                $user_data = $result->fetch_assoc();

                if (!$result || $result->num_rows == 0) {
                    echo "<div class='error'>The user $username does not exist</div>";
                } else {

                    if (array_key_exists('action', $_POST) && $_POST['action'] === 'post') {
                        $insert = "INSERT INTO posts (userid, title, text) VALUES ('" . $user_data['userid'] . "', '" . $_POST['title'] . "', '" . $_POST['text'] . "')";
                        $result = $mysqli->query($insert);

                        if ($result !== FALSE) {
                            echo "<div>Post created!</div/>";
                        } else {
                            echo "<div class='error'>Post insert failed!</div/>";
                        }
                    } else if (array_key_exists('action', $_POST) && $_POST['action'] === 'upload') {
                        if (count($_FILES) > 0 && array_key_exists('upload_file', $_FILES)) {
                            $upload_filename_items = explode(".", $_FILES['upload_file']['name']);
                            $ext = $upload_filename_items[count($upload_filename_items) - 1];

                            $filename = $_SESSION['username'] . "." . $_POST['name'] . "." . $ext;
                            $src = $_FILES['upload_file']['tmp_name'];

                            $full_path = dirname($_SERVER['SCRIPT_FILENAME']) . "/" . $config->upload_dir . "/" . $filename;
                            $move_result = move_uploaded_file($src, $full_path); 
                            if ($move_result == TRUE) {

                                $insert = "INSERT INTO uploads (userid, name, description, filename) VALUES ('" . $user_data['userid'] . "', '" . $_POST['name'] . "', '" . $_POST['description'] . "', '" . $filename . "')";
                                $result = $mysqli->query($insert);

                                if ($result !== FALSE) {
                                    echo "<div>File uploaded!</div/>";
                                } else {
                                    echo "<div class='error'>Upload insert failed!</div/>";
                                }

                            } else {
                                echo "<div class='error'>Upload failed! (Perhaps the file was too big)</div/>";
                            }
                        } else {
                            echo "<div class='error'>No file uploaded</div>";
                        }

                    } else if (array_key_exists('action', $_POST) && $_POST['action'] === 'description') {
                        $update_query = "UPDATE users SET description='" . $_POST['description'] . "' WHERE userid=" . $user_data['userid'];
                        $result = $mysqli->query($update_query);
                        if (!$result) {
                            "<div class='error'>Update failed</div>";
                        }
                        $mysqli->commit();
                        // Update with new description
                        $result = $mysqli->query($query);
                        $user_data = $result->fetch_assoc();
                    }
                
                
                    
                    echo "<h1>My Profile</h1>";
                    echo "<ul>";
                    echo "<li><strong>Full Name:&nbsp;</strong>" . $user_data['fullname'] . "</li>";
                    echo "<li><strong>Username:&nbsp;</strong>" . $user_data['username'] . "</li>";
                    echo "<li><a href='page.php?u=" . $user_data['username'] . "'>View Your Page</a></li>";
                    echo "</ul>";
                   
                    echo "<hr>";

                    echo "<div id='description'>";
                    echo "<form method='post' action='me.php'> ";
                    echo "<textarea name='description' rows='2', cols='100'>" . $user_data['description'] . "</textarea>";
                    echo "<input type='hidden' name='action' value='description'/><br>";
                    echo "<button type='submit'>Update Description</button></form>";
                    echo "</div>";

                    echo "<div id='new-post'>";
                    echo "<h3>New Post</h3>";
                    echo "<form method='post' action='me.php'> ";
                    echo "<label>Post Title</label><input type='text' name='title' />";
                    echo "<label>Post Content</label><textarea name='text' rows='10' cols='100'></textarea>";
                    echo "<input type='hidden' name='action' value='post'/>";
                    echo "<button type='submit'>Create Post</button></form>";
                    echo "</div>";

                    
                    echo "<div id='new-upload'>";
                    echo "<h3>New Upload</h3>";
                    echo "<form method='post' action='me.php' enctype=\"multipart/form-data\"> ";
                    echo "<label>Upload Name</label><input type='text' name='name' />";
                    echo "<label>Upload Description</label><input type='text' name='description' />";
                    echo "<label>Upload File</label><input type='file' name='upload_file' />";
                    echo "<input type='hidden' name='action' value='upload'/>";
                    echo "<button type='submit'>Upload!</button></form>";
                    echo "</div>";
                }

            } else {
                
                echo "<div class='error'>You need to login!</div>";
            }

        ?>
    </section>

</main>

<?php include 'includes/footer.php' ?>