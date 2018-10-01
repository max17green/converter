<?php
class ArhiveClass{
    private $zip;
    public $pathdir;
    private $nameArhive;
    function init($par) {

        if (!empty($par) && $par != null) {
            if (file_exists($par)) {
                $this->pathdir = htmlspecialchars($par); // путь к папке, файлы которой будем архивировать
                $this->nameArhive = time().'.zip'; //название архива
                $this->zip = new ZipArchive; // класс для работы с архивами
                //echo $this->pathdir;
                return true;
            }
        }
        
    }
    function create() {
        return $this->zip -> open($this->nameArhive, ZipArchive::CREATE);
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
if ($a->init($_GET["name"])) {
    if ($a->create()) {
        //echo "верно";
        $a->addIn();
        $a->output();
    } else $a->printError();
} else $a->printError();
?>