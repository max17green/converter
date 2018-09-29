<?php

//Буферизация для сохранения этого файла
ob_start();
//Генерируем имя папки
$name = rand(0,10000000);
mkdir($name);
$fileTempName = $_FILES['userfile']['tmp_name'];
//echo $fileTempName."\n";

if (is_dir($name)) {
	if (is_uploaded_file($fileTempName)) {
		if ($_FILES['userfile']['type'] == 'application/pdf') {
			//Определяем количество страниц файла
			$f = fopen($fileTempName, "r");
			while(!feof($f)) {
			  $line = fgets($f,255);
			  if (preg_match('/\/Count [0-9]+/', $line, $matches)){
			    preg_match('/[0-9]+/',$matches[0], $matches2);
			    if ($count<$matches2[0]) $count=$matches2[0];
			  }
			}
			fclose($f);
			echo "<div class='container box'>Количество страниц: {$count}</div>";
			if ($count <= 20) {
				//Ширина и высота страницы
				$w = shell_exec("identify -format %W ".$fileTempName."[0]");
				$h = shell_exec("identify -format %H ".$fileTempName."[0]");
				//echo $w;//." ".$h
				opendir($name);
				mkdir($name."/images");
				//Нашинковать файл на jpeg
				$command = "convert -density 250 ".$fileTempName." -crop ".strval($w*4)."x".strval($h*4)." ".$name."/images/i%d.jpg";
				//echo $command;
				exec($command);
			}
		} else {
			echo "<div class='container'>Вы можете загружать только файлы с расширением pdf.</div>";
		}
	}
}
//echo $fileTempName."\n";
    
?>
<!DOCTYPE html>
<html>
<head>
  <title>Slick Playground</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
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
    	$dir = $name."/images";
    	if (isset($dir)) {
    		//$dir = opendir($dir);
			//$count = 0;
			$files = scandir($dir);
			//Вставка картинок в галерею
			foreach($files as $file) {
				if($file == '.' || $file == '..' || is_dir($dir . $file)){
			        continue;
			    } else {
			    	echo "<div>";
					echo "<img data-lazy='".$dir."/".$file."' class='img_slide'>";//images/
					echo "</div>\n";
			    }		
			}
		}
    ?>
</section>
<div class="container box">
	<a href="zip.php?name=<?php echo $name; ?>" class="link">Скачать</a>
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
	//Сохраняем файл в index.html
	file_put_contents($name.'/index.html', ob_get_contents());
?>
