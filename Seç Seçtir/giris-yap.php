<?php
include_once "config/fonksiyonlar.php";
 ?>
 <!DOCTYPE html>
 <html lang="tr" dir="ltr">
   <head>
    <?PHP echo $site_head_taglari; ?>
     <title><?PHP echo $site_isim; ?> | Giriş Yap</title>
   </head>
   <body>
    <?php
    if (empty($session_kadi) OR empty($session_id)) {
      // Giriş yapılmamış
      include_once "tema/bilesenler/ust_taraf.php";
      ?>
      <div id='anasayfa_orta'>
        <div id='giris_orta_orta'>
          <h1><?PHP echo $site_isim; ?> | Giriş Yap</h1>
            <img src="<?PHP echo $site_logo; ?>"/>
          <form method="post" action="giris-yap-kontrol">
            <input type="text" name="kadi" placeholder="Kullanıcı adınız"/>
            <input type="password" name="sifre" placeholder="Şifreniz" />
            <button>Giriş yap</button>
            <a href="sifremi-unuttum" title="Şifremi unuttum" id="sifremi_unuttum_button">Şifremi unuttum!</a>
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
