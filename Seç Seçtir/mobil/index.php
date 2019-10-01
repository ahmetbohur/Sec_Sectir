<?PHP
include_once "../config/fonksiyonlar.php";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?PHP echo $site_isim; ?></title>
    <?PHP echo $site_head_taglari; ?>
</head>
<body>
<?PHP

if(empty($_SESSION["kadi"]) OR empty($_SESSION["id"])){
?>
  <div id='mobil_anasayfa_orta'>
        <div id='mobil_anasayfa_orta_orta'>
          <h1><?PHP echo $site_isim; ?></h1>
          <img src="<?PHP echo $site_logo; ?>"/>
          <span><?PHP echo $site_aciklama; ?></span>
          <a title="Hesap oluştur" id="mobil_anasayfa_hesap_ac_button" href="/mobil/hesap-olustur">Hesap oluştur</a>
          <a title="Giriş yap" id="mobil_anasayfa_giris_yap_button" href="/mobil/giris-yap">Giriş yap</a>
          <a title="Hakkımızda" href="/mobil/hakkimizda"><i class="fa fa-address-card"></i> Hakkımızda</a>
          <a title="Kullanım Koşulları" href="/mobil/kullanim-kosullari"><i class="fa fa-book"></i> Kullanım koşulları</a>
        </div>
  </div>
<?PHP
}else{
?>
 <div id='mobil_anasayfa_orta'>
   <?PHP    include_once "../tema/bilesenler/ust_taraf.php"; ?>
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
            <div id="anket_gonderileri_profil" style="top: -10px;"><div id="anket_paylasilmamis_profil" style='text-align:center;'><a id="anasayfa_takip_genel_secim" title="Takip edilenlerin anketleri" href="<?PHP echo $site_url; ?>/mobil/anasayfa/t/1">Takip Edilenler</a> | <a id="anasayfa_takip_genel_secim" title="Son anketler" href="<?PHP echo $site_url; ?>/mobil/anasayfa/g/1">Son Anketler</a></div></div>
            <?PHP anket_gonderileri_anasayfa($baglan, $site_url, $site_isim, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["sayfa"])), mysqli_real_escape_string($baglan, htmlspecialchars($_GET["durum"])),$_SESSION["kadi"], $_SESSION["id"]); ?>
             
          </div>

          </div>
        </div>

<?PHP
}

include_once "../tema/bilesenler/alt_taraf.php";
?>

</body>
</html>