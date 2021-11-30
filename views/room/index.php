<?php
    $uri = $_SERVER['REQUEST_URI'];
    $params = explode('/', $uri);
    $room_number = $params[2];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProEscape - Room</title>


    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</head>

<body>
    <div class="demo-layout-waterfall mdl-layout mdl-js-layout">
        <?php include_once('header.php') ?>
        <main class="mdl-layout__content">
            <div class="page-content">
                <?php
                    $apiurl = 'localhost:3000/api/rooms';
                    $curl = curl_init($apiurl);
                    curl_setopt( $curl, CURLOPT_URL, $apiurl );
                    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
                    $result = curl_exec( $curl );
                    $jsonDecoded = json_decode($result, true); // the json is now decoded to a php array
                    $data = $jsonDecoded[$room_number];
                ?>

                <h1>Dit is <?=$data['title']?></h1>
                Deze kamer wordt op dit moment <?php if($data['runningState']==false){echo"niet ";}?>gespeeld.<br>
                <!-- if this room isn't running, it says "niet" between "moment" and "gespeeld" -->
                Progressie: <?=$data['progress']?> procent<br>
                Deze puzzels zijn aanwezig in <?=$data['title']?>:<br><?php foreach($data['puzzles']as$key=>$value){echo$value;echo"<br>";}?>
                <!-- all ids of the puzzles in this room are given in a list here -->

                <?php curl_close($curl); ?>
            </div>
        </main>
    </div>
</body>

</html>