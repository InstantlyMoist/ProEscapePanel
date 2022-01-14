<?php
    $uri = $_SERVER['REQUEST_URI'];
    $params = explode('/', $uri);
    if (str_contains($params[2], "?")){
        $escapedParam = explode('?',$params[2]);
        $room_number = $escapedParam[0];
    }else{
        $room_number = $params[2];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProEscape - Room</title>

    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css"> -->
    <link rel="stylesheet" href="../material.min.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<script>
    let boolRefresh = false;
    let boolMic = false;
    let boolVol = false;
    let boolRing = false;
    let boolLock = false;
    let boolPuzzle = false;
</script>

<body>
    <?php 
        $apiurlRooms = 'localhost:3000/api/rooms';
        $curlRoom = curl_init($apiurlRooms);
        curl_setopt($curlRoom, CURLOPT_URL, $apiurlRooms);
        curl_setopt($curlRoom, CURLOPT_RETURNTRANSFER, 1);
        $resultRooms = curl_exec($curlRoom);
        $rooms = json_decode($resultRooms, true); // the json is now decoded to a php array

        $apiurlPuzzles = 'localhost:3000/api/puzzles';
        $curlPuzzles = curl_init($apiurlPuzzles);
        curl_setopt($curlPuzzles, CURLOPT_URL, $apiurlPuzzles);
        curl_setopt($curlPuzzles, CURLOPT_RETURNTRANSFER, 1);
        $resultPuzzles = curl_exec($curlPuzzles);
        $puzzles = json_decode($resultPuzzles, true); // the json is now decoded to a php array
    ?>

    <div class="demo-layout-waterfall mdl-layout mdl-js-layout">
        <?php include_once('header.php') ?>
        <main class="mdl-layout__content">
            <div class="page-content">
                <!-- Image card with the live feed from the room -->
                <div class="demo-card-image mdl-card room">
                    <h1 class="room_title" style=""><?=$room_number?>. <?=$rooms[$room_number]['title']?></h1>
                    <div class="mdl-card__title mdl-card--expand camera_view">
                        <iframe src='<?php $value?>/video' frameborder='50px'></iframe>
                        <!-- <img src="../img/cam_example.jpg" alt=""> -->
                    </div>
                    <div class="mdl-card__actions border">
                        <button onClick="restart()" id="btRefresh" class="non-style center">
                            <img src="../img/arrow-rotate-right-solid.svg" alt="" class="icon">
                        </button>
                        <button onClick="talk()" id="btMic" class="non-style center">
                            <img src="../img/microphone-solid.svg" alt="" class="icon">
                        </button>
                        <button onClick="sound()" id="btVol" class="non-style center">
                            <img src="../img/volume-high-solid.svg" alt="" class="icon">
                        </button>
                        <button onClick="alarm()" id="btRing" class="non-style center">
                            <img src="../img/bell-solid.svg" alt="" class="icon">
                        </button>
                        <button onClick="stop()" id="btLock" class="non-style center">
                            <img src="../img/lock-solid.svg" alt="" class="icon">
                        </button>
                        <button onClick="blockly()" id="btPuzzle" class="non-style center">
                            <img src="../img/puzzle-piece-solid.svg" alt="" class="icon">
                        </button>
                    </div>
                    </br>   
                    voeg een puzzle toe aan jouw kamer.</br>
                    </br>
                    <button id="show-dialog" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored mg0 pad10">
                        <i class="material-icons">+</i>
                    </button>

                    <dialog class="mdl-dialog">
                        <h4 class="mdl-dialog__title">Nieuwe puzzle</h4>
                        <form class="mdl-dialog__content">
                            <label for="Puzzle">Kies een puzzle:</label>
                            <select name="Puzzle" id="Puzzle" multiple>
                                <option value="Kluis">Kluis</option>
                                <option value="Pincode Kluis">Pincode</option>
                                <option value="RFID">RFID</option>
                            </select>
                            </br>
                            </br>
                            <input type="text" id="title" name="title" placeholder="Voer de ip adress in"><br>
                            <button name="addPuzzle" id = "buttonAdd">Voeg toe</button>
                        </form>
                        <form class = "mdl-dialog__content">
                            <label for = "removePuzzle"> Verwijder een puzzle</label>
                            <select name = "removePuzzle" id = "removePuzzle" multiple>
                                <?php
                                    foreach($rooms[$room_number]['puzzles'] as $key){
                                        $titel = $puzzles[$key]['title'];
                                        echo "<option value = '${key}'> ${titel} ${key}</option>";
                                    }
                                ?>
                            </select>
                            <button name = "removePuzzle" id = "buttonRemove">Verwijder</button>
                        </form>
                    </dialog>

                </div>

                <div id="info_bar" class="info_bar"></div>

                <script>

                    document.getElementById('buttonAdd').addEventListener("click", function() {
                        let data = $('form').serializeArray();
                        $.ajax({
                            url:'http://localhost:3000/api/room/puzzle',
                            type : "post",
                            data : {"roomID" : <?php echo $room_number?>,
                                    "info": data},
                            crossDomain:true

                        })
                        .always(function(jqXHR, textStatus, errorThrown){
                        if (errorThrown.status == 200){
                            console.log("puzzle added")
                        }else{
                            alert("Something went wrong "+ errorThrown.status); 
                        }
                        })
                    })

                    document.getElementById('buttonRemove').addEventListener("click", function() {
                        let dataRemove = $('form').serializeArray();
                        $.ajax({
                            url:'http://localhost:3000/api/room/puzzle',
                            type : "delete",
                            data : {"roomID" : <?php echo $room_number?>,
                                    "info": dataRemove},
                            crossDomain:true

                        })
                        .always(function(jqXHR, textStatus, errorThrown){
                        if (errorThrown.status == 200){
                            console.log("puzzle removed")
                        }else{
                            alert("Something went wrong "+ errorThrown.status); 
                        }
                        })
                    })

                    const info_bar = document.getElementById("info_bar");

                    const btRestart = document.getElementById("btRefresh");
                    const btTalk = document.getElementById("btMic");
                    const btSound = document.getElementById("btVol");
                    const btAlarm = document.getElementById("btRing");
                    const btStop = document.getElementById("btLock");
                    const btBlockly = document.getElementById("btPuzzle");



                    function allButtonsOff(){
                        boolRefresh = false;
                        boolMic = false;
                        boolVol = false;
                        boolRing = false;
                        boolLock = false;
                        boolPuzzle = false;

                        btRestart.innerHTML = "<img src='../img/arrow-rotate-right-solid.svg' alt='' class='icon'>"
                        btTalk.innerHTML = "<img src='../img/microphone-solid.svg' alt='' class='icon'>"
                        btSound.innerHTML = "<img src='../img/volume-high-solid.svg' alt='' class='icon'>"
                        btAlarm.innerHTML = "<img src='../img/bell-solid.svg' alt='' class='icon'>"
                        btStop.innerHTML = "<img src='../img/lock-solid.svg' alt='' class='icon'>"
                        btBlockly.innerHTML = "<img src='../img/puzzle-piece-solid.svg' alt='' class='icon'>"
                    }

                    function restart() {
                        if(boolRefresh == false) {
                            info_bar.innerHTML = "RESTARTING..."; // here should appear a slider to change the volume
                            allButtonsOff();
                            btRestart.innerHTML = "<img src='../img/arrow-rotate-right-solid - kopie.svg' alt='' class='icon'>"
                            boolRefresh = true;
                        }
                        else {
                            info_bar.innerHTML = ""; // the slider dissappears
                            btRestart.innerHTML = "<img src='../img/arrow-rotate-right-solid.svg' alt='' class='icon'>"
                            boolRefresh = false;
                        }
                    }

                    function talk() {
                        if(boolMic == false) {
                            info_bar.innerHTML = "MIC ON"; // here should appear a slider to change the volume
                            allButtonsOff();
                            btTalk.innerHTML = "<img src='../img/microphone-solid - kopie.svg' alt='' class='icon'>"
                            boolMic = true;
                        }
                        else {
                            info_bar.innerHTML = "MIC OFF"; // the slider dissappears
                            btTalk.innerHTML = "<img src='../img/microphone-solid.svg' alt='' class='icon'>"
                            boolMic = false;
                        }
                    }

                    function sound() {
                        if(boolVol == false) {
                            info_bar.innerHTML = "MUTED"; // here should appear a slider to change the volume
                            allButtonsOff();
                            btSound.innerHTML = "<img src='../img/volume-high-solid - kopie.svg' alt='' class='icon'>"
                            boolVol = true;
                        }
                        else {
                            info_bar.innerHTML = "UNMUTED"; // the slider dissappears
                            btSound.innerHTML = "<img src='../img/volume-high-solid.svg' alt='' class='icon'>"
                            boolVol = false;
                        }
                    }

                    function alarm() {
                        if(boolRing == false) {
                            info_bar.innerHTML = "!!!"; // here should appear a slider to change the volume
                            allButtonsOff();
                            btAlarm.innerHTML = "<img src='../img/bell-solid - kopie.svg' alt='' class='icon'>"
                            boolRing = true;
                        }
                        else {
                            info_bar.innerHTML = ""; // the slider dissappears
                            btAlarm.innerHTML = "<img src='../img/bell-solid.svg' alt='' class='icon'>"
                            boolRing = false;
                        }
                    }

                    function stop() {
                        if(boolLock == false) {
                            info_bar.innerHTML = "GAME LOCKED"; // here should appear a slider to change the volume
                            allButtonsOff();
                            btStop.innerHTML = "<img src='../img/lock-solid - kopie.svg' alt='' class='icon'>"
                            boolLock = true;
                        }
                        else {
                            info_bar.innerHTML = ""; // the slider dissappears
                            btStop.innerHTML = "<img src='../img/lock-solid.svg' alt='' class='icon'>"
                            boolLock = false;
                        }
                    }

                    function blockly() {
                        if(boolPuzzle == false) {
                            info_bar.innerHTML = ""; // here should appear a slider to change the volume
                            allButtonsOff();
                            btBlockly.innerHTML = "<img src='../img/puzzle-piece-solid - kopie.svg' alt='' class='icon'>"
                            boolPuzzle = true;
                            window.location.href = "../Blockly/index.html?roomID=<?php echo $room_number;?>"
                        }
                        else {
                            info_bar.innerHTML = ""; // the slider dissappears
                            btBlockly.innerHTML = "<img src='../img/puzzle-piece-solid.svg' alt='' class='icon'>"
                            boolPuzzle = false;
                        }
                    }
                    function start(){
                        $.ajax({
                            url: `http://localhost:3000/api/puzzle/start`,
                            type : "get",
                            data: "roomID=<?php echo $room_number ?>",
                            crossDomain: true,
                        })
                        .always(function(jqXHR, textStatus, errorThrown){
                        if (errorThrown.status == 200){
                            alert("Room has started")
                            location.reload();
                        }else{
                            alert("Something went wrong "+ errorThrown.status); 
                        }
                        })
                    }

                   
                    let dialog = document.querySelector('dialog');  
                    let showDialogButton = document.querySelector('#show-dialog');
                    if (! dialog.showModal) {
                        dialogPolyfill.registerDialog(dialog);
                    }
                    showDialogButton.addEventListener('click', function() {
                        dialog.showModal();
                    });
                    dialog.querySelector('.close').addEventListener('click', function() {
                            dialog.close();
                        });

                    
                </script>
                        <div>
                        <button onClick="start()" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                        Kamer starten
                        </button></div>
                <?php 

                    echo "<br>";
                    echo "Room progress: {$rooms[$room_number]['progress']}%" ;
                    echo"<br>";
                    echo "<table>";
                    echo "<th>Stappen</th><th >Puzzles</th>";
                    $i = 1;
                    foreach($rooms[$room_number]['order'] as $key ){
                        echo"<tr><td>stap $i</td>";
                        foreach($key as $value){

                            echo"<td>{$puzzles[$value]['title']}</td>";
                        };
                        echo "</tr>";

                        $i++;
                    };
                    echo "</table>";
                    echo "<br>";
                    echo "<b>bezig met:</b>";
                    echo "<br>";

                    foreach($rooms[$room_number]['current'] as $key){
                       for ($i = 0; $i < sizeof($key); $i++ ){
                           echo $puzzles[$key[$i]]['title'];
                           echo "<br>";
                       }
                    }
                ?>

                <?php curl_close($curl); ?>
            </div>
        </main>
    </div>
</body>

</html>