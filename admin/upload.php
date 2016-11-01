<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/10/19
 * Time: 11:59
 */

header("Content-type:text/html;charset=utf-8");

if ($_FILES['file']['name']) {

    if (!$_FILES['file']['error']) {

        $name = str_replace('.', '', uniqid(mt_rand(100000, 999999),true));
        $ext = explode('.', $_FILES['file']['name']);
        $filename = $name . '.' . $ext[1];

        $save_path = 'uploads/'.date('Y/m/d');

        if(!file_exists($save_path)){
            if(!mkdir($save_path,0777,true)){
                return false;
            }
        }

        $destination = $save_path.'/'.$filename;
        $location = $_FILES["file"]["tmp_name"];
        move_uploaded_file($location, $destination);

        echo $destination;

    }else{
        echo  $message = 'Your upload triggered the following error:  '.$_FILES['file']['error'];
    }

}