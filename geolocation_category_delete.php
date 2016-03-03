<?php
$id = mysqli_real_escape_string(db_connect(), $_GET['id']);
new Geolocation();
Geolocation::geocat_delete($id);