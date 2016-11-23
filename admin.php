<!DOCTYPE html>
<?php
  include_once('api/DB.php');
  include_once('api/School.php');
  
  $conn = new DB;
  $conn->connect();
  
  $schools = new School($conn);
  $schools = $schools->get(['1' => '1']);
?>
<html lang="en">
<head>
  <link rel="stylesheet" href="css/semantic.min.css">
  <link rel="stylesheet" href="css/main.css">
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
<div class="ui menu">
  <div class="item">
    <a href="index.html" class="ui button">Karttanäkymä</a>
  </div>
  <div class="item">
    <div id="add-school-btn" class="ui primary button">Lisää koulu</div>
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
          $schools->each(function($school) {
            ?>
            <tr>
              <td><?= $school['country'] ?></td>
              <td><?= $school['city'] ?></td>
              <td><?= $school['name'] ?></td>
              <td>
                <div class="centered">
                  <button class="ui button yellow school-edit-btn" data-id="<?= $school['id'] ?>" data-country="<?= $school['country'] ?>" data-city="<?= $school['city'] ?>" data-school="<?= $school['name'] ?>" data-placeid="<?= $school['place_id'] ?>" data-departments="<?= implode(',', $school['departments']) ?>">Muokkaa</button>
                  <button class="ui button red">Poista</button>
                </div>
              </td>
            </tr>
          <?php }) ?>
      </tbody>
    </table>
  </div>
</div>
<div id="addmodal" class="ui modal">
  <div class="header">Lisää koulu</div>
  <div class="content">
    <div class="ui form">
      <div class="field">
          <label>Koulun nimi</label>
          <input id="addschoolname" type="text" name="school-name" placeholder="Koulun nimi">
      </div>
      <div class="field">
        <label>Kaupunki</label>
        <select id="addcity" class="ui search dropdown">
          <option value="">Valitse kaupunki</option>
          <option value="1">Regensburg</option>
          <option value="2">Kuopio</option>
        </select>
      </div>
      <div class="field">
          <label>Maa</label>
          <select id="addcountry" class="ui search dropdown">
            <option value="">Valitse maa</option>
            <option value="1">Suomi</option>
            <option value="2">Ruotsi</option>
            <option value="3">Saksa</option>
          </select>
        </div>
        <div id="map" class="hidemap"></div>
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
<div id="editmodal" class="ui modal">
  <div class="header">Muokkaa koulua</div>
  <div class="content">
    <div class="ui form">
      <div class="field">
          <label>Koulun nimi</label>
          <input id="school-input" type="text" name="school-name" placeholder="Koulun nimi">
      </div>
      <div class="field">
        <label>Kaupunki</label>
        <select id="city-input" class="ui search dropdown">
          <option value="">Valitse kaupunki</option>
          <option value="1">Regensburg</option>
          <option value="2">Kuopio</option>
        </select>
      </div>
      <div class="field">
          <label>Maa</label>
          <select id="country-input" class="ui search dropdown">
            <option value="">Valitse maa</option>
            <option value="1">Suomi</option>
            <option value="2">Ruotsi</option>
            <option value="3">Saksa</option>
          </select>
        </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="1" name="departments">
            <label>Energiatekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="2" name="departments">
            <label>Ympäristötekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="3" name="departments">
            <label>Industrial Management</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="4" name="departments">
            <label>Konetekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="5" name="departments">
            <label>Rakennusarkkitehti</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="6" name="departments">
            <label>Rakennustekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="7" name="departments">
            <label>Sähkötekniikka</label>
        </div>
      </div>
      <div class="inline field">
          <div class="ui toggle checkbox">
            <input type="checkbox" tabindex="0" class="hidden" value="8" name="departments">
            <label>Tietotekniikka</label>
        </div>
      </div>
    </div>
    <div id="save-edit" class="ui submit button green" style="margin-top: 15px;">Tallenna</div>
  </div>
</div>
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
<script src="js/edit.js"></script>  
<script src="js/semantic.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaRfRL0VME9zL0OZrRNjiLxIMWgis-W5U&libraries=places"
    async defer></script>
<!--<script src= https://maps.googleapis.com/maps/api/place/textsearch/xml?query=restaurants+in+Sydney&key=AIzaSyDaRfRL0VME9zL0OZrRNjiLxIMWgis-W5U></script>!-->
</body>
</html>