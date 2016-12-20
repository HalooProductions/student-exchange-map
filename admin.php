<?php
  session_start();

  include_once('api/DB.php');
  include_once('api/School.php');
  
  $conn = new DB;
  $conn->connect();
  
  $schools = new School($conn);
  $schools = $schools->get(['1' => '1']);

  if ($_SESSION["s41pt"] !== "985737xz7v8z8sdf859724")
  {
      header('Location: login.html');
  }
  
  $countries = $conn->get('countries', ['1' => '1'], 'name');


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="css/semantic.min.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/dropzone.css">
  <meta charset="UTF-8">
  <title>Admin View - Savonia Student Exchange</title>
</head>
<body>
<div class="ui menu">
  <div class="item">
    <a href="index.php" class="ui button">Karttanäkymä</a>
  </div>
  <div class="item">
    <div id="add-school-btn" class="ui primary button">Lisää koulu</div>
  </div>
  <div class="right menu">
    <div class="item">
      <a href="api/login.php?logout=true" id="logout" class="ui primary button ">Kirjaudu ulos</a>
    </div>
  </div>
</div>
<div class="ui grid container">
  <div class="twelve wide column centered">
    <table class="ui single line celled table">
      <thead>
        <tr>
          <th>Maa</th>
          <th>Kaupunki</th>
          <th>Koulu</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if($schools != NULL)
          $schools->each(function($school) {
            ?>
            <tr>
              <td><?= $school['country'] ?></td>
              <td><?= $school['city'] ?></td>
              <td><?= $school['name'] ?></td>
              <td>
                <div class="centered">
                  <button id="add-pdf-btn" class="ui button green pdf-btn" data-id="<?= $school['id'] ?>">Lisää PDF</button>
                  <button class="ui button yellow school-edit-btn" data-id="<?= $school['id'] ?>" data-country="<?= $school['country'] ?>" data-city="<?= $school['city'] ?>" data-school="<?= $school['name'] ?>" data-placeid="<?= $school['place_id'] ?>" data-departments1="<?= implode(',', $school['departments']) ?>">Muokkaa</button>
                  <button class="ui button red school-delete-btn" data-id="<?= $school['id'] ?>">Poista</button>
                </div>
              </td>
            </tr>
          <?php }) ?>
      </tbody>
    </table>
  </div>
</div>
<div id="addmodal" class="ui modal addmodal" name="addschoolmodal">
  <div class="header">Lisää koulu</div>
  <div class="content">
    <div class="ui form">
      <div class="field">
          <label>Koulun nimi</label>
          <input id="addschoolname" type="text" name="schoolname" placeholder="Koulun nimi">
      </div>
      <div class="field">
        <label>Kaupunki</label>
        <input id="addcity" type="text" name="cityname" placeholder="Kaupungin nimi">
      </div>
      <div class="field">
          <label>Maa</label>
          <select id="addcountry" name="countryname" class="ui search dropdown">
            <option value="">Valitse maa</option>
            <?php 
              foreach ($countries as $key => $country) {
                echo '<option value="' . $country['id'] . '">' . $country['name'] . '</option>';
              }
            ?>
          </select>
      </div>
      <div class="field">
        <label>Sijainti</label>
        <button id="create-set-placeid" class="ui button teal">Aseta sijainti</button>
        <span id="place-id-set-create" name="setplaceid">Ei asetettu</span>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" name="departments" value="1">
            <label>Energiatekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" name="departments" value="2">
            <label>Ympäristötekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" name="departments" value="3">
            <label>Industrial Management</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" name="departments" value="4">
            <label>Konetekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" name="departments" value="5">
            <label>Rakennusarkkitehti</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" name="departments" value="6">
            <label>Rakennustekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" name="departments" value="7">
            <label>Sähkötekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" name="departments" value="8">
            <label>Tietotekniikka</label>
        </div>
      </div>
    </div>
    <div id="saveschool" class="ui submit button green" style="margin-top: 15px;">Tallenna</div>
  </div>
</div>
<div id="editmodal" class="ui modal editmodal">
  <div class="header">Muokkaa koulua</div>
  <div class="content">
    <div class="ui form">
      <div class="field">
          <label>Koulun nimi</label>
          <input id="school-input" type="text" name="schoolname1" placeholder="Koulun nimi">
      </div>
      <div class="field">
        <label>Kaupunki</label>
        <input id="city-input" type="text" name="cityname" placeholder="Kaupungin nimi">
      </div>
      <div class="field">
      </div>
      <div class="field">
          <label>Maa</label>
          <select id="country-input" name="countryname1" class="ui search dropdown">
            <option value="">Valitse maa</option>
            <?php 
              foreach ($countries as $key => $country) {
                echo '<option value="' . $country['id'] . '">' . $country['name'] . '</option>';
              }
            ?>
          </select>
      </div>
      <div class="field">
        <label>Sijainti</label>
        <button id="edit-set-placeid" class="ui button teal">Aseta sijainti</button>
        <span id="place-id-set-edit">Asetettu</span>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="1" name="departments1">
            <label>Energiatekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="2" name="departments1">
            <label>Ympäristötekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="3" name="departments1">
            <label>Industrial Management</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="4" name="departments1">
            <label>Konetekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="5" name="departments1">
            <label>Rakennusarkkitehti</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="6" name="departments1">
            <label>Rakennustekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="7" name="departments1">
            <label>Sähkötekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="8" name="departments1">
            <label>Tietotekniikka</label>
        </div>
      </div>
    </div>
    <div id="save-edit" class="ui submit button green" style="margin-top: 15px;">Tallenna</div>
  </div>
</div>
<div id="pdf-modal" class="ui modal">
  <div class="header">Lisää PDF</div>
  <div class="content">
    <div class="ui input" style="margin-bottom: 10px;">
      <input placeholder="Kirjoittajan nimi" id="pdf-writer-name" type="text">
    </div>
    <div action="api/pdfupload.php"
          class="dropzone"
          id="pdfdropzone"></div>
    <div id="save-pdf" class="ui submit button green" style="margin-top: 15px;">Tallenna</div>
  </div>
</div>
<div id="place-id-selector">
  <input id="pac-input" class="place-id-controls" type="text"
          placeholder="Enter a location">
  <div id="map" class="place-id-map"></div>
  <button id="place-id-select-btn" class="ui button teal place-id-select-btn">OK</button>
</div>
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
<script src="js/dropzone.js"></script>
<script>
  Dropzone.autoDiscover = false;
</script>
<script src="js/edit.js"></script>  
<script src="js/semantic.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaRfRL0VME9zL0OZrRNjiLxIMWgis-W5U&libraries=places"
    async defer></script>
</body>
</html>