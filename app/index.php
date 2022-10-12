<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>

<main class="container">
    <?php include("includes/database.php"); ?>

    <h2>
        Welcome to <?php echo $config->community_name; ?>
    </h2>
    <h3>
        <?php echo $config->description; ?>
    </h3>

    <p>
        Login above to enjoy this community. Made possible by SuperCoolCommunity!
    </p>


   <p>
     <img src="static/main.jpg">

   </p>
</main>

<?php include 'includes/footer.php' ?>
