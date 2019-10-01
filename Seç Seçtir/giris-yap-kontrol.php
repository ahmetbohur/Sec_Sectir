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
      <title><?PHP echo $site_isim; ?> | Giriş Yap</title>
    </head>
    <body>
      <?PHP   include_once "tema/bilesenler/ust_taraf.php"; ?>
      <div id='anasayfa_orta'>
        <div id='giris_orta_orta'>
          <h1><?PHP echo $site_isim; ?> | Giriş Yap</h1>
            <img src="<?PHP echo $site_logo; ?>"/>
      <?PHP
      if (empty($_POST["kadi"]) or empty($_POST["sifre"])) {
        echo "<span> Lütfen boş yer bırakmayın! <u><a href='$site_url/giris-yap'>Hesabınıza giriş yapmak için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde giriş sayfasına yönlendirileceksiniz.</span>";
        header('Refresh: 3; url='.$site_url.'/giris-yap');
      }else{
        echo "<span>";
          giris_yap($baglan, $site_url, mysqli_real_escape_string($baglan, htmlspecialchars($_POST["kadi"])), mysqli_real_escape_string($baglan, htmlspecialchars($_POST["sifre"])));
        echo "</span>";
      }

       ?>
      </div>
    </div>
    <?PHP include_once "tema/bilesenler/alt_taraf.php"; ?>
  </body>
</html>
