<?php
include_once "config/fonksiyonlar.php";
 ?>
 <!DOCTYPE html>
 <html lang="tr" dir="ltr">
   <head>
     <?PHP echo $site_head_taglari; ?>
     <title><?PHP echo $site_isim; ?> | Hesap Oluştur</title>
   </head>
   <body>
    <?php
    if (empty($session_kadi) OR empty($session_id)) {
      // Giriş yapılmamış
      include_once "tema/bilesenler/ust_taraf.php";
      ?>
        <div id='anasayfa_orta'>
          <div id='giris_orta_orta'>
            <h1><?PHP echo $site_isim; ?> | Hesap Oluştur</h1>
              <img src="<?PHP echo $site_logo; ?>"/>
            <form method="post" action="hesap-olustur-kontrol">
              <input type="text" name="kadi" placeholder="Kullanıcı adınız"/>
              <input type="text" name="ad" placeholder="Adınız"/>
              <input type="text" name="sad" placeholder="Soy Adınız"/>
              <input type="text" name="mail" placeholder="Mail Adresiniz"/>
              <input type="password" name="sifre" placeholder="Şifreniz" />
              <span><a title="Kullanım Koşulları" href="kullanim-kosullari"><i class="fa fa-book"></i> <u>Kullanım koşullarını</u> okudum ve kabul ediyorum.</a></span>
              <button>Hesap oluştur</button>
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
