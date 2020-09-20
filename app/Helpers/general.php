<?php

define('PAGENATION_COUNT',50);
function getFolder(){
  return  app()->getlocale() =='ar' ? 'css-rtl' : 'css';
}
?>
