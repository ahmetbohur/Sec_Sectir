<?PHP
include_once "config/fonksiyonlar.php";
    if(empty($_GET["ara"])){
        header('Refresh: 0; url='.$site_url.'');
        exit("Giriş yasak!");
    }
 ?>
 <!DOCTYPE html>
 <html lang="tr" dir="ltr">
   <head>
     <?PHP echo $site_head_taglari; ?>
     <title><?PHP echo $site_isim." | ". $_GET["ara"]; ?></title>
   </head>
   <body>
    <?php
    include_once "tema/bilesenler/ust_taraf.php";
        ?>
       <div id='anasayfa_orta'>
          <div id='anasayfa_giris_orta_orta'>
            <!-- Duyuru olursa çıkacak yer -->
            <?PHP echo $site_duyurulari; ?>
            <!-- Duyuru olursa çıkacak yer -->

            <div id='arama_sonuclari'>
            <?PHP ara_sonuclari_cek($baglan, $site_url, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["ara"])), mysqli_real_escape_string($baglan, htmlspecialchars($_GET["sayfa"]))); ?>
            </div>

          </div>
        </div>
        <?php
    include_once "tema/bilesenler/alt_taraf.php";
    ?>
    </body>
    </html>



