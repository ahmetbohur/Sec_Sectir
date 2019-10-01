<?PHP
include_once "../config/fonksiyonlar.php";
if ($_SERVER['HTTP_REFERER'] == "") {
  header('Refresh: 0; url='.$site_url.'');
  exit("Direkt giriş yasak!");
}
?>
  <!DOCTYPE html>
  <html lang="tr" dir="ltr">
    <head>
      <?PHP echo $site_head_taglari; ?>
      <title><?PHP echo $site_isim; ?> | Onay Maili Yeniden Gönder</title>
    </head>
    <body>
      <?PHP   include_once "../tema/bilesenler/ust_taraf.php"; ?>
      <div id='mobil_anasayfa_orta'>
        <div id='giris_orta_orta'>
          <h1><?PHP echo $site_isim; ?> <br> Onay Maili Yeniden Gönder</h1>
            <img src="<?PHP echo $site_logo; ?>"/>
      <?PHP
      if (empty($_SESSION["kadi"]) OR empty($_SESSION["id"])) {
        echo "<span> Lütfen ilk olarak kullanıcı girişi yapın! <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.</span>";
        header('Refresh: 3; url='.$site_url.'');
      }else{
        echo "<span>";
         if(date('H:i:s') > $_SESSION["mail_onay_time_son"]){ 
          onay_maili_tekrar($baglan, $site_url, $site_logo, $site_isim, $_SESSION["kadi"], $_SESSION["id"]);   
         }else{
            echo "2 dakikada 1 onay maili gönderebilirsin! <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";  
            echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.</span>";
            header('Refresh: 3; url='.$site_url.''); 
         }
        echo "</span>";
      }

       ?>
      </div>
    </div>
    <?PHP include_once "../tema/bilesenler/alt_taraf.php"; ?>
  </body>
</html>
