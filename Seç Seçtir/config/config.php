<?PHP
  // Debug Mode 1 kapalı 0 açık
  error_reporting(0);


  // Copyright ayarlari
  $site_acilis_tarihi = "2019";
  $site_simdiki_tarih = date("Y");

  $site_duyurulari = duyuru("",""); // Metin - Başlık

  // Site ayarları
  $etiket_limit = "20";
  $site_isim = "Seç Seçtir";
  $site_url = "http://localhost";
  $site_logo = "http://localhost/tema/Logo.jpg";
  $site_ico = "http://localhost/tema/ico.ico";
  $site_aciklama = "İki seçenek arasında kaldıysan ve bir çözüm yolu arıyorsan durma! Hemen hesap oluştur ve sende anketler ile sorularına cevap bul.";
  $site_hakkimizda = "Buraya hakkımızda yazısı gelecek.";
  $site_kullanim_kosullari = "Buraya kullanım koşulları yazısı gelecek";
  $site_footer_yazi = "<i class='far fa-copyright'></i> ". $site_acilis_tarihi . (($site_acilis_tarihi != $site_simdiki_tarih) ? " - ". $site_simdiki_tarih : '')." Seç Seçtir Tüm hakları saklıdır. || <b><a style='color: orange;' href='http://www.urhoba.com' target='_blank'>UrhobA Tech</a></b>";
  $site_reklam_dikey_kod = ""; // burası boş ise dikey reklamlar gözükmez.


  $mobil_link_tarama = $_SERVER["REQUEST_URI"];
  if(strstr($mobil_link_tarama , "/mobil")){
    $site_head_taglari = '
  <script type="text/javascript" src="'.$site_url.'/config/jquery-3.4.1.min.js"></script>
  <script src="'.$site_url.'/config/dynamic.js" type="text/javascript"></script>
  <link rel="shortcut icon" type="image/png" href="'.$site_ico.'"/>
  <base href="'.$site_url.'" />
  <meta charset="utf-8">
  <link href="'.$site_url.'/tema/mobil-style.css" type="text/css" rel="stylesheet" />
  <link href="'.$site_url.'/tema/fontawesome/css/all.css" rel="stylesheet">
  
  <script>
    function oy_kullan(anket,secenek) {

       $.get("oy_kullan.php", {anketno: anket, secenekno: secenek}, function (gelen_cevap3) {
        $(".oy_"+secenek+"-"+anket).html(gelen_cevap3);
       });
    }
 

   function begenveyabegenmejs(anket,islem) {

      $.get("begenveyabegenme.php", {anketno: anket, islemno: islem}, function (gelen_cevap2) {
        $(".begen"+islem+"-"+anket).html(gelen_cevap2);
      });
   }
 

 function takip_et_etme(getid,islem) {

    $.get("takip-et-etme.php", {takip_edilcek: getid, islemno: islem}, function (gelen_cevap1) {
      $(".takip").html(gelen_cevap1);
    });
 }

function bildirimleri_sil(){
  $.get("bildirim-sil.php", {}, function (gelen_cevap4) {
    $(".bildirimler_ic_goster").html(gelen_cevap4);
  });
}

 </script>

  ';
  }else{
    $site_head_taglari = '
    <script type="text/javascript" src="'.$site_url.'/config/jquery-3.4.1.min.js"></script>
    <script src="'.$site_url.'/config/dynamic.js" type="text/javascript"></script>
    <link rel="shortcut icon" type="image/png" href="'.$site_ico.'"/>
    <base href="'.$site_url.'" />
    <meta charset="utf-8">
    <link href="'.$site_url.'/tema/style.css" type="text/css" rel="stylesheet" />
    <link href="'.$site_url.'/tema/fontawesome/css/all.css" rel="stylesheet">
    
    <script>
      function oy_kullan(anket,secenek) {
  
         $.get("oy_kullan.php", {anketno: anket, secenekno: secenek}, function (gelen_cevap3) {
          $(".oy_"+secenek+"-"+anket).html(gelen_cevap3);
         });
      }
   
  
     function begenveyabegenmejs(anket,islem) {
  
        $.get("begenveyabegenme.php", {anketno: anket, islemno: islem}, function (gelen_cevap2) {
          $(".begen"+islem+"-"+anket).html(gelen_cevap2);
        });
     }
   
  
   function takip_et_etme(getid,islem) {
  
      $.get("takip-et-etme.php", {takip_edilcek: getid, islemno: islem}, function (gelen_cevap1) {
        $(".takip").html(gelen_cevap1);
      });
   }
  
  function bildirimleri_sil(){
    $.get("bildirim-sil.php", {}, function (gelen_cevap4) {
      $(".bildirimler_ic_goster").html(gelen_cevap4);
    });
  }
  
   </script>
  
    ';
  }

  
  // MYSQL Bağlantısı
  $host = "127.0.0.1";
  $user = "root";
  $pass = "";
  $database = "secsectir";

  $baglan = mysqli_connect($host, $user, $pass, $database);
  mysqli_query($baglan,"SET NAMES UTF-8");
  mysqli_query($baglan,"SET CHARSET utf8");

  if (!$baglan) {
    die("Bağlantı hatası: " . mysqli_connect_error($baglan));
  }


mobil_kontrol($site_url);

 ?>
