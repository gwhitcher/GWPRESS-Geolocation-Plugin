<?php
//GEO LOOKUP
function lookup($string){
    $string = str_replace (" ", "+", urlencode($string));
    $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$string."&sensor=false";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $details_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = json_decode(curl_exec($ch), true);

    // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
    if ($response['status'] != 'OK') {
        return null;
    }

    //print_r($response);
    $geometry = $response['results'][0]['geometry'];

    $longitude = $geometry['location']['lng'];
    $latitude = $geometry['location']['lat'];

    $array = array(
        'latitude' => $geometry['location']['lat'],
        'longitude' => $geometry['location']['lng'],
        'location_type' => $geometry['location_type'],
    );

    return $array;
}
$address_lookup = lookup($_GET['address']);
?>
<div class="form-group">
    <label for="lat" class="col-sm-2 control-label">Latitude</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="lat" name="lat" placeholder="Latitude" value="<?php echo $address_lookup['latitude']; ?>">
    </div>
</div>

<div class="form-group">
    <label for="lng" class="col-sm-2 control-label">Longitude</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="lng" name="lng" placeholder="Longitude" value="<?php echo $address_lookup['longitude']; ?>">
    </div>
</div>