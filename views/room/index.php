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

    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css"> -->
    <link rel="stylesheet" href="../material.min.css">
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
                    $currentRoom = $jsonDecoded[$room_number];
                ?>

                <!-- Image card with the live feed from the room -->
                <div class="demo-card-image mdl-card room">
                    <h1 class="room_title" style=""><?=$room_number?>. <?=$currentRoom['title']?></h1>
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
                </div>

                <div id="info_bar" class="info_bar"></div>

                <script>
                    const info = document.getElementById("info_bar");
                    const btRestart = document.getElementById("btRefresh");
                    const btTalk = document.getElementById("btMic");
                    const btSound = document.getElementById("btVol");
                    const btAlarm = document.getElementById("btRing");
                    const btStop = document.getElementById("btLock");
                    const btBlockly = document.getElementById("btPuzzle");

                         boolRefresh = false;
                         boolMic = false;
                         boolVol = false;
                         boolRing = false;
                         boolLock = false;
                         boolPuzzle = false;

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
                            info.innerHTML = "RESTARTING..."; // here should appear a slider to change the volume
                            allButtonsOff();
                            btRestart.innerHTML = "<img src='../img/arrow-rotate-right-solid - kopie.svg' alt='' class='icon'>"
                            boolRefresh = true;
                        }
                        else {
                            info.innerHTML = ""; // the slider dissappears
                            btRestart.innerHTML = "<img src='../img/arrow-rotate-right-solid.svg' alt='' class='icon'>"
                            boolRefresh = false;
                        }
                    }

                    function talk() {
                        if(boolMic == false) {
                            info.innerHTML = "MIC ON"; // here should appear a slider to change the volume
                            allButtonsOff();
                            btTalk.innerHTML = "<img src='../img/microphone-solid - kopie.svg' alt='' class='icon'>"
                            boolMic = true;
                        }
                        else {
                            info.innerHTML = "MIC OFF"; // the slider dissappears
                            btTalk.innerHTML = "<img src='../img/microphone-solid.svg' alt='' class='icon'>"
                            boolMic = false;
                        }
                    }

                    function sound() {
                        if(boolVol == false) {
                            info.innerHTML = "MUTED"; // here should appear a slider to change the volume
                            allButtonsOff();
                            btSound.innerHTML = "<img src='../img/volume-high-solid - kopie.svg' alt='' class='icon'>"
                            boolVol = true;
                        }
                        else {
                            info.innerHTML = "UNMUTED"; // the slider dissappears
                            btSound.innerHTML = "<img src='../img/volume-high-solid.svg' alt='' class='icon'>"
                            boolVol = false;
                        }
                    }

                    function alarm() {
                        if(boolRing == false) {
                            info.innerHTML = "!!!"; // here should appear a slider to change the volume
                            allButtonsOff();
                            btAlarm.innerHTML = "<img src='../img/bell-solid - kopie.svg' alt='' class='icon'>"
                            boolRing = true;
                        }
                        else {
                            info.innerHTML = ""; // the slider dissappears
                            btAlarm.innerHTML = "<img src='../img/bell-solid.svg' alt='' class='icon'>"
                            boolRing = false;
                        }
                    }

                    function stop() {
                        if(boolLock == false) {
                            info.innerHTML = "GAME LOCKED"; // here should appear a slider to change the volume
                            allButtonsOff();
                            btStop.innerHTML = "<img src='../img/lock-solid - kopie.svg' alt='' class='icon'>"
                            boolLock = true;
                        }
                        else {
                            info.innerHTML = ""; // the slider dissappears
                            btStop.innerHTML = "<img src='../img/lock-solid.svg' alt='' class='icon'>"
                            boolLock = false;
                        }
                    }

                    function blockly() {
                        if(boolPuzzle == false) {
                            info.innerHTML = ""; // here should appear a slider to change the volume
                            allButtonsOff();
                            btBlockly.innerHTML = "<img src='../img/puzzle-piece-solid - kopie.svg' alt='' class='icon'>"
                            boolPuzzle = true;
                            window.location.href = "../Blockly/index.html?roomID=<?php echo $room_number;?>"
                        }
                        else {
                            info.innerHTML = ""; // the slider dissappears
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
                        }else{
                            alert("Something went wrong "+ errorThrown.status); 
                        }
                        })
                    }

                    
                </script>
                        <button onClick="start()" class="non-style center">
                            start puzzles
                     </button>
                <?php 
                foreach($jsonDecoded[$room_number]['order'] as $key ){
                    echo "<table>";
                    foreach($key as $value){
                        $i = 0;
                        echo"<tr><td id =$i stap></td><td>$value</td></tr>";
                        $i++;
                    };
                };
                echo "</table>";
                ?>

                <?php curl_close($curl); ?>
            </div>
        </main>
    </div>
</body>

</html>