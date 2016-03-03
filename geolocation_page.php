<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/gw-content/plugins/geolocation/google_map.js" type="text/javascript"></script>
<div>
    <input type="text" id="addressInput" size="10"/>
    <select id="radiusSelect">
        <option value="25" selected>25mi</option>
        <option value="100">100mi</option>
        <option value="200">200mi</option>
        <option value="10000">10000mi</option>
    </select>

    <input type="button" onclick="searchLocations()" value="Search"/>
</div>
<div><select id="locationSelect" style="width:100%;visibility:hidden"></select></div>
<?php
/*
 Wrap in <div id="mapsubmit" style="visibility:hidden;"> tag
 and uncomment mapsubmit.style.visibility = "visible"; in google_map.js
 to hide on page load and display on submit!
 */
?>
<div id="map" style="width: 100%; height: 80%"></div>