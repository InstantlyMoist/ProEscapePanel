<?php
    $apiurl = 'localhost:3000/api/rooms';
    $curl = curl_init($apiurl);
    curl_setopt($curl, CURLOPT_URL, $apiurl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    $jsonDecoded = json_decode($result, true); // the json is now decoded to a php array
?>

<header class="mdl-layout__header mdl-layout__header--waterfall">
    <div class="mdl-layout__header-row">
        <a href="https://localhost"><span class="mdl-layout-title"><img src="../../img/logo-pro-escape-dark-mode.png" alt="" height="40px"></span></a>
        <div class="mdl-layout-spacer"></div>
        <a href="https://localhost"><button type="button" class="mdl-button">Dashboard</button></a>
        <a href="https://localhost/views/settings/account.php"><button type="button" class="mdl-button">Account</button></a>
        <a href="https://localhost/views/settings/contact.php"><button type="button" class="mdl-button">Contact</button></a>

        <div class="dropdown">
            <button class="dropbtn">PUZZLES
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <?php 
                    foreach ($jsonDecoded as $key => $value){
                        $currentRoom = $jsonDecoded[$key];
                        $roomName = $currentRoom['title'];
                        echo "<a href='https://localhost/room/$key'>$roomName</a>";
                    }
                ?>
            </div>
        </div>
    </div>
</header>