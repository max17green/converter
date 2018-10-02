<?php
namespace RestApiClass;

class RestApi
{
    public function getRestApi($dirName)
    {
        if (!empty($dirName) && $dirName != null) {
            if (file_exists("treatment/".$dirName)) {
                $path = "treatment/".$dirName."/images";
                $files = scandir($path);
                //print_r($files);
                foreach ($files as $file) {
                    if ($file == '.' || $file == '..' || is_dir($path . $file)) {
                        continue;
                    } else {
                        $arr[] = $path."/".$file;
                    }
                }
                return json_encode($arr);
            }
        }
    }
}
