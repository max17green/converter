<?php
//echo $_GET["name"];

class ArhiveClass{
    public $zip;
    private $pathdir;
    private $nameArhive;
    function __construct() {
        $this->pathdir = htmlspecialchars($_GET["name"]); // путь к папке, файлы которой будем архивировать
        $this->nameArhive = time().'.zip'; //название архива
        $this->zip = new ZipArchive; // класс для работы с архивами
    }
    function create() {
        $k = $this->zip -> open($this->nameArhive, ZipArchive::CREATE);
        return $k;
    }
    function addIn() {
        $dir = opendir($this->pathdir); // открываем папку с файлами
        //echo "<pre>";
        while( $file = readdir($dir)){ // перебираем все файлы из нашей папки

                if($file == '.' || $file == '..' || is_dir($this->pathdir."/".$file)){
                 continue;
                } else {
                    //echo $pathdir."/".$file."\n";
                    $this->zip -> addFile($this->pathdir."/".$file, $file); // и архивируем
                    $this->zip -> addFile($this->pathdir."/index.html","index.html");
                    $this->zip -> addGlob("assets/*.*");
                    $this->zip -> addGlob("assets/fonts/*.*");
                    $this->zip -> addGlob($this->pathdir."/images/*.jpg");
                    //echo("Заархивирован: " . $pathdir.$file) , '<br/>';

                }
        }

        $this->zip -> close(); // закрываем архив.
    }
    function output() {
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="'.$this->nameArhive.'"');
        readfile($this->nameArhive);
    }
    function printError() {
        die ('<div class="container">Произошла ошибка при создании архива</div>');
    }
}

$a = new ArhiveClass();
if ($a->create()) {
    $a->addIn();
    $a->output();
} else {
    $a->printError();
}
?>