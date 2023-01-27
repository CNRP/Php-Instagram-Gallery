
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet"></link>
    <title>Document</title>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

<style>
    .gallery{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }
    .column{
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
    }

    .gallery-item{
        width: 200px;
        height: auto;
    }

    .group{
        background-color: red;
    }

</style>

<?php

$array = []; 
$account_name = "everton";

$handle = opendir(dirname(realpath(__FILE__)).'/'.$account_name.'/');
while($file = readdir($handle)){
    $supported_image = array(
        'gif',
        'jpg',
        'jpeg',
        'png'
    );

    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
    if (in_array($ext, $supported_image)) {
        if($file !== '.' && $file !== '..'){
        
            $important = explode("UTC",$file)[1];
            $trim = str_replace(".jpg", "", $important);
            $trim = str_replace("_", "", $trim);

            $key = substr($file, 0, strpos($file, "_UTC"));

            if (array_key_exists($key, $array)){
                if($trim > $array[$key]){
                    $array[$key] = $trim;
                }
            }else{
                if(is_numeric($trim)){
                    $array[$key] = $trim;
                }else{
                    $array[$key] = 0;
                }
            }
        }
    }
    
}

$length = sizeof($array)/4;
print($length);
$count = 0;

echo '<div class="gallery">
        <div class="column">';


$array = array_reverse($array);

foreach($array as $x => $val) {
    $count++;
    $strip = str_replace("_", "", $x);
    $strip = str_replace("-", "", $strip);

    if($count == $length){
        $count = 0;
        echo '</div><div class="column">';
    }

    if($val == 0){
        echo '<img src="'.$account_name.'/'.$x.'_UTC.jpg" class="gallery-item"/>';
    }else{
        echo '<section class="gallery-item splide splide-'.$strip.'" >
                <div class="splide__track">
                    <ul class="splide__list">';

        for($i = 1; $i < $val +1 ; $i++){
            echo '
                <li class="splide__slide">
                    <img src="'.$account_name.'/'.$x.'_UTC_'.$i.'.jpg" class="gallery-item" alt="">
			    </li>';
        }

        echo '      </ul>
                </div>
            </section>
            
            <script> new Splide( ".splide-'.$strip.'" ).mount(); </script>';
    }
    
}

echo '</div>';
?>
</div>

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>


</body>
</html>