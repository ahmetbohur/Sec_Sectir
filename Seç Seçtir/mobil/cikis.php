<?PHP
include_once "../config/fonksiyonlar.php";
session_destroy();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?PHP echo $site_isim; ?> | Çıkış</title>
    <?PHP echo $site_head_taglari; ?>
</head>
<body>
  <div id='mobil_anasayfa_orta'>
        <div id='giris_orta_orta'>
        <h1><?PHP echo $site_isim; ?> <br> Çıkış</h1>
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
<?PHP
include_once "../tema/bilesenler/alt_taraf.php";
?>

</body>
</html>