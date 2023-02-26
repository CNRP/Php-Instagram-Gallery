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

$handle = opendir(dirname(realpath(__DIR__)).'/'.$file_directory.'/');
while($file = readdir($handle)){
    $supported_image = array(
        'jpg',
    );
    $date = substr($file, 0, strpos($file, "_UTC"));

    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
    if (in_array($ext, $supported_image)) {
            $count++;

            $collectionSize = (int)str_replace("_", "", str_replace(".jpg", "", explode("UTC",$file)[1]));
            if(!is_numeric($collectionSize)){
                $collectionSize = 0;
            }
            $arrayKey = array_search($date, array_column($array, 'date'));

            if($arrayKey){
                $amount = intval($array[$arrayKey]['collection-size']);
                
                if($collectionSize > $amount){
                    if($array[$arrayKey]['has-video'] === "true"){
                        $array[$arrayKey]['has-video'] = true;
                        $array[$arrayKey]['collection-size'] = (int)$collectionSize;
                    }else{
                        $array[$arrayKey]['has-video'] = false;
                        $array[$arrayKey]['collection-size'] = (int)$collectionSize;
                    }
                }
            }else{
                array_push($array, array ("date" => $date, "collection-size" => (int)$collectionSize, "has-video" => false));
            }
        
    }else if($ext === 'mp4'){
        console_log("");
        $hasvideo++;
        $arrayKey = array_search($date, array_column($array, 'date'));
        if($array[$arrayKey]){
            // console_log($array[$arrayKey]['date'] . " Has Video");
            $array[$arrayKey]['has-video'] = true;
        }else{
            array_push($array, array ("date" => $date, "has-video" => true));
        }
    }

}

usort($array, function($a, $b) {
    return ($a['date'] < $b['date']) ? -1 : 1;
  });
$array = array_reverse($array);

$result = true;
$videosInArray = array_count_values(array_map('intval', array_column($array, 'has-video')))[(int)$result];
console_log($hasvideo ." Videos in directory > ". $videosInArray ." Videos In Array");
// console_log($array);

echo'<script> galleryFromArray('.json_encode($array).') </script>';
?>