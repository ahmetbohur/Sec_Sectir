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
      <title><?PHP echo $site_isim; ?> | Hesap Oluştur</title>
    </head>
    <body>
    <div id='mobil_anasayfa_orta'>
        <div id='giris_orta_orta'>
          <h1><?PHP echo $site_isim; ?> <br> Hesap Oluştur</h1>
            <img src="<?PHP echo $site_logo; ?>"/>
      <?PHP
      if (empty($_POST["kadi"]) or empty($_POST["ad"]) or empty($_POST["sad"]) or empty($_POST["mail"]) or empty($_POST["sifre"])) {
        echo "<span> Lütfen boş yer bırakmayın! <u><a href='$site_url/hesap-olustur'>Hesap açmak için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde hesap oluşturma sayfasına yönlendirileceksiniz.</span>";
        header('Refresh: 3; url='.$site_url.'/hesap-olustur');
      }else{
        echo "<span>";
        hesap_olustur($baglan, $site_url, $site_isim, $site_logo, mysqli_real_escape_string($baglan,htmlspecialchars($_POST["kadi"])) , mysqli_real_escape_string($baglan,htmlspecialchars($_POST["ad"])) , mysqli_real_escape_string($baglan,htmlspecialchars($_POST["sad"])) , mysqli_real_escape_string($baglan,htmlspecialchars($_POST["mail"])) , mysqli_real_escape_string($baglan,htmlspecialchars($_POST["sifre"])), GetIP());
        echo "</span>";
      }

       ?>
       <a title="Anasayfa" href="mobil/anasayfa" id="sifremi_unuttum_button"><i class="fa fa-home"></i> Anasayfa</a>
      </div>
      
    </div>
    <?PHP include_once "../tema/bilesenler/alt_taraf.php"; ?>
  </body>
</html>
