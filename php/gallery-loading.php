<?php

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags)
    {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

$array = []; 
$account_name = "everton";
$file_directory = "images/instagram";
$count = 0;

$hasvideo = 0;
$hasCaption = 0;

$handle = opendir(dirname(realpath(__DIR__)).'/'.$file_directory.'/');
while($file = readdir($handle)){

    $date = substr($file, 0, strpos($file, "_UTC"));
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
    if($ext === 'jpg'){
        $count++;

        $collectionSize = (int)str_replace("_", "", str_replace(".jpg", "", explode("UTC",$file)[1]));
        $arrayKey = array_search($date, array_column($array, 'date'));
        if($arrayKey){
            if(isset($array[$arrayKey]['collection-size'])){
                $amount = intval($array[$arrayKey]['collection-size']);
                console_log($collectionSize . " i: " . $file);
                if($collectionSize > $amount){
                    $array[$arrayKey]['collection-size'] = (int)$collectionSize;
                }
            }else{
                $array[$arrayKey]['collection-size'] = (int)$collectionSize;
            }
        }else{
            array_push($array, array ("date" => $date, "collection-size" => (int)$collectionSize));
        }
        
    }
    
    if($ext === 'mp4'){
        $hasvideo++;
        $arrayKey = array_search($date, array_column($array, 'date'));
        if($arrayKey){
            $array[$arrayKey]['has-video'] = true;
        }else{
            array_push($array, array ("date" => $date, "has-video" => true));
        }
    }
    
    if ($ext === "txt"){
        $hasCaption++;
        $file_location = dirname(realpath(__DIR__)).'/'.$file_directory.'/'. $file;
        $myfile = fopen( $file_location, "r") or die("Unable to open file!");
        $caption = fread( $myfile, filesize($file_location));

        $arrayKey = array_search($date, array_column($array, 'date'));
        if($arrayKey){
            $array[$arrayKey]['caption'] = $caption;
        }else{
            array_push($array, array ("date" => $date, "caption" => $caption));
        }

        fclose($myfile);
        
    }
    // console_log($file);
}


usort($array, function($a, $b) {
    return ($a['date'] < $b['date']) ? -1 : 1;
  });
$array = array_reverse($array);

// $result = true;
// $videosInArray = array_count_values(array_map('intval', array_column($array, 'has-video')))[(int)$result];
// console_log($hasvideo ." Videos in directory > ". $videosInArray ." Videos In Array");
// console_log($hasCaption);

console_log($array);

echo'<script> galleryFromArray('.json_encode($array).') </script>';
?>