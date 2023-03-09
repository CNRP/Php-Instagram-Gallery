<?php

//util function for debug
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

// All files in the image-directory folder
$files = glob(dirname(realpath(__DIR__)).'/'.$file_directory.'/*');
foreach($files as $filepath) {
    $filename = basename($filepath);

    //trim the date from the file name for the file key
    $date = strstr($filename, '_UTC', true);
    
    // Look for array entry with the date as the key, if not initalize with default values
    $array[$date] ??= [
        'date' => $date,
        'caption' => '',
        'collection-size' => 0,
        'has-video' => false,
    ];
    
    // File extension of said file
    $ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
    
    if($ext === 'jpg'){
        // Each JPG increments collection size
        $array[$date]['collection-size']++;
    }
    
    elseif ($ext === "txt"){
        // if .txt is present add caption to entry by date
        $caption = file_get_contents($filepath);
        $array[$date]['caption'] = $caption;

    } elseif($ext === 'mp4'){
        // if .mp4 is present, has-video set to true
        $array[$date]['has-video'] = true;
    }
}


foreach ($array as $key => $value)
    if ($value['date'] == false)
        unset($array[$key]);

// console_log($array);

// send array to javascript for displaying
echo'<script> galleryFromArray('.json_encode($array).') </script>';
?>