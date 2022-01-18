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

    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css"> -->
    <link rel="stylesheet" href="./material.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- <script defer src="https://code.getmdl.io/1.3.0/material.min.css"></script> -->

    <style>
        .demo-card-square.mdl-card {
           width: auto;
        }
    </style>
</head>

<body>
    <?php 
        $apiurl = 'localhost:3000/api/rooms';
        $curl = curl_init($apiurl);
        curl_setopt($curl, CURLOPT_URL, $apiurl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        $jsonDecoded = json_decode($result, true); // the json is now decoded to a php array
    ?>
    <div class="demo-layout-waterfall mdl-layout mdl-js-layout">
        <?php include_once('header.php') ?>
        <main class="mdl-layout__content">
            <div class="page-content">
                <div class="flex">
                    <h2 style="font-weight: bold" class="mg0 pad6">Kamers</h2>

                    <button id="show-dialog" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored mg0 pad10">
                        <i class="material-icons">+</i>
                    </button>
                    
                    <dialog class="mdl-dialog">
                    <p class = "invis-button" id = "close">X</p>
                        </br>
                        <h4 class="mdl-dialog__title">Nieuwe kamer</h4>
                        <form class="mdl-dialog__content">
                            <input type="text" id="title" name="title" placeholder="Voer de titel in (max. 32 karakters)"><br>
                            <button name="addRoom">Voeg toe</button>
                        </form>
                        <form class = "mdl-dialog__content" >
                            <select name = "removeRoom" id = "removeRoom" multiple>
                            <?php
                                    $rooms = array_keys($jsonDecoded);
                                    $count = 0;
                                    foreach($jsonDecoded as $key){
                                        $titel = $key['title'];
                                        $room = $rooms[$count++];
                                        echo "<option value = '${room}'>${room}. ${titel}</option>";}
                            ?>
                            </select>
                            <button name = "removeRoom" id = "buttonRemove">Verwijder</button>
                    </dialog>

                    <?php
                        if(isset($_GET['title']) && $_GET['title'] != null && strlen($_GET['title']) <= 32) {
                            $apiurl = 'localhost:3000/api/room';
                            $curl = curl_init($apiurl);
                            $newTitle = $_GET['title'];
                            $data = array("title" => "{$newTitle}");
                            $payload = json_encode($data);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
                            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            $result = curl_exec($curl);
                            curl_close( $curl ); // the new room is created

                            header('Location: http://localhost');
                            exit;
                        }
                    ?>

                    <!-- TODO oplossen: url onveilig (behoudt info bij refresh) -->

                    <script>
                        let dialog = document.querySelector('dialog');
                        let showDialogButton = document.querySelector('#show-dialog');
                        if (! dialog.showModal) {
                            dialogPolyfill.registerDialog(dialog);
                        }
                        showDialogButton.addEventListener('click', function() {
                            dialog.showModal();
                        });
                        document.getElementById('close').addEventListener('click', function() {
                            dialog.close();
                        });
                       </script>
                       <script>
                            document.getElementById('buttonRemove').addEventListener("click", function() {
                                let dataRemove = $('form').serializeArray()
                            $.ajax({
                                url: `http://localhost:3000/api/room`,
                                type : "delete",
                                data: dataRemove,
                                crossDomain: true,
                            })
                            .always(function(jqXHR, textStatus, errorThrown){
                            if (errorThrown.status == 200){
                                location.reload();
                            }else{
                                alert("Something went wrong "+ errorThrown.status); 
                            }
                            })
                            })
                        </script>
                </div>
                
                <div class="mdl-grid">
                    <?php


                        foreach ($jsonDecoded as $key => $value){
                            $currentRoom = $jsonDecoded[$key];
                            if($currentRoom['camera']) {
                                getInfoCard_cam($key, $currentRoom['title'], $currentRoom['camera'][0], $currentRoom['progress']); // all info cards with cameras are shown with the function in info-card.php
                            }
                            else {
                                getInfoCard($key, $currentRoom['title'], $currentRoom['progress']); // all info cards without cameras are shown with the function in info-card.php
                            }
                        }

                        curl_close( $curl );
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>

</html>



<!-- views/settings/account.php 11 & /views/settings/contact.php 11 -->
<!-- views/room/index.php 46 -->