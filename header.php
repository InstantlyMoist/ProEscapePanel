<?php
$title = null;
$icon = null;

$uri = $_SERVER['REQUEST_URI'];
$is_room = strpos($uri, 'room') !== false;
if ($is_room) { //TODO: Probably swap to switch case.
    $params = explode('/', $uri);
    $room_number = $params[2];
    if($room_number == "add"){
        $room_number = "toevoegen";
    }
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
        <span class="mdl-layout-title"><?= $title?></span>
        <div class="mdl-layout-spacer"></div>
        <button id="show-dialog" type="button" class="mdl-button"><?=$icon?></button>

        <dialog class="mdl-dialog">
            <h4 class="mdl-dialog__title">Nieuwe kamer</h4>
            <form class="mdl-dialog__content">
                <input type="text" id="title" name="title" placeholder="Voer de titel in (max. 32 karakters)"><br>
                <button name="addRoom">Voeg toe</button>
            </form>
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
            var dialog = document.querySelector('dialog');
            var showDialogButton = document.querySelector('#show-dialog');
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