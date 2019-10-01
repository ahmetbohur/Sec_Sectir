<?php
include_once "config/fonksiyonlar.php";
 ?>
 <!DOCTYPE html>
 <html lang="tr" dir="ltr">
   <head>
     <?PHP echo $site_head_taglari; ?>
     <title><?PHP echo $site_isim; ?> | Şifre Yenile</title>
   </head>
   <body>
    <?php
    if (empty($session_kadi) OR empty($session_id)) {
      // Şifre Yenileılmamış
      include_once "tema/bilesenler/ust_taraf.php";
      ?>
      <div id='anasayfa_orta'>
        <div id='giris_orta_orta'>
          <h1><?PHP echo $site_isim; ?> | Şifre Yenile</h1>
            <img src="<?PHP echo $site_logo; ?>"/>
          <form method="post" action="sifre-yenile-kontrol">
            <input type="password" name="sifre1" placeholder="Şifreniz"/>
            <input type="password" name="sifre2" placeholder="Şifreniz tekrar" />
            <input type="text" name="kadi" value="<?PHP echo mysqli_real_escape_string($baglan,htmlspecialchars($_GET["kadi"])); ?>" readonly="readonly"/>
            <input type="password" name="kontrol" value="<?PHP echo mysqli_real_escape_string($baglan,htmlspecialchars($_GET["kontrol"])); ?>" readonly="readonly"/>
            <button>Şifre Yenile</button>
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
