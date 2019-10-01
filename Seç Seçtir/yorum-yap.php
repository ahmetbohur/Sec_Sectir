<?PHP
include_once "config/fonksiyonlar.php";
if ($_SERVER['HTTP_REFERER'] == "" OR empty($_SESSION["kadi"] OR empty($_SESSION["id"]))) {
  header('Refresh: 0; url='.$site_url.'');
  exit("Direkt giriş yasak!");
}
?>
  <!DOCTYPE html>
  <html lang="tr" dir="ltr">
    <head>
    <?PHP echo $site_head_taglari; ?>
      <title><?PHP echo $site_isim; ?> | Yorum Yap</title>
    </head>
    <body>
      <?PHP   include_once "tema/bilesenler/ust_taraf.php"; ?>
      <div id='anasayfa_orta'>
        <div id='giris_orta_orta'>
          <h1><?PHP echo $site_isim; ?> | Yorum Yap</h1>
            <img src="<?PHP echo $site_logo; ?>"/>
      <?PHP
      if (empty($_POST["yorum"]) OR empty($_POST["anket_id"])) {
        echo "<span> Lütfen boş yorum yapmayın! <u><a href='".htmlspecialchars($_SERVER['HTTP_REFERER'])."'>Geldiğiniz ankete geri gitmek için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde önceki sayfaya yönlendirileceksiniz.</span>";
        header('Refresh: 3; url='.htmlspecialchars($_SERVER['HTTP_REFERER']).'');
      }else{
        echo "<span>";
        anket_yorum_yap($baglan, $site_url, $site_isim, mysqli_real_escape_string($baglan,htmlspecialchars($_POST["anket_id"])),mysqli_real_escape_string($baglan,htmlspecialchars($_POST["yorum"])), $_SESSION["kadi"], $_SESSION["id"]);
        echo "</span>";
      }

       ?>
      </div>
    </div>
    <?PHP include_once "tema/bilesenler/alt_taraf.php"; ?>
  </body>
</html>
