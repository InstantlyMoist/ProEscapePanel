<?php function getInfoCard_cam($id, $title, $camIP, $percentage)
{
  echo
  "<div class='mdl-cell'>
    <a class='demo-card-square mdl-card mdl-shadow--2dp mdl-cell--3-col-desktop non-style' href='./room/$id'>
      <iframe src='$camIP/video'></iframe>
      <div class='mdl-card__title mdl-card--expand'>
        <div class='mdl-card__title-text style='font-weight:bold'>
          <div style='width:1500px'>
            $id. $title
          </div> 
          $percentage%
        </div>
      </div>
    </a>
  </div>";
}

function getInfoCard($id, $title, $percentage)
{
  echo
  "<div class='mdl-cell'>
    <a class='demo-card-square mdl-card mdl-shadow--2dp mdl-cell--3-col-desktop non-style' href='./room/$id'>
      <div class='mdl-card__supporting-text'>
        LET OP<br>
        Deze kamer heeft geen camera
      </div>
      <div class='mdl-card__title mdl-card--expand'>
        <div class='mdl-card__title-text style='font-weight:bold'>
          <div style='width:1500px'>
            $id. $title
          </div> 
          $percentage%
        </div>
      </div>
    </a>
  </div>";
}
?>