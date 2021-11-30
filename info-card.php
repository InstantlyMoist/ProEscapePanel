<?php function getInfoCard($id, $title)
{
    echo "<div class='mdl-cell mdl-cell--3-col'><div class='demo-card-square mdl-card mdl-shadow--2dp'>
    <div class='mdl-card__title mdl-card--expand'>
      <h2 class='mdl-card__title-text'>$title</h2>
    </div>
    <div class='mdl-card__supporting-text'>
      Hier komt het camerabeeld $title
    </div>
    <div class='mdl-card__actions mdl-card--border'>
      <a href='/room/$id' class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect'>
        Bekijk kamer
      </a>
    </div>
  </div>
    </div>";
}