<?PHP
include_once "config/fonksiyonlar.php";
 ?>
   <!DOCTYPE html>
   <html lang="tr" dir="ltr">
     <head>
       <?PHP echo $site_head_taglari; ?>
       <title><?PHP echo $site_isim; ?> | Hesap Onayla</title>
     </head>
     <body>
       <?PHP   include_once "tema/bilesenler/ust_taraf.php"; ?>
       <div id='anasayfa_orta'>
         <div id='giris_orta_orta'>
           <h1><?PHP echo $site_isim; ?> | Hesap Onayla</h1>
             <img src="<?PHP echo $site_logo; ?>"/>
       <?PHP
       if (empty($_GET["kadi"]) or empty($_GET["kontrol"])) {
         echo "<span>Lütfen buraya direkt giriş yapmaya çalışmayın <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
         echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.</span>";
         header('Refresh: 3; url='.$site_url.'');
       }else{
         echo "<span>";
          hesap_onayla($baglan, $site_url, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"])) , mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kontrol"])));
         echo "</span>";
       }

        ?>
       </div>
     </div>
     <?PHP include_once "tema/bilesenler/alt_taraf.php"; ?>
   </body>
 </html>
