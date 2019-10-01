<?php
include_once "config/fonksiyonlar.php";
 ?>
   <!DOCTYPE html>
   <html lang="tr" dir="ltr">
     <head>
       <?PHP echo $site_head_taglari; ?>
       <title><?PHP echo $site_isim; ?> | <?PHP if (empty($_GET["kadi"])) { echo "Profil"; }else{echo $_GET["kadi"];} ?></title>

     </head>
     <body>
       <?PHP   include_once "tema/bilesenler/ust_taraf.php"; ?>
       <?PHP if (empty($_GET["kadi"]) or !kullanici_varmi_kontrol($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"])))) {
         ?><div id='anasayfa_orta'>
           <div id='giris_orta_orta'>
             <h1><?PHP echo $site_isim; ?> | Profil</h1>
               <img src="<?PHP echo $site_logo; ?>"/>
               <?PHP
               echo "<span>Şu anda boş veya daha oluşturulmamış bir profil girmeye çalışıyorsun. Bu yüzden sana herhangi bir sonuç gösteremiyoruz! <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
               echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.</span>";
               header('Refresh: 3; url='.$site_url.'');
                ?>
             </div>
           </div>
      <?PHP }else{
        if (empty($_SESSION["kadi"]) or empty($_SESSION["id"])) {
          // Giriş yapmamış kullanıcı // başkasının profili
          ?>
          <div id='anasayfa_orta'>
            <div id='profil_orta_orta'>
              <div id='profil_ust'>
                <div id='profil_ust_kapak_foto'>
                  <img id='profil_kapak_foto' src='<?PHP echo kapak_resmi_cek($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"]))); ?>'/>
                </div>
                <div id='profil_ust_profil_foto'>
                  <img id='profil_profil_foto' src='<?PHP echo profil_resmi_cek($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"]))); ?>'/>
                </div>
                <div id='profil_ust_kullanici_adi'>
                  <h2 id='profil_kullanici_adi_h2'><?PHP echo $_GET["kadi"]; ?></h2>
                  <span id='profil_kullanici_adi_span'><?PHP echo profil_ad_soyad_cek($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"]))); ?></span>
                </div>
              </div>
              <div id='profil_sol_genel'>
                <div id='profil_kullanici_bilgileri'>
                  <?PHP echo profil_kullanici_bilgileri_cek($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"]))); ?>
                </div>
                <?PHP reklam($site_reklam_dikey_kod); ?>
              </div>
              <div id='profil_sag_genel'>
                <?PHP anket_gonderileri_profil($baglan , $site_url, $site_isim, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"])), $_SESSION["id"], $_SESSION["kadi"],mysqli_real_escape_string($baglan, htmlspecialchars($_GET["sayfa"]))); ?>
              </div>
            </div>
          </div>
          <?PHP
        }else{
          if ($_GET["kadi"] == $_SESSION["kadi"]) {
            // kendi profili
            ?>
            <div id='anasayfa_orta'>
              <div id='profil_orta_orta'>
                <div id='profil_ust'>
                  <div id='profil_ust_kapak_foto'>
                    <img id='profil_kapak_foto' src='<?PHP echo kapak_resmi_cek($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"]))); ?>'/>
                  </div>
                  <div id='profil_ust_profil_foto'>
                    <img id='profil_profil_foto' src='<?PHP echo profil_resmi_cek($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"]))); ?>'/>
                  </div>
                  <div id='profil_ust_kullanici_adi'>
                    <h2 id='profil_kullanici_adi_h2'><?PHP echo $_GET["kadi"]; ?></h2>
                    <span id='profil_kullanici_adi_span'><?PHP echo profil_ad_soyad_cek($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"]))); ?></span>
                  </div>
                </div>
                <div id='profil_sol_genel'>
                  <div id='profil_kullanici_bilgileri'>
                    <?PHP echo profil_kullanici_bilgileri_cek($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"]))); ?>
                  </div>
                  <?PHP reklam($site_reklam_dikey_kod); ?>
                </div>
                <div id='profil_sag_genel'>
                  <?PHP
                  if (profil_hesap_aktifmi($baglan, $_SESSION["kadi"])) {?>
                    <div id='anket_olustur' style="height: 43.2px;">
                      <h3 onclick="anket_olustur_genislet()"><i class="fa fa-poll"></i> Hemen Anket Oluştur</h3>
                      <form method="POST" action="anket-gonder" enctype="multipart/form-data">
                        <textarea name="aciklama" placeholder="Anket sorunuzu buraya yazın"></textarea>
                        <h4>Etiket</h4>
                        <input type="text" name="etiket" placeholder="Örneğin: negiysem"/>
                        <h4>Cevaplar</h4>
                        <input name="cevap1" type="text" placeholder="Cevap 1"/>
                        <input name="cevap2" type="text" placeholder="Cevap 2"/>
                        <input class="anket_olustur_cevap" name="cevap3" type="text" placeholder="Cevap 3" style="display: none"/>
                        <input class="anket_olustur_cevap" name="cevap4" type="text" placeholder="Cevap 4" style="display: none"/>
                        <input class="anket_olustur_cevap" name="cevap5" type="text" placeholder="Cevap 5" style="display: none"/>
                        <h4>Cevaplardaki resimler</h4>
                        <input class="anket_olustur_cevap_resim" name="cevapresim1" type="text" placeholder="Cevap 1 Resim URL"/>
                        <input class="anket_olustur_cevap_resim" name="cevapresim2" type="text" placeholder="Cevap 2 Resim URL"/>
                        <input class="anket_olustur_cevap_resim" name="cevapresim3" type="text" placeholder="Cevap 3 Resim URL" style="display: none"/>
                        <input class="anket_olustur_cevap_resim" name="cevapresim4" type="text" placeholder="Cevap 4 Resim URL" style="display: none"/>
                        <input class="anket_olustur_cevap_resim" name="cevapresim5" type="text" placeholder="Cevap 5 Resim URL" style="display: none"/>

                        <input type="file" class="img_file_input" name="img_file1" style="display: none;">
                        <input type="file" class="img_file_input" name="img_file2" style="display: none;">
                        <input type="file" class="img_file_input" name="img_file3" style="display: none;">
                        <input type="file" class="img_file_input" name="img_file4" style="display: none;">
                        <input type="file" class="img_file_input" name="img_file5" style="display: none;">

                        <button>Anket Oluştur</button>
                        <div title="Video" id='anket_olustur_video' onclick="cevap_video_yap()"><i id="cevap_video_yap" class="fa fa-video"><input id="cevap_video_yap_int" type="hidden" name='video' value='0'></i></div>
                        <div title="Seçenek ekle" id='anket_olustur_ekle' onclick="cevap_secenek_ekle()"><i id="cevap_secenek_ekle_cikart" class="fa fa-plus"></i></div>
                        <div title="Bilgisayar'dan resim yükle" id='anket_olustur_yukle' onclick="resim_upload()"><i id="upload_gorsel" class="fa fa-upload"><input id="cevap_resim_yukle" type="hidden" name='upload' value='0'></i></div>
                      </form>
                    </div>
                    <?PHP
                  }else{
                    echo "<div id='anket_olustur'>";
                    echo "<div id='anket_paylasilmamis_profil' >Hesabın aktif değil bu yüzden şu anda anket paylaşamazsın! <br> <a href='$site_url/onay-maili-gonder'> <u>Buraya</u></a> tıklayıp yeniden onay maili gönderebilirsin.</div>";
                    echo "</div>";
                  }

                   ?>

                  <?PHP anket_gonderileri_profil($baglan , $site_url, $site_isim, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"])), $_SESSION["id"], $_SESSION["kadi"], mysqli_real_escape_string($baglan, htmlspecialchars($_GET["sayfa"]))); ?>
                </div>
              </div>
            </div>
            <?PHP
          }else{
            // başkasının profili
          ?>
          <div id='anasayfa_orta'>
            <div id='profil_orta_orta'>
              <div id='profil_ust'>
                <div id='profil_ust_kapak_foto'>
                  <img id='profil_kapak_foto' src='<?PHP echo kapak_resmi_cek($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"]))); ?>'/>
                </div>
                <div id='profil_ust_profil_foto'>
                  <img id='profil_profil_foto' src='<?PHP echo profil_resmi_cek($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"]))); ?>'/>
                </div>
                <div id='profil_ust_kullanici_adi'>
                  <h2 id='profil_kullanici_adi_h2'><?PHP echo $_GET["kadi"]; ?></h2>
                  <span id='profil_kullanici_adi_span'><?PHP echo profil_ad_soyad_cek($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"]))); ?></span>
                </div>
              </div>
              <div id='profil_sol_genel'>
                <div id='profil_kullanici_bilgileri'>
                <?PHP if(!empty($_SESSION["kadi"]) AND !empty($_SESSION["id"])){ takipet_takipbirak_button($baglan,$_SESSION["kadi"],$_SESSION["id"],mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"]))); } ?>
                <?PHP echo profil_kullanici_bilgileri_cek($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"]))); ?>
                </div>
                <?PHP reklam($site_reklam_dikey_kod); ?>
              </div>
              <div id='profil_sag_genel'>
                <?PHP anket_gonderileri_profil($baglan , $site_url, $site_isim, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["kadi"])), $_SESSION["id"], $_SESSION["kadi"],mysqli_real_escape_string($baglan, htmlspecialchars($_GET["sayfa"]))); ?>
              </div>
            </div>
          </div>

          <?PHP
          }
        }
      } ?>
         <?PHP include_once "tema/bilesenler/alt_taraf.php"; ?>
       </body>
     </html>
