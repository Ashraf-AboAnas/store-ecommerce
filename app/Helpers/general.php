<?php

define('PAGENATION_COUNT',50);
function getFolder(){
  return  app()->getlocale() =='ar' ? 'css-rtl' : 'css';
}


function uploadImage($folder,$image){
    $image->store('/', $folder);
    $filename = $image->hashName();
    return  $filename;
 }




?>
