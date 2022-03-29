<?php

ob_start();
include("data-ajax.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZOO Praha</title>
    <!-- fonty -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <!-- css -->
    <link href="<?php echo home_url(); ?>/templates/data/css/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo home_url(); ?>/templates/data/css/fonts.css" rel="stylesheet" type="text/css">
    <!-- js -->
    <script src="<?php echo home_url(); ?>/templates/data/js/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="<?php echo home_url(); ?>/templates/data/js/scripts.js" type="text/javascript"></script>
    <?php wp_head(); ?>
</head>

<body>
    <h1 class="screenReaderElement">ZOO Praha </h1>
    <header class="header">
        <div class="upbar">
            <div class="container">
                <div class="flex-block">
                    <div class="contacts">
                        <a href="tel:420296112230" class="phone"> +420 296 112 230</a>

                        <a href="mailTo:pr@zoopraha.cz" class="email"> pr@zoopraha.cz</a>
                    </div>
                </div>
            </div>
        </div>



    </header>