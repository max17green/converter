<?php
namespace File;

require_once("classes/FileClass.php");

$file = new FileClass();
$file->countPages = $file->getCountPages($file->fileTempName);
$file->echoPages($file->countPages);
if ($file->validateFile($file->nameDir, $file->fileTempName)) {
    $file->getWidthHeight();
    $file->generateImages($file->nameDir, $file->fileTempName);
} else {
    $file->echoError();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Slick Playground</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./assets/slick.css">
    <link rel="stylesheet" type="text/css" href="./assets/slick-theme.css">
    <style type="text/css">
    html, body {
        margin: 0;
        padding: 0;}
    * {box-sizing: border-box;}
    .slider {
        width: 80%;
        margin: 30px auto;}
    .slick-slide {
        margin: 0px 20px;
        height: auto;}
    .slick-slide img {
        width: 100%;}
    .slick-prev:before,
    .slick-next:before {
        color: black;}
    .slick-slide {
        transition: all ease-in-out .3s;
        opacity: .2;}  
    .slick-active {
        opacity: .5;}
    .slick-current {
        opacity: 1;}
    .img_slide{
        background-size: cover;}
    .box{text-align: center;}
    .link{font-size: 30px;}
    </style>
</head>
<body>
    <section class="lazy slider" data-sizes="50vw">
    <?php
        $file->printImages($file->nameDir."/images");
    ?>
    </section>
    <div class="container box">
        <a href="zip.php?name=<?php echo $file->nameDir; ?>" class="link">Скачать</a>
    </div>

    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="./assets/slick.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
    $(document).on('ready', function() {
        $(".vertical-center-4").slick({
            dots: true,
            vertical: true,
            centerMode: true,
            slidesToShow: 4,
            slidesToScroll: 2
        });
        $(".vertical-center-3").slick({
            dots: true,
            vertical: true,
            centerMode: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".vertical-center-2").slick({
            dots: true,
            vertical: true,
            centerMode: true,
            slidesToShow: 2,
            slidesToScroll: 2
        });
        $(".vertical-center").slick({
            dots: true,
            vertical: true,
            centerMode: true,
        });
        $(".vertical").slick({
            dots: true,
            vertical: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".regular").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".center").slick({
            dots: true,
            infinite: true,
            centerMode: true,
            slidesToShow: 5,
            slidesToScroll: 3
        });
        $(".variable").slick({
            dots: true,
            infinite: true,
            variableWidth: true
        });
        $(".lazy").slick({
            lazyLoad: 'ondemand', // ondemand progressive anticipated
            infinite: true
        });
    });
    </script>
</body>
</html>
<?php
    $file->output($file->nameDir);
?>
