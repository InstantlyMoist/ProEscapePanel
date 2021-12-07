<?php
$title = null;
$icon = null;

$uri = $_SERVER['REQUEST_URI'];
$is_room = strpos($uri, 'room') !== false;
if ($is_room) { //TODO: Probably swap to switch case.
    $params = explode('/', $uri);
    $room_number = $params[2];
    $title =  "Kamer ".$room_number;
}
else {
    $title = "Dashboard";
    $icon = "<i class='material-icons'>add</i>";
}?>

<header class="mdl-layout__header mdl-layout__header--waterfall">
    <!-- Top row, always visible -->
    <div class="mdl-layout__header-row">
        <!-- Title -->
        <span class="mdl-layout-title"><img src="../img/logo-pro-escape-dark-mode.png" alt="" height="40px"></span>
        <!-- <div class="mdl-layout-spacer"></div> -->
        <!-- <button id="show-dialog" type="button" class="mdl-button"><?=$icon?></button> -->
    </div>
</header>