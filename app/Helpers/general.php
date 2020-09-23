<?php

use Illuminate\Support\Facades\Storage;

define('PAGENATION_COUNT',50);
function getFolder(){
  return  app()->getlocale() =='ar' ? 'css-rtl' : 'css';
}


function uploadImage($folder,$image){
    $image->store('/', $folder);
    $filename = $image->hashName();
    return  $filename;
 }
 function deleteImage( $image)
 {
     Storage::disk('brands')->delete( $image);

   //  Storage::disk('brands')->delete($brand->photo); // in laravel to delete image from images disk

 }



?>
