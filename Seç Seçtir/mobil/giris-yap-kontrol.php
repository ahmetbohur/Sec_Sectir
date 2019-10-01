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
      <title><?PHP echo $site_isim; ?> | Giriş Yap</title>
    </head>
    <body>
      <div id='mobil_anasayfa_orta'>
        <div id='giris_orta_orta'>
          <h1><?PHP echo $site_isim; ?> <br> Giriş Yap</h1>
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
       <a title="Anasayfa" href="mobil/anasayfa" id="sifremi_unuttum_button"><i class="fa fa-home"></i> Anasayfa</a>
      </div>
      
    </div>
    <?PHP include_once "../tema/bilesenler/alt_taraf.php"; ?>
  </body>
</html>
