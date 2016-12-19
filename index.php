<?php
  session_start();

  include_once('api/DB.php');
  include_once('api/School.php');
  
  $conn = new DB;
  $conn->connect();
  
  $schools = new School($conn);
  $schools = $schools->get(['1' => '1']);

  $countries = $conn->get('countries', ['1' => '1'], 'name');
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
        <a class="item logo-item menu" href="index.php">
          <img src="img/SAVONIA_logo.jpg" class="logo-img" alt="Savonia University of Applied Sciences logo" style="width: 100px">
        </a>
        <span class="item">
          Exchange Locations
        </span>
        <div class="item">
        <button id="contactbutton" class="ui yellow button">Contacts</button>
        </div>
        <div class="right menu">
        <?php if(isset($_SESSION["s41pt"]) && $_SESSION["s41pt"] === "985737xz7v8z8sdf859724") : ?>
          <div class="item">
            <a href="api/login.php?logout=true" id="logout" class="ui primary button ">Kirjaudu ulos</a>
          </div>
        <?php else : ?>
          <a href="login.html" class="ui item">
            Kirjaudu
          </a>
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
              <div class="ui search selection dropdown" id="country-dropdown">
                <input name="country" type="hidden">
                <i class="dropdown icon"></i>
                <div class="default text">Search for a country</div>
                <div class="menu">
                  <?php 
                    foreach ($countries as $key => $country) {
                      echo '<div class="item" data-value="' . $country['place_id'] . '">' . $country['name'] . '</div>';
                    }
                  ?>
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
          </div>
        </form>
      </div>
    </div>

    <!--Kokemuksien modaali-->
    <div id="experience-modal" class="ui modal small">
          <div class="header" id="expschool">lol</div>
          <div class="content" id="pdf-content">
            <h4>Country: <span id="expcountry" class="modalsubtitle"></span></h4>
            <h4>City: <span id="expcity" class="modalsubtitle"></span></h4>
            <h4 style="margin-bottom: 5px;">Experiences:</h4>
          </div>
    </div>
    
    <div id="pdf-loader" class="pdf-loader-container shadow-medium">
        <h2>Loading PDF...</h2>
        <div class="pdf-loader"></div>
    </div>

    <!-- Yhteystietomodaali-->
    <div id="contactmodal" class="ui modal">
      <div class="header">Contact List</div>
      <div class="content">
        <h4>Savonia Engineering Exchange Coordinator:<br><span class="modalsubtitle">Soile Takkunen, Opistotie Campus, A-1036,  phone 044 7856298</span></h4>
        <h4>Energy Engineering:<br><span class="modalsubtitle">
        Ritva Käyhkö, Varkaus Campus, phone 044 785 6767 <br>
        Olli-Pekka Kähkönen, Varkaus Campus, phone 044 785 6752</span></h4>
        <h4>Machine Engineering:<br><span class="modalsubtitle">
        Jarmo Pyysalo (Industrial Management), phone 044 785 6781 <br>
        Anssi Suhonen (Research & developement), Opi-B-3112, phone 044 785 5558</span></h4>
        <h4>Construction Engineering:<br><span class="modalsubtitle">
        Ville Kuusela, Opi-A-2086, phone 044 785 6321 <br>
        Janne Repo (Building Architect), Opi-A-2080, phone 055 785 6356</span></h4>
        <h4>Electrical Engineering:<br><span class="modalsubtitle">
        Juhani Rouvali, Opi-B-1198, phone 044 785 6214</span></h4>
        <h4>Information Technology:<br><span class="modalsubtitle">
        Pekka Granroth, Opi-B-2153, phone 044 785 6941</span></h4>
        <h4>Environmental Engineering:<br><span class="modalsubtitle">
        Pasi Pajula, Microkadun kampus, phone 044 785 6361</span></h4>
      </div>
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