<?PHP
include_once "../config/fonksiyonlar.php";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?PHP echo $site_isim; ?> | Hesap Oluştur</title>
    <?PHP echo $site_head_taglari; ?>
</head>
<body>
<?php
    if (empty($session_kadi) OR empty($session_id)) {
      ?>
      <div id='mobil_anasayfa_orta'>
        <div id='giris_orta_orta'>
          <h1><?PHP echo $site_isim; ?> <br> Hesap Oluştur</h1>
            <img src="<?PHP echo $site_logo; ?>"/>
            <form method="post" action="mobil/hesap-olustur-kontrol">
              <input type="text" name="kadi" placeholder="Kullanıcı adınız"/>
              <input type="text" name="ad" placeholder="Adınız"/>
              <input type="text" name="sad" placeholder="Soy Adınız"/>
              <input type="text" name="mail" placeholder="Mail Adresiniz"/>
              <input type="password" name="sifre" placeholder="Şifreniz" />
              <span><a title="Kullanım Koşulları" href="/mobil/kullanim-kosullari"><i class="fa fa-book"></i> <u>Kullanım koşullarını</u> okudum ve kabul ediyorum.</a></span>
              <button>Hesap oluştur</button>
            </form>
            <a title="Anasayfa" href="mobil/anasayfa" id="sifremi_unuttum_button"><i class="fa fa-home"></i> Anasayfa</a>
        </div>
        
      </div>
      <?PHP
      }else{
          header("Location: $site_url");
      }
        include_once "../tema/bilesenler/alt_taraf.php";
     ?>
</body>
</html>