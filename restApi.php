<?php
    //Запрос http://domen1/restApi.php?name=8091431
	$name = htmlspecialchars($_GET["name"]);
	$dir = "treatment/".$name."/images";
	$files = scandir($dir);
	//print_r($files);
	foreach($files as $file) {
		if($file == '.' || $file == '..' || is_dir($dir . $file)){
	        continue;
	    } else {
	    	$arr[] = $dir."/".$file;
	    }
	}
	//print_r($arr);
	echo json_encode($arr);
?>