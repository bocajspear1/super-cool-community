<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>

<main>
    <?php include("includes/database.php"); ?>

    <ul class="nav nav-pills nav-justified">
        <li><a href="index.php?page=about.php">About</a></li>
        <li><a href="index.php?page=accounts.php">Accounts</a></li>
        <li><a href="index.php?page=checks.php">Checks</a></li>
        <li><a href="index.php?page=loans.php">Loans</a></li>
    </ul>
    <section id="page-content">
        <?php 


            if (array_key_exists('page', $_GET) ) {
                include "pages/" . $_GET['page']; 
            } else {
                
            }

        ?>
    </section>

</main>

<?php include 'includes/footer.php' ?>