<?php
include_once "config/fonksiyonlar.php";
 ?>
 <!DOCTYPE html>
 <html lang="tr" dir="ltr">
   <head>
     <?PHP echo $site_head_taglari; ?>
     <title><?PHP echo $site_isim; ?> | Hakkımızda</title>
   </head>
   <body>
     <?PHP
     include_once "tema/bilesenler/ust_taraf.php";
     ?>
     <div id='anasayfa_orta'>
       <div id='anasayfa_orta_orta'>
         <h1><?PHP echo $site_isim; ?> | Hakkımızda</h1>
         <img src="<?PHP echo $site_logo; ?>"/>
         <span><?PHP echo $site_hakkimizda; ?></span>
       </div>
     </div>
     <?PHP
     include_once "tema/bilesenler/alt_taraf.php"; ?>
   </body>
   </html>
