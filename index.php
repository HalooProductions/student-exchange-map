<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/semantic.min.css">
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
  </head>
  <body>
    <div class="header-container shadow-small">
      <div class="ui secondary menu main-menu">
        <a class="item logo-item menu">
          <img src="img/SAVONIA_logo.jpg" class="logo-img" alt="Savonia University of Applied Sciences logo" style="width: 100px">
        </a>
        <span class="item">
          Exchange Locations
        </span>
        <div class="right menu">
        <?php if($_SESSION["s41pt"] !== "985737xz7v8z8sdf859724") : ?>
          <a href="login.html" class="ui item">
            Kirjaudu
          </a>
        <?php else : ?>
          <div class="item">
            <a href="api/login.php?logout=true" id="logout" class="ui primary button ">Kirjaudu ulos</a>
          </div>
        <?php endif; ?>
        </div>
      </div>
    </div>
    <div id="map" class="map"></div>

    <!--Kohdennus valikot-->
    <div class="controls">
      <div class="controls-container">
        <form class="ui form">
          <h4 class="ui dividing header">Search for locations</h4>
          <div class="two fields">
            <div class="field">
              <label>Country</label>
              <div class="ui search selection dropdown">
                <input name="country" type="hidden">
                <i class="dropdown icon"></i>
                <div class="default text">Search for a country</div>
                <div class="menu">
                  <div class="item" data-value="0"><i class="af flag"></i>Afghanistan</div>
                  <div class="item" data-value="1"><i class="al flag"></i>Albania</div>
                </div>
              </div>
            </div>

            <div class="field">
              <label>School</label>
             <!-- <div class="ui search selection dropdown"> -->
                <input name="school" type="hidden">
                  <select class="ui search selection dropdown" id="schoolmenu">
                  <option selected disabled value="">Search for a school</option>
                  </select>
              <!--</div>-->
            </div>
            <!--
            <div class="dropdown">
              <label>School</label>
              <div class="ui search selection dropdown">
                <input name="school" type="hidden">
                <i class="dropdown icon"></i>
                <div class="default text">Search for a school</div>
                <div class="menu" id="schoolmenu">
                </div>
              </div>
            </div>
            -->
          </div>
        </form>
      </div>
    </div>

    <!--Kokemuksien modaali-->
    <div id="infomodal" class="ui modal">
          <div class="header">Savonia AMK</div>
          <div class="content">
            <h4>Maa: <span class="modalsubtitle">Suomi</span></h4>
            <h4>Kaupunki: <span class="modalsubtitle">Kuopio</span></h4>
            <h4>Kokemuksia:</h4>
            <div class="experience">
                <h4>Nimi: <span class="modalsubtitle">Tuukka Heiskanen</span></h4>
                <p id="kokemuslink" class="ui button">Linkki kokemukseen</p>
            </div>
          </div>
    </div>
    
    <div id="pdf-loader" class="pdf-loader-container shadow-medium">
        <h2>Loading PDF...</h2>
        <div class="pdf-loader"></div>
    </div>


    <div id="pdfviewer" class="pdf-viewer">
      <span id="pdf-close" class="fa fa-times pdf-viewer-close"></span>
      <canvas id="pdf-canvas"></canvas>
    </div>
    <div id="pdfcontrols" class="pdf-viewer-controls shadow-small noselect">
      <span id="pdf-viewer-prev" class="fa fa-angle-left pdf-viewer-control shadow-medium"></span>
      <span class="page-num-text"><span id="page_num">1</span> / <span id="page_count">0</span></span>
      <span id="pdf-viewer-next" class="fa fa-angle-right pdf-viewer-control shadow-medium"></span>
    </div>
    <script
            src="https://code.jquery.com/jquery-3.1.0.min.js"
            integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
            crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaRfRL0VME9zL0OZrRNjiLxIMWgis-W5U&libraries=places&callback=init"
    async defer></script>
    <script src="js/pdf.min.js"></script>
    <script src="js/semantic.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>