<?php
    //Запрос http://domen1/restApi.php?name=8091431
	class RestApi{
		function getRestApi($dirName) {
			$path = "treatment/".$dirName."/images";
			$files = scandir($path);
			//print_r($files);
			foreach($files as $file) {
				if($file == '.' || $file == '..' || is_dir($path . $file)){
			        continue;
			    } else {
			    	$arr[] = $path."/".$file;
			    }
			}
			return json_encode($arr);
		}
	}
	$name = htmlspecialchars($_GET["name"]);
	$rest = new RestApi();
	$str = $rest->getRestApi($name);
	echo $str;
?>