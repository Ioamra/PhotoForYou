<?php
	//* filigramme
	$ext_img = ".".strtolower(substr(strrchr($_GET['chemin_image'], "."), 1));
	if ($ext_img == ".jpg" || $ext_img == ".jpeg" || $ext_img == ".JPG" || $ext_img == ".JPEG" ){
		$img = ImageCreateFromJPEG($_GET['chemin_image']);
        $textcolor = imagecolorallocate($img, 224, 34, 34);
        imagestring($img, 5, 10, 10, 'PhotoForYou', $textcolor);
        header('Content-type: image/jpeg');
        imagejpeg ($img);
        imagedestroy($img);
	}
	if ($ext_img == ".png" || $ext_img == ".PNG"){
        $img = ImageCreateFromPNG($_GET['chemin_image']);
        $textcolor = imagecolorallocate($img, 224, 34, 34);
        imagestring($img, 5, 10, 10, 'PhotoForYou', $textcolor);
        header('Content-type: image/jpeg');
        imagejpeg ($img);
        imagedestroy($img);
	}
?>