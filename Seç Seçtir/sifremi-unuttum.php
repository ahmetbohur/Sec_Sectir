<?php
include_once "config/fonksiyonlar.php";
 ?>
 <!DOCTYPE html>
 <html lang="tr" dir="ltr">
   <head>
     <?PHP echo $site_head_taglari; ?>
     <title><?PHP echo $site_isim; ?> | Şifremi Unuttum</title>
   </head>
   <body>
    <?php
    if (empty($session_kadi) OR empty($session_id)) {
      // Şifremi Unuttumılmamış
      include_once "tema/bilesenler/ust_taraf.php";
      ?>
      <div id='anasayfa_orta'>
        <div id='giris_orta_orta'>
          <h1><?PHP echo $site_isim; ?> | Şifremi Unuttum</h1>
            <img src="<?PHP echo $site_logo; ?>"/>
          <form method="post" action="sifremi-unuttum-kontrol">
            <input type="text" name="kadi" placeholder="Kullanıcı adınız"/>
            <input type="text" name="mail" placeholder="Mail adresiniz" />
            <button>Şifremi Unuttum</button>
          </form>
        </div>
      </div>
      <?PHP
      }else{
        header("Location: $site_url");
      }
        include_once "tema/bilesenler/alt_taraf.php";
     ?>
   </body>
 </html>
