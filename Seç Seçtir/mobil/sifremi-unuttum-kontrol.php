<?PHP
include_once "../config/fonksiyonlar.php";
if ($_SERVER['HTTP_REFERER'] == "") {
  header('Refresh: 0; url='.$site_url.'');
  exit("Direkt giriş yasak!");
}
?>
  <!DOCTYPE html>
  <html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <?PHP echo $site_head_taglari; ?>
      <title><?PHP echo $site_isim; ?> | Şifremi Unuttum</title>
    </head>
    <body>
      <div id='mobil_anasayfa_orta'>
        <div id='giris_orta_orta'>
          <h1><?PHP echo $site_isim; ?> <br> Şifremi Unuttum</h1>
            <img src="<?PHP echo $site_logo; ?>"/>
      <?PHP
      if (empty($_POST["kadi"]) OR empty($_POST["mail"])) {
        echo "<span> Lütfen boş yer bırakmayın! <u><a href='$site_url/sifremi-unuttum'> Şifrenizi unuttuysanız tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde şifremi unuttum sayfasına yönlendirileceksiniz.</span>";
        header('Refresh: 3; url='.$site_url.'/sifremi-unuttum');
      }else{
        echo "<span>";
        sifremi_unuttum($baglan, $site_url, $site_isim, $site_logo, mysqli_real_escape_string($baglan, htmlspecialchars($_POST["kadi"])), mysqli_real_escape_string($baglan, htmlspecialchars($_POST["mail"])));
        echo "</span>";
      }

       ?>
       <a title="Anasayfa" href="mobil/anasayfa" id="sifremi_unuttum_button"><i class="fa fa-home"></i> Anasayfa</a>
      </div>
      
    </div>
    <?PHP include_once "../tema/bilesenler/alt_taraf.php"; ?>
  </body>
</html>
