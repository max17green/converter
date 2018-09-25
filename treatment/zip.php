<?php
//echo $_GET["name"];
$pathdir = $_GET["name"]; // путь к папке, файлы которой будем архивировать
$nameArhive = time().'.zip'; //название архива
$zip = new ZipArchive; // класс для работы с архивами
if ($zip -> open($nameArhive, ZipArchive::CREATE) === TRUE){ // создаем архив, если все прошло удачно продолжаем
	
    $dir = opendir($pathdir); // открываем папку с файлами
    //echo "<pre>";
    while( $file = readdir($dir)){ // перебираем все файлы из нашей папки

            if($file == '.' || $file == '..' || is_dir($pathdir."/".$file)){
			        continue;
			    } else {

            	//echo $pathdir."/".$file."\n";
                $zip -> addFile($pathdir."/".$file, $file); // и архивируем
                $zip -> addFile($pathdir."/index.html","index.html");
                $zip -> addGlob("assets/*.*");
                $zip -> addGlob("assets/fonts/*.*");
                $zip -> addGlob($pathdir."/images/*.jpg");
                //echo("Заархивирован: " . $pathdir.$file) , '<br/>';
            }
    }
    $zip -> close(); // закрываем архив.
    //echo "</pre>";
    //echo $zip->filename;
    
    header('Content-type: application/zip');
	header('Content-Disposition: attachment; filename="'.$nameArhive.'"');
	readfile($nameArhive);
	
}else{
    die ('<div class="container">Произошла ошибка при создании архива</div>');
}



?>