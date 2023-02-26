
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/gallery.css">
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet"></link>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="js/gallery.js"></script>

    <section class="popout" id="popout" aria-expanded="false">
        <a id="exit"><i class="bi bi-x"></i></a>
        <div class="main">
            <img id="popoutImage" src="everton/2020-05-14_07-51-21_UTC.jpg" alt="">
            <video height="50%" id="popoutVideo" src="" style="display: none;" controls autoplay loop muted></video>
        </div>
    </section>

    <section id="gallery-main" class="gallery">
    <?php require 'php/gallery-loading.php'; ?>
    </section>

</body>
</html>