<?php
include_once "config/fonksiyonlar.php";
 ?>
 <!DOCTYPE html>
 <html lang="tr" dir="ltr">
   <head>
     <?PHP echo $site_head_taglari; ?>
     <title><?PHP echo $site_isim; ?></title>
   </head>
   <body>
    <?php
    include_once "tema/bilesenler/ust_taraf.php";
    if (empty($session_kadi) OR empty($session_id)) {
      // Giriş yapılmamış
      ?>
      <div id='anasayfa_orta'>
        <div id='anasayfa_orta_orta'>
          <h1><?PHP echo $site_isim; ?></h1>
          <img src="<?PHP echo $site_logo; ?>"/>
          <span><?PHP echo $site_aciklama; ?></span>
          <a title="Hesap oluştur" id="anasayfa_hesap_ac_button" href="hesap-olustur">Hesap oluştur</a>
          <a title="Giriş yap" id="anasayfa_giris_yap_button" href="giris-yap">Giriş yap</a>
        </div>
      </div>
      <?PHP

    }else{
      // Giriş yapılmış
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
            <div id="anket_gonderileri_profil" style="top: -10px;"><div id="anket_paylasilmamis_profil" style='text-align:center;'><a id="anasayfa_takip_genel_secim" title="Takip edilenlerin anketleri" href="<?PHP echo $site_url; ?>/anasayfa/t/1">Takip Edilenler</a> | <a id="anasayfa_takip_genel_secim" title="Son anketler" href="<?PHP echo $site_url; ?>/anasayfa/g/1">Son Anketler</a></div></div>
            <?PHP anket_gonderileri_anasayfa($baglan, $site_url, $site_isim, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["sayfa"])), mysqli_real_escape_string($baglan, htmlspecialchars($_GET["durum"])),$_SESSION["kadi"], $_SESSION["id"]); ?>
            </div>

          </div>
        </div>
      <?PHP
    }
    include_once "tema/bilesenler/alt_taraf.php";
     ?>
   </body>
 </html>
