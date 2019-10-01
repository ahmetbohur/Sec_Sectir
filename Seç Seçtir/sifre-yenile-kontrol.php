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
      <title><?PHP echo $site_isim; ?> | Şifre Yenile</title>
    </head>
    <body>
      <?PHP   include_once "tema/bilesenler/ust_taraf.php"; ?>
      <div id='anasayfa_orta'>
        <div id='giris_orta_orta'>
          <h1><?PHP echo $site_isim; ?> | Şifre Yenile</h1>
            <img src="<?PHP echo $site_logo; ?>"/>
      <?PHP
      if (empty($_POST["sifre1"]) or empty($_POST["sifre2"]) or empty($_POST["kontrol"]) or empty($_POST["kadi"])) {
        echo "<span> Lütfen boş yer bırakmayın! <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.</span>";
        header('Refresh: 3; url='.$site_url.'');
      }else{
        echo "<span>";
            sifre_yenile($baglan, $site_url, $site_isim, mysqli_real_escape_string($baglan,htmlspecialchars($_POST["kadi"])) , mysqli_real_escape_string($baglan,htmlspecialchars($_POST["sifre1"])) , mysqli_real_escape_string($baglan,htmlspecialchars($_POST["sifre2"])) , mysqli_real_escape_string($baglan,htmlspecialchars($_POST["kontrol"])));
        echo "</span>";
      }

       ?>
      </div>
    </div>
    <?PHP include_once "tema/bilesenler/alt_taraf.php"; ?>
  </body>
</html>
