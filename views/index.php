<!DOCTYPE html>
<html lang="en">

<?php
require('info-card.php');
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProEscape - Home</title>


    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

    <style>
        .demo-card-square.mdl-card {
           width: auto;
        }
    </style>
</head>

<body>
    <div class="demo-layout-waterfall mdl-layout mdl-js-layout">
        <?php include_once('header.php') ?>
        <main class="mdl-layout__content">
            <div class="page-content">
                <div class=mdl-grid>
                    <?php echo getInfoCard(1); ?>
                    <?php echo getInfoCard(2); ?>
                    <?php echo getInfoCard(3); ?>
                    <?php echo getInfoCard(4); ?>
                    <?php echo getInfoCard(5); ?>
                    <?php echo getInfoCard(6); ?>
                    <?php echo getInfoCard(7); ?>
                    <?php echo getInfoCard(8); ?>
                </div>
            </div>
        </main>
    </div>
</body>

</html>