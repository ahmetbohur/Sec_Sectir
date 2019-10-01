<?PHP
session_start();
session_destroy();
include_once "config/fonksiyonlar.php";
 ?>
   <!DOCTYPE html>
   <html lang="tr" dir="ltr">
     <head>
       <?PHP echo $site_head_taglari; ?>
       <title><?PHP echo $site_isim; ?> | Çıkış Yap</title>
     </head>
     <body>
       <?PHP   include_once "tema/bilesenler/ust_taraf.php"; ?>
       <div id='anasayfa_orta'>
         <div id='giris_orta_orta'>
           <h1><?PHP echo $site_isim; ?> | Çıkış Yap</h1>
             <img src="<?PHP echo $site_logo; ?>"/>
       <?PHP
         if (empty($_SESSION["kadi"]) AND empty($_SESSION["id"])) {
           echo "<span>Hesabınızdan başarı ile çıkış yapıldı. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
           echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.</span>";
           header('Refresh: 3; url='.$site_url.'');
         }else{
           echo "<span>Hesabınızdan başarı ile çıkış yapıldı. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
           echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.</span>";
           header('Refresh: 3; url='.$site_url.'');
         }
        ?>
       </div>
     </div>
     <?PHP include_once "tema/bilesenler/alt_taraf.php"; ?>
   </body>
 </html>
