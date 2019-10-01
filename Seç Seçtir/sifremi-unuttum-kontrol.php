<?PHP
include_once "config/fonksiyonlar.php";
if ($_SERVER['HTTP_REFERER'] == "") {
  header('Refresh: 0; url='.$site_url.'');
  exit("Direkt giriş yasak!");
}
?>
  <!DOCTYPE html>
  <html lang="tr" dir="ltr">
    <head>
      <?PHP echo $site_head_taglari; ?>
      <title><?PHP echo $site_isim; ?> | Şifremi Unuttum</title>
    </head>
    <body>
      <?PHP   include_once "tema/bilesenler/ust_taraf.php"; ?>
      <div id='anasayfa_orta'>
        <div id='giris_orta_orta'>
          <h1><?PHP echo $site_isim; ?> | Şifremi Unuttum</h1>
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
      </div>
    </div>
    <?PHP include_once "tema/bilesenler/alt_taraf.php"; ?>
  </body>
</html>
