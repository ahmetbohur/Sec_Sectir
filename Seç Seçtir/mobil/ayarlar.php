<?php
include_once "../config/fonksiyonlar.php";
 ?>
 <!DOCTYPE html>
 <html lang="tr" dir="ltr">
   <head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <?PHP echo $site_head_taglari; ?>
     <title><?PHP echo $site_isim; ?> | Ayarlar</title>
   </head>
   <body>
     <?PHP
     if(empty($_SESSION["kadi"]) or empty($_SESSION["id"])){
         header("Location: $site_url");
         exit("Giriş yasak!");
     }else{
       include_once "../tema/bilesenler/ust_taraf.php"
       ?>
       <div id='mobil_anasayfa_orta'>
         <div id='ayarlar_orta_orta'>
           <h1><?PHP echo $_SESSION["kadi"]; ?> <i class="fa fa-cog"></i> Ayarlar</h1>
             <img src="<?PHP echo profil_resmi_cek($baglan, $_SESSION["kadi"]); ?>"/>
           <form method="post" action="ayarlar-kontrol" enctype="multipart/form-data">
             <?PHP
             $ayarlar_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='".$_SESSION["kadi"]."'";
             if ($ayarlar_baglan = mysqli_query($baglan, $ayarlar_sql)) {
               $veri_cek = mysqli_fetch_array($ayarlar_baglan);
               echo '<div id="ayarlar_inputlar"><i class="fas fa-signature"></i> <input name="ad" type="text" value="'.$veri_cek["ad"].'"/></div>';
                echo '<div id="ayarlar_inputlar"><i class="fas fa-signature"></i> <input name="soyad" type="text" value="'.$veri_cek["soyad"].'"/></div>';
                 echo '<div id="ayarlar_inputlar"><i class="fas fa-envelope"></i> <input name="mail" type="text" value="'.$veri_cek["mail"].'"/></div>';
                  echo '<div id="ayarlar_inputlar"><i class="fas fa-portrait"></i> <input class="ppupinput" name="pp" type="text" value="'.$veri_cek["profil_foto"].'"/></div>';
                  echo '<div id="ayarlar_inputlar"><i class="fas fa-upload"></i> <div onclick="resim_upload_pp_ayarlar()" class="ppupbuton" id="ayarlar_bilgisayardan_yukle">Cihazdan profil fotografı yüklemek için tıklayın.</div> <input class="uploadpp" name="pp_upload" style="display:none;" type="file"/></div>';
                 
                  echo '<div id="ayarlar_inputlar"><i class="fas fa-image"></i> <input name="kp" type="text" value="'.$veri_cek["kapak_foto"].'" class="kpupinput"/></div>';
                  echo '<div id="ayarlar_inputlar"><i class="fas fa-upload"></i> <div onclick="resim_upload_kp_ayarlar()" class="kpupbuton" id="ayarlar_bilgisayardan_yukle">Cihazdan kapak fotografı yüklemek için tıklayın.</div> <input class="uploadkp" name="kp_upload" style="display:none;" type="file"/></div>';
                 
                  echo '<div id="ayarlar_inputlar"><i class="fas fa-birthday-cake"></i> <input name="dogumt" type="date" value="'.$veri_cek["dogum_tarihi"].'"/></div>';
                     echo '<div id="ayarlar_inputlar"><i class="fas fa-address-card"></i> <textarea name="hakkimda">'.$veri_cek["hakkinda"].'</textarea></div>';
                
                    }

              ?>
              <div id="ayarlar_inputlar"><i class="fas fa-key"></i> <input name="sifre" type="password" value="" placeholder="Değişmesini istemiyorsan dokunma"/></div>
             <span><i class="fas fa-exclamation-triangle"></i> Değişmesini istemediğiniz yerlere lütfen dokunmayın!</span>
             <button>Bilgileri güncelle</button>
           </form>
         </div>
       </div>
       <?PHP
         include_once "../tema/bilesenler/alt_taraf.php";
     }

      ?>

   </body>
 </html>
