<?PHP
include_once "../config/fonksiyonlar.php";
    if(empty($_GET["anket_no"])){
        header('Refresh: 0; url='.$site_url.'');
        exit("Giriş yasak!");
    }
 ?>
 <!DOCTYPE html>
 <html lang="tr" dir="ltr">
   <head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <?PHP echo $site_head_taglari; ?>
     <title><?PHP echo $site_isim." | Anket ". $_GET["anket_no"] ; ?></title>
   </head>
   <body>
    <?php
    include_once "../tema/bilesenler/ust_taraf.php";
        ?>
       <div id='mobil_anasayfa_orta'>
          <div id='anasayfa_giris_orta_orta'>
            <!-- Duyuru olursa çıkacak yer -->
            <?PHP echo $site_duyurulari; ?>
            <!-- Duyuru olursa çıkacak yer -->
            <div id='anasayfa_giris_sag_genel'>
            <div id='anasayfa_giris_etiketler'>
              <h3>Gündemdeki etiketler</h3>
              <span><?PHP echo anasayfa_etiket_cek($baglan, $site_url, $etiket_limit); ?></span>
            </div>  
            <?PHP reklam($site_reklam_dikey_kod); ?>
            </div>

            <div id='anasayfa_giris_sag_genel'>
                <?PHP anket_gonderileri_solo_anket($baglan, $site_url, $site_isim, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["sayfa"])), mysqli_real_escape_string($baglan, htmlspecialchars($_GET["anket_no"])), $_SESSION["kadi"]); ?>
            </div>

          </div>
        </div>
        <?php
    include_once "../tema/bilesenler/alt_taraf.php";
    ?>
    </body>
    </html>



