<?php
namespace RestApiClass;

require_once 'vendor/autoload.php';
require_once 'treatment/classes/RestApiClass.php';

use PHPUnit\Framework\TestCase;

class RestApiTest extends \PHPUnit_Framework_TestCase
{
    // Получить имя директории пользователя, которая реально
    //существует
    private function getUserDir()
    {
        $files = scandir('treatment');
        foreach ($files as $file) {
            if (is_dir("treatment/" . $file)) {
                if ($file != '.' && $file != '..') {
                    if (preg_match('/[0-9]{1,8}/', $file)) {
                        return $file;
                    }
                }
            }
        }
    }

    public function testRestApi()
    {
        $dir = $this->getUserDir();
        $rest = new RestApi();
        $arr[] = json_decode($rest->getRestApi($dir));
        $pattern = '/^treatment\/[0-9]{1,8}\/images\/i[0-9]+\.(jpg|jpeg)$/';
        foreach ($arr[0] as $path) {
            //Пример: 'treatment/32323/images/i2.jpeg';
            if (preg_match($pattern, $path)) {
                //echo "\n".$path;
                $array_bool_input[] = true;
            } else {
                $array_bool_input[] = false;
            }
            $array_bool_template[] = true;
        }
        $this->assertEquals($array_bool_input, $array_bool_template);
    }
}
