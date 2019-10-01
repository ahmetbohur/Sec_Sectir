<?php
include_once "config/fonksiyonlar.php";
if ($_SERVER['HTTP_REFERER'] == "") {
  exit("Giriş Yasak!");
}else{
 ?>
   <!DOCTYPE html>
   <html lang="tr" dir="ltr">
     <head>
       <?PHP echo $site_head_taglari; ?>
       <title><?PHP echo $site_isim; ?> | Anket gönder</title>

     </head>
     <body>
       <?PHP   include_once "tema/bilesenler/ust_taraf.php"; ?>
       <div id='anasayfa_orta'>
         <div id='giris_orta_orta'>
           <h1><?PHP echo $site_isim; ?> | Anket Gönder</h1>
             <img src="<?PHP echo $site_logo; ?>"/>
             <?PHP


            if (empty($_POST["aciklama"]) || empty($_POST["cevap1"]) || empty($_POST["cevap2"])) {
              echo "Boş yer bırakma";
            }else{
              $cevaplar = array(mysqli_real_escape_string($baglan, htmlspecialchars($_POST["cevap1"])), mysqli_real_escape_string($baglan, htmlspecialchars($_POST["cevap2"])) , mysqli_real_escape_string($baglan, htmlspecialchars($_POST["cevap3"])), mysqli_real_escape_string($baglan, htmlspecialchars($_POST["cevap4"])),mysqli_real_escape_string($baglan, htmlspecialchars($_POST["cevap5"])));
              $resimler = array(mysqli_real_escape_string($baglan, htmlspecialchars($_POST["cevapresim1"])), mysqli_real_escape_string($baglan, htmlspecialchars($_POST["cevapresim2"])) , mysqli_real_escape_string($baglan, htmlspecialchars($_POST["cevapresim3"])), mysqli_real_escape_string($baglan, htmlspecialchars($_POST["cevapresim4"])),mysqli_real_escape_string($baglan, htmlspecialchars($_POST["cevapresim5"])));
              $aciklama = mysqli_real_escape_string($baglan, htmlspecialchars($_POST["aciklama"]));
              $video = mysqli_real_escape_string($baglan, htmlspecialchars($_POST["video"]));
              $yuklenen_resimler = array($_FILES['img_file1'],$_FILES['img_file2'],$_FILES['img_file3'],$_FILES['img_file4'],$_FILES['img_file5']);
              $upload = mysqli_real_escape_string($baglan, htmlspecialchars($_POST["upload"]));
              if (empty($_POST["etiket"])) {
                $etiket = "genel";
              }else{
                $etiket = mysqli_real_escape_string($baglan, htmlspecialchars($_POST["etiket"]));
              }

              anket_gonder($baglan, $site_url ,$cevaplar, $resimler, $aciklama, $video, $_SESSION["kadi"], $_SESSION["id"], $etiket, $upload, $yuklenen_resimler);

            }

              ?>
         </div>
       </div>
       <?PHP include_once "tema/bilesenler/alt_taraf.php"; ?>
     </body>
   </html>
<?PHP } ?>
