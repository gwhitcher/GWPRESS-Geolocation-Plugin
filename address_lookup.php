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

    $longitude = $geometry['location']['lat'];
    $latitude = $geometry['location']['lng'];

    $array = array(
        'latitude' => $geometry['location']['lng'],
        'longitude' => $geometry['location']['lat'],
        'location_type' => $geometry['location_type'],
    );

    return $array;
}
$address_lookup = lookup($_GET['address']);
?>
<div class="form-group">
    <label for="longitude" class="col-sm-2 control-label">Longitude</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude" value="<?php echo $address_lookup['longitude']; ?>">
    </div>
</div>

<div class="form-group">
    <label for="latitude" class="col-sm-2 control-label">Latitude</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude" value="<?php echo $address_lookup['latitude']; ?>">
    </div>
</div>