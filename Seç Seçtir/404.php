<?PHP
include_once "config/fonksiyonlar.php";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?PHP echo $site_isim; ?> | 404</title>
    <?PHP echo $site_head_taglari; ?>
</head>
<body>
  <div id='mobil_anasayfa_orta'>
        <div id='mobil_anasayfa_orta_orta'>
        <h1><?PHP echo $site_isim; ?> <br> 404</h1>
         <img src="<?PHP echo $site_logo; ?>"/>
         <span><h3>404 - Aradığınız sayfa bulunamadı!</h3></span>
         <?PHP
          $mobil_link_tarama = $_SERVER["REQUEST_URI"];
          if(strstr($mobil_link_tarama , "/mobil")){ ?>
          <span>Aradığınız sayfa mobil uyumlu olmayabilir.</span>
         <a title="Anasayfa" href="mobil/anasayfa"><i class="fa fa-home"></i> Anasayfa</a>
          <?PHP }else{

          ?>
           <a title="Anasayfa" href="/anasayfa"><i class="fa fa-home"></i> Anasayfa</a>
          <?PHP } ?>
         </div>
  </div>
<?PHP
include_once "tema/bilesenler/alt_taraf.php";
?>

</body>
</html>
