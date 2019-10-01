<?PHP
include_once "config/fonksiyonlar.php";
if ($_SERVER['HTTP_REFERER'] == "" OR empty($_SESSION["kadi"]) OR empty($_SESSION["id"])) {
  header('Refresh: 0; url='.$site_url.'');
  exit("Direkt giriş yasak!");
}
?>
  <!DOCTYPE html>
  <html lang="tr" dir="ltr">
    <head>
      <?PHP echo $site_head_taglari; ?>
      <title><?PHP echo $site_isim; ?> | Bilgilerimi Güncelle</title>
    </head>
    <body>
      <?PHP   include_once "tema/bilesenler/ust_taraf.php"; ?>
      <div id='anasayfa_orta'>
        <div id='giris_orta_orta'>
          <h1><?PHP echo $site_isim; ?> | Bilgilerimi Güncelle</h1>
            <img src="<?PHP echo $site_logo; ?>"/>
      <?PHP
      if (empty($_POST["ad"]) OR empty($_POST["soyad"]) OR empty($_POST["mail"]) OR empty($_POST["pp"]) OR empty($_POST["kp"]) OR empty($_POST["dogumt"]) OR empty($_POST["hakkimda"])) {
        echo "<span> Lütfen boş yer bırakmayın! <u><a href='$site_url/'> <u>Anasayfaya</u> gitmek için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.</span>";
        header('Refresh: 3; url='.$site_url.'/');
      }else{
        echo "<span>";

        profil_bilgilerini_guncelle($site_url,$baglan,$_SESSION["kadi"], $_SESSION["id"], mysqli_real_escape_string($baglan, htmlspecialchars($_POST["ad"])),mysqli_real_escape_string($baglan, htmlspecialchars($_POST["soyad"])),mysqli_real_escape_string($baglan, htmlspecialchars($_POST["mail"])),mysqli_real_escape_string($baglan, htmlspecialchars($_POST["pp"])),mysqli_real_escape_string($baglan, htmlspecialchars($_POST["kp"])),mysqli_real_escape_string($baglan, htmlspecialchars($_POST["dogumt"])),mysqli_real_escape_string($baglan, htmlspecialchars($_POST["hakkimda"])),mysqli_real_escape_string($baglan, htmlspecialchars($_POST["sifre"])),$_FILES["pp_upload"], $_FILES["kp_upload"]);
        echo "</span>";
      }

       ?>
      </div>
    </div>
    <?PHP include_once "tema/bilesenler/alt_taraf.php"; ?>
  </body>
</html>
