<?php
//use GifCreator\GifCreator;
error_reporting(E_ALL);
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
require('../../application.php');

$ds = DIRECTORY_SEPARATOR;

$vehicleid = (int)$_POST['vehicle_id'];

$vehicle = table_fetch_row('vehicles','id="'.$vehicleid.'"');
if (!$vehicle) { die(); };

$storeFolder = "uploads/vehicles";

$checkid = table_fetch_row('vehicle_photos','vehicle_id="'.$vehicleid.'" AND media_type = "photo"','position DESC');
if($checkid) {
    
    $imageid = ((int)$checkid['position'] + 1);
    
} else {

    $imageid = 1;
}



if (!empty($_FILES)) {

    $path_parts = pathinfo($_FILES['file']['name']);
    $fileExtension = $path_parts['extension'];

    $filename = $vehicleid.'_vehicle_photo_'.$imageid.'.'.$fileExtension;
    $filenamenoext = $vehicleid.'_vehicle_photo_'.$imageid;

    table_insert('vehicle_photos',array('filename','original_filename','caption','media_type','vehicle_id','position'),array('original_filename' => $_FILES['file']['name'],'filename' => $filename,'caption' => '','media_type' => 'photo', 'vehicle_id' => $vehicleid,'position' => $imageid));

    // $image = new SimpleImage();
    // $image->load($_FILES['file']['tmp_name']);
    // if ($image->getWidth() > 2000) {
    //     $image->resizeToWidth(2000);
    // }
    echo BASE_DIR . $storeFolder . $ds . $filename;
    // $image->save(BASE_DIR . $storeFolder . $ds . $filename);
    // $image->resizeToWidth(800);
    // $image->save(BASE_DIR . $storeFolder . $ds . $filenamenoext.'_web.' . $fileExtension);
    // $image->resizeToWidth(200);
    // $image->save(BASE_DIR . $storeFolder . $ds . $filenamenoext.'_thumb.' . $fileExtension);

    $image = new AdvancedSimpleImage();
    $image->fromFile($_FILES['file']['tmp_name']);

    if ($image->getWidth() > 2000) {
        $image->resize(2000);
      
    }
    $image->toFile(BASE_DIR . $storeFolder . $ds . $filename);
    $image->resize(800);
    $image->toFile(BASE_DIR . $storeFolder . $ds . $filenamenoext.'_web.' . $fileExtension);
    $image->resize(200);
    $image->toFile(BASE_DIR . $storeFolder . $ds . $filenamenoext.'_thumb.' . $fileExtension);

}
?>     