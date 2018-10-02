<?php
namespace File;

class FileClass
{
    public $countPages;
    private $width;
    private $height;
    public $nameDir;
    public $fileTempName;
    public function __construct()
    {
        //Буферизация для сохранения этого файла
        ob_start();
        //Генерируем имя папки
        $this->nameDir = rand(0, 10000000);
        mkdir($this->nameDir);
        $this->fileTempName = $_FILES['userfile']['tmp_name'];
    }
    public function getCountPages($fileTempName)
    {
        $f = fopen($fileTempName, "r");
        while (!feof($f)) {
            $line = fgets($f, 255);
            if (preg_match('/\/Count [0-9]+/', $line, $matches)) {
                preg_match('/[0-9]+/', $matches[0], $matches2);
                if ($count < $matches2[0]) {
                    $count=$matches2[0];
                }
            }
        }
        fclose($f);
        return $count;
    }
    public function echoPages($count)
    {
        echo "<div class='container box'>Количество страниц: {$count}</div>";
    }
    public function echoError()
    {
        echo "<div class='container'>Вы можете загружать только файлы с расширением pdf.</div>";
    }
    public function validateFile($nameDir, $fileTempName)
    {
        if (is_dir($nameDir)) {
            if (is_uploaded_file($fileTempName)) {
                if ($_FILES['userfile']['type'] == 'application/pdf') {
                    if ($count <= 20) {
                        return true;
                    }
                }
            }
        }
    }
    public function getWidthHeight()
    {
        $this->width = shell_exec("identify -format %W ".$fileTempName."[0]");
        $this->height = shell_exec("identify -format %H ".$fileTempName."[0]");
    }
    public function generateImages($nameDir, $fileTempName)
    {
        opendir($nameDir);
        mkdir($nameDir."/images");
        //Нашинковать файл на jpeg
        $command = "convert -density 250 ".$fileTempName." -crop ".
        strval($this->width*4)."x".strval($this->height*4)." ".$nameDir.
        "/images/i%d.jpg";
        //echo $command;
        exec($command);
    }
    public function printImages($nameDir)
    {
        $files = scandir($nameDir);
        //Вставка картинок в галерею
        foreach ($files as $file) {
            if ($file == '.' || $file == '..' || is_dir($nameDir . $file)) {
                continue;
            } else {
                echo "<div>";
                echo "<img data-lazy='".$nameDir."/".$file."' class='img_slide'>";
                echo "</div>\n";
            }
        }
    }
    public function output($nameDir)
    {
        file_put_contents($nameDir.'/index.html', ob_get_contents());
    }
}
