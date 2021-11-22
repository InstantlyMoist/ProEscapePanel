<?php
$title = null;
$icon = null;

$uri = $_SERVER['REQUEST_URI'];
$is_room = strpos($uri, 'room') !== false;
if ($is_room) { //TODO: Probably swap to switch case.
    $params = explode('/', $uri);
    $room_number = $params[2];
    $title =  "Kamer".$room_number;
} else {
    $title = "Dashboard";
    $icon = "
    <a class='mdl-navigation__link' href='/room/add'>
        <i class='material-icons'>add</i>
    </a>";
}

?>

<header class="mdl-layout__header mdl-layout__header--waterfall">
    <!-- Top row, always visible -->
    <div class="mdl-layout__header-row">
        <!-- Title -->
        <span class="mdl-layout-title"><?= $title?></span>
        <div class="mdl-layout-spacer"></div>
        <nav class="mdl-navigation">
            <?=$icon?>
        </nav>
    </div>
</header>
<div class="mdl-layout__drawer">
    <span class="mdl-layout-title">Dashboard</span>
    <nav class="mdl-navigation">
        <a class="mdl-navigation__link" href="/">Dashboard</a>
        <a class="mdl-navigation__link" href="">Link</a>
        <a class="mdl-navigation__link" href="">Link</a>
        <a class="mdl-navigation__link" href="">Link</a>
    </nav>
</div>