<?PHP
include_once "config/fonksiyonlar.php";
    if(empty($_GET["etiket"])){
        header('Refresh: 0; url='.$site_url.'');
        exit("Giriş yasak!");
    }
 ?>
 <!DOCTYPE html>
 <html lang="tr" dir="ltr">
   <head>
     <?PHP echo $site_head_taglari; ?>
     <title><?PHP echo $site_isim." | ". $_GET["etiket"] ; ?></title>
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
            <div id='anasayfa_giris_sol_genel'>
            <div id='anasayfa_giris_etiketler'>
              <h3>Gündemdeki etiketler</h3>
              <span><?PHP echo anasayfa_etiket_cek($baglan, $site_url, $etiket_limit); ?></span>
            </div>  
            <?PHP reklam($site_reklam_dikey_kod); ?>
            </div>

            <div id='anasayfa_giris_sag_genel'>
            <?PHP anket_gonderileri_etiket($baglan, $site_url, $site_isim, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["sayfa"])), mysqli_real_escape_string($baglan, htmlspecialchars($_GET["etiket"]))); ?>
            </div>

          </div>
        </div>
        <?php
    include_once "tema/bilesenler/alt_taraf.php";
    ?>
    </body>
    </html>



