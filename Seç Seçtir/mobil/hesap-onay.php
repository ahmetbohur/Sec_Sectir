<?PHP
include_once "../config/fonksiyonlar.php";
 ?>
   <!DOCTYPE html>
   <html lang="tr" dir="ltr">
     <head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
       <?PHP echo $site_head_taglari; ?>
       <title><?PHP echo $site_isim; ?> | Hesap Onayla</title>
     </head>
     <body>
       <div id='mobil_anasayfa_orta'>
         <div id='giris_orta_orta'>
           <h1><?PHP echo $site_isim; ?> <br> Hesap Onayla</h1>
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
        <a title="Anasayfa" href="mobil/anasayfa" id="sifremi_unuttum_button"><i class="fa fa-home"></i> Anasayfa</a>
       </div>
     </div>
     <?PHP include_once "../tema/bilesenler/alt_taraf.php"; ?>
   </body>
 </html>
