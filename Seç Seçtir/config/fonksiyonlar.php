<?php
session_start();
include_once "config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!empty($_SESSION["kadi"]) OR !empty($_SESSION["id"])) {
  $session_kadi = mysqli_real_escape_string($baglan, $_SESSION["kadi"]);
  $session_id = mysqli_real_escape_string($baglan, $_SESSION["id"]);
}

if(empty($_SESSION["mail_onay_time_son"])){
  $_SESSION["mail_onay_time_son"] = date('H:i:s', time() - 10);
}


function reklam($reklam_kodu){
 if(empty($reklam_kodu)){

 }else{
  echo "<div id='reklam_dikey'>
  <div id='reklam_baslik'><i class='fa fa-ad'></i> Reklam</div>
  <div id='reklam_dikey_icerik'>$reklam_kodu</div>
  </div>";
 }
}


function duyuru($metin,$baslik){
  $a = '<div id="anasayfa_giris_ust_ust">
  <h3><i class="fa fa-exclamation-triangle"></i> '.$baslik.' <i class="fa fa-exclamation-triangle"></i></h3>
  <span>'.$metin.'</span>
  </div>';
  if(empty($metin) or empty($baslik)){

  }else{
    return $a;
  }
}

function tarih_duzenle($tarih){
    $yeni_tarih = str_replace("-",".", $tarih);
    return $yeni_tarih;
}

function karakter_kontrol($string) {
	if (preg_match('/^[a-z0-9._]+$/', $string)) {
		return true;
	} else {
		return false;
	}
}

function random_karakter($uzunluk){
 $karakterler = "1234567890abcdefghijKLMNOPQRSTuvwxyzABCDEFGHIJklmnopqrstUVWXYZ0987654321";
 $sifre = '';
 for($i=0;$i<$uzunluk;$i++)
 {
  $sifre .= $karakterler{rand() % 72};
 }
 return $sifre;
}

function url_resim_indir($site_url,$resim_url,$kadi,$klasor_adi){
  $uzanti=substr($resim_url,-4);
  $resim_klasor_konum = "resimler/$kadi/$klasor_adi/";
  if (!empty($resim_url)) {

      if(file_exists($resim_klasor_konum)){
        if($uzanti==".png" or $uzanti==".jpg" or $uzanti==".gif"){
          $isim=random_karakter("72").$uzanti;
          $resim_konum=$resim_klasor_konum.$isim;
          touch($resim_konum);
          $al=file_get_contents($resim_url);
          $kaydet=file_put_contents($resim_konum,$al);
          if ($kaydet) {
              $resim_konum_url = $site_url."/".$resim_konum;
            return $resim_konum_url;
          }else{
            exit("Hata");
          }
        }
      }else{
      $klasor_olustur = mkdir($resim_klasor_konum,0777, true);
        if ($klasor_olustur) {
          if($uzanti==".png" or $uzanti==".jpg" or $uzanti==".gif"){
            $isim=random_karakter("72").$uzanti;
            $resim_konum=$resim_klasor_konum.$isim;
            touch($resim_konum);
            $al=file_get_contents($resim_url);
            $kaydet=file_put_contents($resim_konum,$al);
            if ($kaydet) {
              $resim_konum_url = $site_url."/".$resim_konum;
              return $resim_konum_url;
            }else{
              exit("Hata");
            }
          }
        }else{
          exit("Hata");
        }
      }
  }else{
    $a = "";
    return $a;
  }
}


function footer_hesap_cek($baglan,$site_url){
  $mobil_link_tarama = $_SERVER["REQUEST_URI"];
  if(strstr($mobil_link_tarama , "/mobil")){$hesap_sql = "SELECT * FROM urhoba_hesaplar ORDER BY id DESC LIMIT 5";
  }else{
    $hesap_sql = "SELECT * FROM urhoba_hesaplar ORDER BY id DESC LIMIT 10";}
  $hesap_baglan = mysqli_query($baglan, $hesap_sql);
  $hesap_sayisi = mysqli_num_rows($hesap_baglan);

  if (empty($hesap_sayisi)) {
    $a = "Kayıtlı hiçbir hesap bulunamadı!";
    return $a;
  }else{
    while($hesap_cek = mysqli_fetch_array($hesap_baglan)){
      $kadi = $hesap_cek["kullanici_adi"];
      $id = $hesap_cek["id"];
      $profil_resmi = $hesap_cek["profil_foto"];
      echo "<a href='".$site_url."/profil/".$kadi."' title='$kadi'><img src='$profil_resmi'/></a>";
    }
  }

}

function GetIP(){
	if(getenv("HTTP_CLIENT_IP")) {
 		$ip = getenv("HTTP_CLIENT_IP");
 	} elseif(getenv("HTTP_X_FORWARDED_FOR")) {
 		$ip = getenv("HTTP_X_FORWARDED_FOR");
 		if (strstr($ip, ',')) {
 			$tmp = explode (',', $ip);
 			$ip = trim($tmp[0]);
 		}
 	} else {
 	$ip = getenv("REMOTE_ADDR");
 	}
	return $ip;
}

function mail_kontrol($mail, $baglan){
  if (strstr($mail, "@")) {
    $engelli_mail_sql = "SELECT * FROM urhoba_engellenen_mailler";
    $engellenen_mail_baglan = mysqli_query($baglan, $engelli_mail_sql);
    while ($engellenen_mailleri_cek = mysqli_fetch_array($engellenen_mail_baglan)) {
      if (strstr($mail, $engellenen_mailleri_cek["mail_mail"])) {
        $a = "0";
        return $a;
      }
    }
  }else{
    $a = "0";
    return $a;
  }
}

function profil_resmi_cek($baglan, $kadi){
  $sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$kadi'";
  if ($sqlbaglan = mysqli_query($baglan, $sql)) {
    $ppcek = mysqli_fetch_array($sqlbaglan);
    $a = $ppcek["profil_foto"];
    return $a;
  }
}

function kapak_resmi_cek($baglan, $kadi){
  $sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$kadi'";
  if ($sqlbaglan = mysqli_query($baglan, $sql)) {
    $ppcek = mysqli_fetch_array($sqlbaglan);
    $a = $ppcek["kapak_foto"];
    return $a;
  }
}

function kullanici_varmi_kontrol($baglan, $Getkadi){
  $hesap_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$Getkadi'";
  $hesap_baglan = mysqli_query($baglan, $hesap_sql);
  if (empty(mysqli_num_rows($hesap_baglan))) {
    return false;
  }else{
    return true;
  }
}

function anket_begeni_cek($baglan ,$anket_id){
  $begeni_sql = "SELECT * FROM urhoba_anket_begen WHERE begenilen_anket_id='$anket_id'";
  $begeni_baglan = mysqli_query($baglan, $begeni_sql);
  if ($begeni_baglan) {
    $begeni_sayisi = mysqli_num_rows($begeni_baglan);
    return $begeni_sayisi;
  }
}

function anket_dbegeni_cek($baglan ,$anket_id){
  $dbegeni_sql = "SELECT * FROM urhoba_anket_dbegen WHERE begenilmeyen_anket_id='$anket_id'";
  $dbegeni_baglan = mysqli_query($baglan, $dbegeni_sql);
  if ($dbegeni_baglan) {
    $begenilmeyen_sayisi = mysqli_num_rows($dbegeni_baglan);
    return $begenilmeyen_sayisi;
  }
}

function resim_kontrol($url){
  if (strstr($url, ".jpg") OR strstr($url, ".png") OR strstr($url, ".gif") OR strstr($url, ".jpeg") OR strstr($url, "jpg") OR strstr($url, "png") OR strstr($url, "gif") OR strstr($url, "jpeg")) {
    return TRUE;
  }else{
    return FALSE;
  }
}

function video_kontrol($url){
  if (strstr($url, "youtube.com") OR strstr($url,"youtu.be")) {
    return TRUE;
  }else{
    return FALSE;
  }
}

function oy_kullanilmismi($baglan, $anket_no, $secenek_no, $kadi_id){
  for ($i=1; $i <= 5 ; $i++) {
    $oy_kontrol_sql = "SELECT * FROM anket_cevap$i WHERE anket_no='$anket_no' AND kullanici_id='$kadi_id'";
    $oy_kontol_b = mysqli_query($baglan, $oy_kontrol_sql);
    if (mysqli_num_rows($oy_kontol_b) > 0) {
      return TRUE;
    }
  }
}

function oy_kullan_fun($baglan, $anket_no, $secenek_no, $kadi, $kadi_id){

  if (empty($kadi) OR empty($kadi_id)) {
    echo "Giriş yapın!";
  }else{
    if (oy_kullanilmismi($baglan, $anket_no, $secenek_no, $kadi_id)) {
     echo "Daha önce oy kullanılmış.";
   }else{
     $oy_sql = "INSERT INTO anket_cevap$secenek_no (anket_no, kullanici_id) VALUES ('$anket_no', '$kadi_id')";
     $oy_kullan = mysqli_query($baglan ,$oy_sql);
     if ($oy_kullan) {
       echo "Oy Kullandınız";
     }else{}
   }
  }

}

function begenibegenmemekontrol($baglan, $session_id, $anket_no){
  $sql = "SELECT * FROM urhoba_anket_begen WHERE begenen_id='$session_id' AND begenilen_anket_id='$anket_no'";
  if($sql_baglan = mysqli_query($baglan, $sql)){
  $say = mysqli_num_rows($sql_baglan);
    $sql2 = "SELECT * FROM urhoba_anket_dbegen WHERE begenilmeyen_anket_id='$anket_no' AND anket_begenmeyen_id='$session_id'";
    if ($sql2_baglan = mysqli_query($baglan, $sql2)) {
      $say2 = mysqli_num_rows($sql2_baglan);
      if ($say > "0" OR $say2 > "0") {
        return TRUE;
      }else{
        return FALSE;
      }
    }
  }
}

function begenveyabegenme($baglan, $anket_no, $islem, $session_kadi, $session_id){
  if (empty($session_kadi) OR empty($session_id)) {
    echo "Giriş yapın";
  }else{
    if (begenibegenmemekontrol($baglan, $session_id, $anket_no)) {
      echo "Sonucu değiştiremezsin!";
    }else{
      if ($islem == "1") {
        $sql = "INSERT INTO urhoba_anket_begen(begenen_id, begenilen_anket_id) VALUES('$session_id', '$anket_no')";
        if ($begen = mysqli_query($baglan,$sql)) {
          echo "Anket beğenildi";
        }
      }
      if ($islem == "2") {
        $sql = "INSERT INTO urhoba_anket_dbegen(anket_begenmeyen_id, begenilmeyen_anket_id) VALUES('$session_id', '$anket_no')";
        if ($begen = mysqli_query($baglan,$sql)) {
          echo "Anket beğenilmedi";
        }
      }
    }
  }
}


function anket_sonuclari($baglan, $anket_no, $soru_sayisi){
  echo "<div id='anket_sonuclar_zar'>";
  for ($i=1; $i <= $soru_sayisi ; $i++) {
    $oy_kontrol_sql = "SELECT * FROM anket_cevap$i WHERE anket_no='$anket_no'";
    $oy_kontol_b = mysqli_query($baglan, $oy_kontrol_sql);
    $sonuc_say = mysqli_num_rows($oy_kontol_b);
    $sayilar = array("1","2","3","4","5");
    $sayilar2 = array("one", "two", "three", "four", "five");
    $donustur = str_replace($sayilar, $sayilar2, $i);
    $sonuclar = "<span> <i title='Sonuç $i oylayanları' class='fa fa-dice-$donustur'></i> ".$sonuc_say."</span>";
    echo $sonuclar;
  }
  echo "</div>";
}

function anket_secenek_cek_video($baglan, $url, $cevap,$anket_id ,$soru_sayisi){
  $mobil_link_tarama = $_SERVER["REQUEST_URI"];
  if(strstr($mobil_link_tarama , "/mobil")){
    echo "<div id='anket_secenekleri'>";
    for ($i=1; $i <= $soru_sayisi ; $i++) {
    echo "<div id='anket_resim_cerceve' style='width: 346px;'>";
    echo '<iframe width="338" height="185" src="'.$url[$i].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    echo "<div id='anket_resim_cevap' style='width: 338px;' onclick='oy_kullan(".$anket_id.",".$i.")'><span class='oy_$i-$anket_id'>$cevap[$i]</span></div>";
    echo "</div>";
   }
   if($soru_sayisi =="3" || $soru_sayisi =="5"){
    // 3 veya 5 anket paylaşıldığı zaman boş yeri doldurmak için reklam konulabilir.
    // Reklam kodu buraya eklenecek.
   }
  echo "</div>";
  }else{
  echo "<div id='anket_secenekleri'>";
    for ($i=1; $i <= $soru_sayisi ; $i++) {
    echo "<div id='anket_resim_cerceve' style='width: 288px;'>";
    echo '<iframe width="280" height="185" src="'.$url[$i].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    echo "<div id='anket_resim_cevap' style='width: 280px;' onclick='oy_kullan(".$anket_id.",".$i.")'><span class='oy_$i-$anket_id'>$cevap[$i]</span></div>";
    echo "</div>";
   }
   if($soru_sayisi =="3" || $soru_sayisi =="5"){
    // 3 veya 5 anket paylaşıldığı zaman boş yeri doldurmak için reklam konulabilir.
    // Reklam kodu buraya eklenecek.
   }
  echo "</div>";
}
}

function anket_secenek_cek_resim($baglan, $url, $cevap,$anket_id, $soru_sayisi){

  $mobil_link_tarama = $_SERVER["REQUEST_URI"];
  if(strstr($mobil_link_tarama , "/mobil")){
    echo "<div id='anket_secenekleri'>";
    for ($i=1; $i <= $soru_sayisi ; $i++) {
      $resim_boyutu[$i] = getimagesize($url[$i]);
      $a = $resim_boyutu[$i][0] / $resim_boyutu[$i][1];
      if(resim_kontrol($url[$i])){
        if ($a > 1.5){
          echo "<div id='anket_resim_cerceve' style='width: 346px;'>";
          echo "<img src='$url[$i]' style='width: 338px; height: 185px;'/>";
          echo "<div id='anket_resim_cevap' style='width: 338px;' onclick='oy_kullan(".$anket_id.",".$i.")'><span class='oy_$i-$anket_id'>$cevap[$i]</span></div>";
          echo "</div>";
  
        }else{
          echo "<div id='anket_resim_cerceve' style='width: 346px;'>";
          // image magic dene
          echo "<div id='anket_kare_resim'><img src='$url[$i]'/></div>";
          echo "<div id='anket_resim_cevap' style='width: 338px;' onclick='oy_kullan(".$anket_id.",".$i.")'><span class='oy_$i-$anket_id'>$cevap[$i]</span></div>";
          echo "</div>";
        }
      }else{
        // echo "Resim değil";
      }
    }
    if($soru_sayisi =="3" || $soru_sayisi =="5"){
      // 3 veya 5 anket paylaşıldığı zaman boş yeri doldurmak için reklam konulabilir.
      // Reklam kodu buraya eklenecek.
     }
    echo "</div>";
  }else{
    // Mobil olmayan
  echo "<div id='anket_secenekleri'>";
  for ($i=1; $i <= $soru_sayisi ; $i++) {
    $resim_boyutu[$i] = getimagesize($url[$i]);
    $a = $resim_boyutu[$i][0] / $resim_boyutu[$i][1];
    if(resim_kontrol($url[$i])){
      if ($a > 1.5){
        echo "<div id='anket_resim_cerceve' style='width: 288px;'>";
        echo "<img src='$url[$i]' style='width: 280px; height: 185px;'/>";
        echo "<div id='anket_resim_cevap' style='width: 280px;' onclick='oy_kullan(".$anket_id.",".$i.")'><span class='oy_$i-$anket_id'>$cevap[$i]</span></div>";
        echo "</div>";

      }else{
        echo "<div id='anket_resim_cerceve' style='width: 288px;'>";
        // image magic dene
        echo "<div id='anket_kare_resim'><img src='$url[$i]'/></div>";
        echo "<div id='anket_resim_cevap' style='width: 280px;' onclick='oy_kullan(".$anket_id.",".$i.")'><span class='oy_$i-$anket_id'>$cevap[$i]</span></div>";
        echo "</div>";
      }
    }else{
      // echo "Resim değil";
    }
  }
  if($soru_sayisi =="3" || $soru_sayisi =="5"){
    // 3 veya 5 anket paylaşıldığı zaman boş yeri doldurmak için reklam konulabilir.
    // Reklam kodu buraya eklenecek.
   }
  echo "</div>";
  }
}

function onay_maili_tekrar($baglan, $site_url, $site_logo, $site_isim, $kadi, $id){
  if(empty($kadi) OR empty($id)){
    exit("Lütfen buraya kullanıcı hesabınıza giriş yapmadan girmeyin!");
  }
  $hesap_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi = '$kadi' AND id = '$id'";
  $hesap_baglan = mysqli_query($baglan, $hesap_sql);
  if(empty(mysqli_num_rows($hesap_baglan))){
    echo "Böyle bir hesap bulunamadı!";
  }else{
    $dogrulama_kodu = random_karakter("32");
    $hesap_dogrulama_kodu_sql = "UPDATE urhoba_hesaplar SET aktiflestirme_kodu='$dogrulama_kodu' WHERE kullanici_adi='$kadi' AND id='$id'";
    if (mysqli_query($baglan, $hesap_dogrulama_kodu_sql)) {
  $hesap_bilgi_cek = mysqli_fetch_array($hesap_baglan);
  $mail = $hesap_bilgi_cek["mail"];

  $hesap_onay_link = $site_url.'/hesap-onay/'.$kadi.'-'.$dogrulama_kodu;
  $mail_kime = $mail;
  $mail_konu = $site_isim ." mail onay (Yeni) ". $kadi;
  $mail_icerik = "  		  <html>
  <head>
    <style>
    body{
        margin: auto;
        width: 600px;
        mix-height: 100%;
        position: relative;
        background-color: #d7722c;
        font-family: Arial;
        color: #FFFFFFFF;
    }
    h1{
      margin: 20px 0;
      width: 100%;
      text-align:center;
    }
    img{
      position: relative;
      width: 150px;
      height: 150px;
      margin: 10px auto 10px auto;
      display: block;
      border-radius: 7px;
      border: solid 1px #883000;
    }
    span{
    display: block;
    width: 350px;
    margin: 20px auto;
    overflow: hidden;
    }
    a{
    color: white;
    text-decoration:none;
    }

    </style>
  </head>
  <body>
  <h1>".$site_isim."</h1>
  <img src='".$site_logo."'/>
  <span>Sitemize hoş geldin <b>".$kadi."</b> başarılı bir şekilde hesabın oluşuturuldu ve kullanıma hazır sayılır. <br/> <br/> Hesabını kullanmadan önce yapman gereken son bir işlem kaldı, o da aşağıdaki hesabımı onayla butonuna basmak ve hesabını hemen aktif hale getirmek. <br/> <br/> <b><a href='".$hesap_onay_link."'>Hesabımı aktif hale getir!</a></b> <br/> <br/></span>

  </body>
  </html>";
  $basari_mesaji = "Onay mailiniz yollandı.";
  $hata_mesaji = "Onay mailiniz gönderilemdi, lütfen daha sonra tekrar deneyin.";
  mail_yolla($mail_kime, $kadi,$mail_konu,$mail_icerik,$basari_mesaji,$site_isim,$hata_mesaji);
  $_SESSION["mail_onay_time_son"] = date('H:i:s', time() + 120);
  echo "<br/><br/> 3 Saniye içerisinde önceki sayfaya yönlendirileceksiniz.</span>";
  header('Refresh: 3; url='.htmlspecialchars($_SERVER['HTTP_REFERER']).'');
}
}
}

function mail_yolla($mail_kime, $kadi,$mail_konu,$mail_icerik,$basari_mesaji,$site_isim,$hata_mesaji){
  $mobil_link_tarama = $_SERVER["REQUEST_URI"];
  if(strstr($mobil_link_tarama , "/mobil")){
    require '../PHPMailler/src/PHPMailer.php';
    require '../PHPMailler/src/SMTP.php';
  }else{
    require 'PHPMailler/src/PHPMailer.php';
    require 'PHPMailler/src/SMTP.php';
  }
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.YOUR_MAILHOST.com';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->Username = 'YOUR_MAIL';
    $mail->Password = 'YOUR_MAIL_PASSWORD';
    $mail->SetFrom($mail->Username, $site_isim);
    $mail->AddAddress($mail_kime, $kadi);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = $mail_konu;
    $content = $mail_icerik;
    $mail->MsgHTML($content);
    if($mail->Send()) {
      echo $basari_mesaji;
    }else{
      echo $hata_mesaji;
    }
}

function anket_yorum_yap($baglan, $site_url, $site_isim, $anket_no, $yorum, $session_kadi, $session_id){
  if(empty($session_kadi) OR empty($session_id) OR empty($yorum) OR empty($anket_no)){
    echo "Lütfen giriş yapmadan yorum yapmaya çalışmayın, boş yorum göndermeyin.";
  }else{
      $anket_baglan_sql = "SELECT * FROM urhoba_anketler WHERE anket_no ='$anket_no'";
      $anket_baglan = mysqli_query($baglan, $anket_baglan_sql);
      $anket_veri_cek = mysqli_fetch_array($anket_baglan);
      $anket_sahibi_id = $anket_veri_cek["anket_sahibi_id"];
      $anket_sahibi_nick = $anket_veri_cek["anket_sahibi_nick"];
      $anket_aciklama = $anket_veri_cek["anket_aciklama"];


      $yorum_sql = "INSERT INTO anket_yorumlar(anket_id,yyapan_id,yorum,yyapan_nick) VALUES('$anket_no','$session_id','$yorum','$session_kadi')";
      $yorum_yap = mysqli_query($baglan, $yorum_sql);
    
      if($yorum_yap){
        if($anket_sahibi_nick == $session_kadi){

        }else{
          $bildirim_sql = "INSERT INTO bildirimler(anket_id, bildirim_sahibi_id, bildirim_sahibi_nick, bildirim_icerik, bildirim_yyapan_nick) VALUES('$anket_no','$anket_sahibi_id','$anket_sahibi_nick','$anket_aciklama','$session_kadi')";
          $bildirim_yolla = mysqli_query($baglan, $bildirim_sql);
        }
        echo "Başarılı bir şekilde yorum yaptınız. <u><a href='".htmlspecialchars($_SERVER['HTTP_REFERER'])."'>Geldiğiniz ankete geri gitmek için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde önceki sayfaya yönlendirileceksiniz.</span>";
        header('Refresh: 3; url='.htmlspecialchars($_SERVER['HTTP_REFERER']).'');
      }else{
        echo "Lütfen daha sonra tekrar deneyin şu an için yorum yapamıyorsunuz.  <u><a href='".htmlspecialchars($_SERVER['HTTP_REFERER'])."'>Geldiğiniz ankete geri gitmek için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde önceki sayfaya yönlendirileceksiniz.</span>";
        header('Refresh: 3; url='.htmlspecialchars($_SERVER['HTTP_REFERER']).'');
      }
    }
}

function anket_gonderileri_solo_anket($baglan, $site_url, $site_isim, $sayfa_kac, $anket_no, $session_kadi){
  $sayfada = 30; // sayfada gösterilecek içerik miktarını belirtiyoruz.

  $sorgu = mysqli_query($baglan,"SELECT COUNT(*) AS toplam FROM anket_yorumlar WHERE anket_id='$anket_no'");
  $sonuc = mysqli_fetch_assoc($sorgu);
  $toplam_icerik = $sonuc['toplam'];
  $toplam_sayfa = ceil($toplam_icerik / $sayfada);
  $sayfa = isset($sayfa_kac) ? (int) $sayfa_kac : 1;

  if($sayfa < 1) $sayfa = 1;
  if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;

  $limit = ($sayfa - 1) * $sayfada;
  $sayfa_goster = 11; // gösterilecek sayfa sayısı

  $en_az_orta = ceil($sayfa_goster/2);
  $en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;

  $sayfa_orta = $sayfa;
  if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
  if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;

  $sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
  $sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta);

  if($sol_sayfalar < 1) $sol_sayfalar = 1;
  if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;

  $anket_sql = "SELECT * FROM urhoba_anketler WHERE anket_no='$anket_no'";
  $anket_baglan = mysqli_query($baglan, $anket_sql);    

  if(empty(mysqli_num_rows($anket_baglan))){
    echo "<div id='anket_gonderileri_profil' style='top: -10px;'>";
    echo "<div id='anket_paylasilmamis_profil'>Şu an için sana gösterebileceğimiz anket bulunmuyor <i class='fas fa-sad-cry'></i></div>";
    echo "</div>";
  }else{

    $anket_cek = mysqli_fetch_array($anket_baglan);

    $anket_tarih = $anket_cek["anket_tarih"];
    $anket_no = $anket_cek["anket_no"];
    $soru_sayisi = $anket_cek["soru_sayi"];
    $anket_aciklama = $anket_cek["anket_aciklama"];
    $video = $anket_cek["anket_video"];
    $etiket = $anket_cek["etiket"];
    $anket_sahibi_kadi = $anket_cek["anket_sahibi_nick"];

    $kullanici = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$anket_sahibi_kadi'";
    $kullanici_baglan = mysqli_query($baglan, $kullanici);
    $kullanici_veri_cek = mysqli_fetch_array($kullanici_baglan);
    $profil_resmi = $kullanici_veri_cek["profil_foto"];
    $adsoyad = $kullanici_veri_cek["ad"].$kullanici_veri_cek["soyad"];

    for ($i=1; $i <= $soru_sayisi; $i++) {
      $url[$i] = $anket_cek["url".$i];
      $cevap[$i] = $anket_cek["cevap".$i];
      continue;
    }
    // Yukarısı resim link vb çekiyor düzenlenecek
    $yorum_sayisi_sql = "SELECT * FROM anket_yorumlar WHERE anket_id = '$anket_no'";
    $yorumlar_baglan = mysqli_query($baglan, $yorum_sayisi_sql);
    $yorumlar_sayisi = mysqli_num_rows($yorumlar_baglan);

    echo "<div id='anket_gonderileri_profil' style='top: -10px;'>";
    echo "<div id='anket_gonderi_profil_resmi'><img src='$profil_resmi'></div>";
    echo "<div id='anket_gonderi_kullanici_bilgileri'><span><a href='$site_url/profil/$anket_sahibi_kadi'>$anket_sahibi_kadi</a></span><br><span>$adsoyad</span></div>";
    echo "<div id='anket_gonderi_bilgileri'><span><a href='$site_url/etiket/$etiket'>#$etiket</a></span> <span><a href='$site_url/anket/$anket_no' title='$anket_no'><i class='fa fa-clock'></i> ".tarih_duzenle($anket_tarih)."</a></span><a href='$site_url/anket/$anket_no' title='$anket_no'><span> <i class='fas fa-comments'></i> $yorumlar_sayisi</span></a></div>";
    echo "<div id='anket_begeni_dbegeni'><span onClick='begenveyabegenmejs($anket_no,1)' class='begen1-$anket_no'><i class='fa fa-heart'></i> ".anket_begeni_cek($baglan, $anket_no)."</span> <span onClick='begenveyabegenmejs($anket_no,2)' class='begen2-$anket_no'><i class='fa fa-heart-broken'></i> ".anket_dbegeni_cek($baglan ,$anket_no)."</span>";
     echo "</div>";
    anket_sonuclari($baglan, $anket_no, $soru_sayisi);
    echo "<div id='anket_aciklama'><span>$anket_aciklama</span></div>";
    if ($video == 0){
      anket_secenek_cek_resim($baglan, $url, $cevap, $anket_no, $soru_sayisi);
    }else{
        anket_secenek_cek_video($baglan, $url, $cevap, $anket_no ,$soru_sayisi);
    }
    echo "</div>";
    echo "<div id='anket_yorumlar'>";

    if(!empty($session_kadi)){
    echo "<div id='anket_yorum_yap'>
    <form method='POST' action='yorum-yap'>
    <h3>Yorum yap</h3>
    <textarea name='yorum' placeholder='Yorumunuz'></textarea>
    <button name='anket_id' value='$anket_no'>Yorum Gönder</button>
    </form>
    </div>";
    }
    echo "<div id='anket_yazilan_yorumlar'><h3>Yorumlar</h3>";
    $anket_yorum_sql = "SELECT * FROM anket_yorumlar WHERE anket_id='$anket_no' ORDER BY id DESC LIMIT $limit,$sayfada";
    $anket_yorum_sql_baglan = mysqli_query($baglan, $anket_yorum_sql); 
    
    if($toplam_icerik == 0){
      if(empty($session_kadi)){
        echo "<span>Bu ankete hiç yorum yapılmamış hemen hesabına <a href='$site_url/giris-yap' title='Giris yap' target='_blank'><u>giriş yapıp</u></a> veya <a href='$site_url/hesap-olustur' title='Hesap oluştur' target='_blank'><u>hesap oluşturup</u></a> bu ankete yorum yapabilirsin.</span>";
      }else{
        echo "<span>Bu ankete hiç yorum yapılmamış hemen yorum yapabilirsin.</span>";
      }
    }else{
      while($anket_yorum_cek = mysqli_fetch_array($anket_yorum_sql_baglan)){
          $yorum_yorum = $anket_yorum_cek["yorum"];
          $yorum_y_nick = $anket_yorum_cek["yyapan_nick"];
          echo "<p><a href='$site_url/profil/$yorum_y_nick' title='$yorum_y_nick'><u>$yorum_y_nick</u></a>: $yorum_yorum</p>";
      } 
    }
  
    echo "</div>
    </div>";

    if($toplam_icerik == 0){

    }else{
  echo "<div id='anket_gonderileri_profil'><div id='anket_paylasilmamis_profil' style='text-align: center;'>";
  if($sayfa != 1) echo ' <a href="anket/'.$anket_no.'/1"><i class="fas fa-angle-left"></i></a> ';
  if($sayfa != 1) echo ' <a href="anket/'.$anket_no.'/'.($sayfa-1).'"><i class="fas fa-angle-left"></i><i class="fas fa-angle-left"></i></a> ';

  for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
      if($sayfa == $s) {
          echo ' <i class="fa fa-home"></i> ';
      } else {
          echo '<a href="anket/'.$anket_no.'/'.$s.'">'.$s.'</a> ';
      }
  }

  if($sayfa != $toplam_sayfa) echo ' <a href="anket/'.$anket_no.'/'.($sayfa+1).'"><i class="fas fa-angle-right"></i></a> ';
  if($sayfa != $toplam_sayfa) echo ' <a href="anket/'.$anket_no.'/'.$toplam_sayfa.'"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></a>';
  echo "</div></div>";
}
  }
}

function ara_sonuclari_cek($baglan, $site_url, $ara, $sayfa_kac){

  $sayfada = 20; // sayfada gösterilecek içerik miktarını belirtiyoruz.

        $sorgu = mysqli_query($baglan,"SELECT COUNT(*) AS toplam FROM urhoba_hesaplar WHERE kullanici_adi LIKE '%$ara%' OR ad LIKE '%$ara%' OR soyad LIKE '$ara$'");
        $sorgu_iki = mysqli_query($baglan, "SELECT COUNT(*) AS toplam FROM urhoba_anketler WHERE anket_aciklama LIKE '%$ara%' OR anket_sahibi_nick LIKE '%$ara%' ORDER BY anket_no");
        $sonuc1 = mysqli_fetch_assoc($sorgu);
        $sonuc2 = mysqli_fetch_assoc($sorgu_iki);

        if($sonuc1 > $sonuc2){
          $sonuc = $sonuc1;
        }else{
          $sonuc = $sonuc2;
        }

        $toplam_icerik_hesap = $sonuc1['toplam'];
        $toplam_icerik_anket = $sonuc2['toplam'];

        $toplam_icerik = $sonuc['toplam'];
        $toplam_sayfa = ceil($toplam_icerik / $sayfada);
        $sayfa = isset($sayfa_kac) ? (int) $sayfa_kac : 1;
    
        if($sayfa < 1) $sayfa = 1;
        if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
    
        $limit = ($sayfa - 1) * $sayfada;
        $sayfa_goster = 11; // gösterilecek sayfa sayısı
    
        $en_az_orta = ceil($sayfa_goster/2);
        $en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;
    
        $sayfa_orta = $sayfa;
        if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
        if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
    
        $sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
        $sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta);
    
        if($sol_sayfalar < 1) $sol_sayfalar = 1;
        if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;


  if(empty($ara)){
    echo "<h3>Hesaplar</h3>";
    echo "<div id='ara_kullanici_dis' style='top: -10px;'>";
    echo "<div id='anket_paylasilmamis_profil'>Lütfen boş arama yapmayın! <i class='fas fa-sad-cry'></i></div>";
    echo "</div>";
  }else{
  
    $kullanici_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi LIKE '%$ara%' OR ad LIKE '%$ara%' OR soyad LIKE '$ara$' LIMIT $limit,$sayfada";
    $kullanici_baglan = mysqli_query($baglan, $kullanici_sql);
    if($toplam_icerik_hesap == 0){
      echo "<h3>Hesaplar</h3>";
      echo "<div id='ara_kullanici_dis' style='top: -10px;'>";
      echo "<div id='anket_paylasilmamis_profil'>Hiç bir hesap bulunamadı! <i class='fas fa-sad-cry'></i></div>";
      echo "</div>";
    }else{
      
      echo "<h3>Hesaplar</h3>";
        while($kullanici_cek = mysqli_fetch_array($kullanici_baglan)){
          echo "<a href='$site_url/profil/".$kullanici_cek['kullanici_adi']."'>";
          echo "<div id='ara_kullanici_dis' style='top: -10px;'>";
          echo "<div id='ara_kullanici'><img src='".$kullanici_cek["profil_foto"]."'>
          <div id='ara_kullanici_bilgileri'>
          <p><i class='fa fa-user'></i><b> ".$kullanici_cek['kullanici_adi']." </b></p> 
          <p><i class='fas fa-signature'></i> ".$kullanici_cek['ad']."".$kullanici_cek['soyad']."</p>
          <p><i class='fas fa-clock'></i> ".tarih_duzenle($kullanici_cek['kayit_tarihi'])."</p>
          </div></div>";
          echo "</div>";
          echo "</a>";
        }
    }



    $anket_sql = "SELECT * FROM urhoba_anketler WHERE anket_aciklama LIKE '%$ara%' OR anket_sahibi_nick LIKE '%$ara%' ORDER BY anket_no DESC LIMIT $limit,$sayfada";
    $anket_baglan = mysqli_query($baglan, $anket_sql);
    if($toplam_icerik_anket == 0){
      echo "<h3>Anketler</h3>";
      echo "<div id='ara_kullanici_dis' style='top: -10px;'>";
      echo "<div id='anket_paylasilmamis_profil'>Hiç bir anket bulunamadı! <i class='fas fa-sad-cry'></i></div>";
      echo "</div>";
    }else{
      echo "<h3>Anketler</h3>";
        while($anket_cek = mysqli_fetch_array($anket_baglan)){
          $anket_no = $anket_cek["anket_no"];
          echo "<a href='$site_url/anket/".$anket_cek['anket_no']."'>";
          echo "<div id='ara_kullanici_dis' style='top: -10px;'>";
          echo "<div id='ara_kullanici_bilgileri'>
          <p><i class='fas fa-align-justify'></i>".$anket_cek["anket_aciklama"]."</p>
          <p><i class='fa fa-heart' style='width: 15px;'></i> ".anket_begeni_cek($baglan, $anket_no)." <i style='width: 15px;' class='fa fa-heart-broken'></i> ".anket_dbegeni_cek($baglan, $anket_no)."</p>
          </div>";
          echo "<div id='ara_anket_bilgileri_sag'>
          <p><i class='fas fa-clock'></i> ".tarih_duzenle($anket_cek["anket_tarih"])."</p>
          </div>";
          echo "</div>";
          echo "</a>";
        }
    }
  }

  echo "<div id='ara_kullanici_dis' style='margin-bottom: 10px;'><div id='anket_paylasilmamis_profil' style='text-align: center;'>";
  if($sayfa != 1) echo ' <a href="ara/'.$ara.'/1"><i class="fas fa-angle-left"></i></a> ';
  if($sayfa != 1) echo ' <a href="ara/'.$ara.'/'.($sayfa-1).'"><i class="fas fa-angle-left"></i><i class="fas fa-angle-left"></i></a> ';

  for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
      if($sayfa == $s) {
          echo ' <i class="fa fa-home"></i> ';
      } else {
          echo '<a href="ara/'.$ara.'/'.$s.'">'.$s.'</a> ';
      }
  }

  if($sayfa != $toplam_sayfa) echo ' <a href="ara/'.$ara.'/'.($sayfa+1).'"><i class="fas fa-angle-right"></i></a> ';
  if($sayfa != $toplam_sayfa) echo ' <a href="ara/'.$ara.'/'.$toplam_sayfa.'"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></a>';
  echo "</div></div>";

}

function anket_gonderileri_etiket($baglan, $site_url, $site_isim, $sayfa_kac, $etiket){
        $sayfada = 30; // sayfada gösterilecek içerik miktarını belirtiyoruz.

        $sorgu = mysqli_query($baglan,"SELECT COUNT(*) AS toplam FROM urhoba_anketler WHERE etiket='$etiket'");
        $sonuc = mysqli_fetch_assoc($sorgu);
        $toplam_icerik = $sonuc['toplam'];
        $toplam_sayfa = ceil($toplam_icerik / $sayfada);
        $sayfa = isset($sayfa_kac) ? (int) $sayfa_kac : 1;
    
        if($sayfa < 1) $sayfa = 1;
        if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
    
        $limit = ($sayfa - 1) * $sayfada;
        $sayfa_goster = 11; // gösterilecek sayfa sayısı
    
        $en_az_orta = ceil($sayfa_goster/2);
        $en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;
    
        $sayfa_orta = $sayfa;
        if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
        if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
    
        $sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
        $sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta);
    
        if($sol_sayfalar < 1) $sol_sayfalar = 1;
        if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;
    
        $anket_sql = "SELECT * FROM urhoba_anketler WHERE etiket='$etiket' ORDER BY anket_no DESC LIMIT $limit,$sayfada";
        $anket_baglan = mysqli_query($baglan, $anket_sql);    

        if(empty(mysqli_num_rows($anket_baglan))){
          echo "<div id='anket_gonderileri_profil' style='top: -10px;'>";
          echo "<div id='anket_paylasilmamis_profil'>Şu an için sana gösterebileceğimiz anket bulunmuyor <i class='fas fa-sad-cry'></i></div>";
          echo "</div>";
        }else{
        while ($anket_cek = mysqli_fetch_array($anket_baglan)) {

          $anket_tarih = $anket_cek["anket_tarih"];
          $anket_no = $anket_cek["anket_no"];
          $soru_sayisi = $anket_cek["soru_sayi"];
          $anket_aciklama = $anket_cek["anket_aciklama"];
          $video = $anket_cek["anket_video"];
          $etiket = $anket_cek["etiket"];
          $anket_sahibi_kadi = $anket_cek["anket_sahibi_nick"];
  
          $kullanici = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$anket_sahibi_kadi'";
          $kullanici_baglan = mysqli_query($baglan, $kullanici);
          $kullanici_veri_cek = mysqli_fetch_array($kullanici_baglan);
          $profil_resmi = $kullanici_veri_cek["profil_foto"];
          $adsoyad = $kullanici_veri_cek["ad"].$kullanici_veri_cek["soyad"];
  
          for ($i=1; $i <= $soru_sayisi; $i++) {
            $url[$i] = $anket_cek["url".$i];
            $cevap[$i] = $anket_cek["cevap".$i];
            continue;
          }
          // Yukarısı resim link vb çekiyor düzenlenecek     
          $yorum_sayisi_sql = "SELECT * FROM anket_yorumlar WHERE anket_id = '$anket_no'";    
           $yorumlar_baglan = mysqli_query($baglan, $yorum_sayisi_sql);     
           $yorumlar_sayisi = mysqli_num_rows($yorumlar_baglan);
  
          echo "<div id='anket_gonderileri_profil' style='top: -10px;'>";
          echo "<div id='anket_gonderi_profil_resmi'><img src='$profil_resmi'></div>";
          echo "<div id='anket_gonderi_kullanici_bilgileri'><span><a href='$site_url/profil/$anket_sahibi_kadi'>$anket_sahibi_kadi</a></span><br><span>$adsoyad</span></div>";
          echo "<div id='anket_gonderi_bilgileri'><span><a href='$site_url/etiket/$etiket'>#$etiket</a></span> <span><a href='$site_url/anket/$anket_no' title='$anket_no'><i class='fa fa-clock'></i> ".tarih_duzenle($anket_tarih)."</a></span><a href='$site_url/anket/$anket_no' title='$anket_no'><span> <i class='fas fa-comments'></i> $yorumlar_sayisi</span></a></div>";
          echo "<div id='anket_begeni_dbegeni'><span onClick='begenveyabegenmejs($anket_no,1)' class='begen1-$anket_no'><i class='fa fa-heart'></i> ".anket_begeni_cek($baglan, $anket_no)."</span> <span onClick='begenveyabegenmejs($anket_no,2)' class='begen2-$anket_no'><i class='fa fa-heart-broken'></i> ".anket_dbegeni_cek($baglan ,$anket_no)."</span>";
           echo "</div>";
          anket_sonuclari($baglan, $anket_no, $soru_sayisi);
          echo "<div id='anket_aciklama'><span>$anket_aciklama</span></div>";
          if ($video == 0){
            anket_secenek_cek_resim($baglan, $url, $cevap, $anket_no, $soru_sayisi);
          }else{
            anket_secenek_cek_video($baglan, $url, $cevap, $anket_no ,$soru_sayisi);
          }
          echo "</div>";
        }
        echo "<div id='anket_gonderileri_profil'><div id='anket_paylasilmamis_profil' style='text-align: center;'>";
        if($sayfa != 1) echo ' <a href="etiket/'.$etiket.'/1"><i class="fas fa-angle-left"></i></a> ';
        if($sayfa != 1) echo ' <a href="etiket/'.$etiket.'/'.($sayfa-1).'"><i class="fas fa-angle-left"></i><i class="fas fa-angle-left"></i></a> ';
  
        for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
            if($sayfa == $s) {
                echo ' <i class="fa fa-home"></i> ';
            } else {
                echo '<a href="etiket/'.$etiket.'/'.$s.'">'.$s.'</a> ';
            }
        }
  
        if($sayfa != $toplam_sayfa) echo ' <a href="etiket/'.$etiket.'/'.($sayfa+1).'"><i class="fas fa-angle-right"></i></a> ';
        if($sayfa != $toplam_sayfa) echo ' <a href="etiket/'.$etiket.'/'.$toplam_sayfa.'"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></a>';
        echo "</div></div>";
      }
}

function anket_gonderileri_anasayfa($baglan, $site_url, $site_isim, $sayfa_kac, $durum, $session_kadi, $session_id){

  $takip_edilenler_sql = "SELECT * FROM urhoba_takip WHERE takip_eden='$session_kadi' AND takip_durumu='1'";
  $takip_edilenler_baglan = mysqli_query($baglan, $takip_edilenler_sql);
  $takip_edilen_sayisi = mysqli_num_rows($takip_edilenler_baglan);

  $i = "0";
  while($takip_edilen_cek = mysqli_fetch_array($takip_edilenler_baglan)){
    $i++;
    if($i == $takip_edilen_sayisi){
     $a[$i] = "'".$takip_edilen_cek["takip_edilen"]."'";
    }else{
      $a[$i] = "'".$takip_edilen_cek["takip_edilen"]."'".",";
    }
  }
  if(empty($a)){

  }else{
    $userStr = join("','",$a); 
  }

      if($durum == "g"){

        $sayfada = 30; // sayfada gösterilecek içerik miktarını belirtiyoruz.

        $sorgu = mysqli_query($baglan,"SELECT COUNT(*) AS toplam FROM urhoba_anketler ");
        $sonuc = mysqli_fetch_assoc($sorgu);
        $toplam_icerik = $sonuc['toplam'];
        $toplam_sayfa = ceil($toplam_icerik / $sayfada);
        $sayfa = isset($sayfa_kac) ? (int) $sayfa_kac : 1;
    
        if($sayfa < 1) $sayfa = 1;
        if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
    
        $limit = ($sayfa - 1) * $sayfada;
        $sayfa_goster = 11; // gösterilecek sayfa sayısı
    
        $en_az_orta = ceil($sayfa_goster/2);
        $en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;
    
        $sayfa_orta = $sayfa;
        if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
        if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
    
        $sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
        $sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta);
    
        if($sol_sayfalar < 1) $sol_sayfalar = 1;
        if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;
    
        $anket_sql = "SELECT * FROM urhoba_anketler ORDER BY anket_no DESC LIMIT $limit,$sayfada";
        $anket_baglan = mysqli_query($baglan, $anket_sql);    

        if($toplam_icerik == 0){
          echo "<div id='anket_gonderileri_profil' style='top: -10px;'>";
          echo "<div id='anket_paylasilmamis_profil'>Şu an için sana gösterebileceğimiz anket bulunmuyor <i class='fas fa-sad-cry'></i></div>";
          echo "</div>";
        }else{
        while ($anket_cek = mysqli_fetch_array($anket_baglan)) {

          $anket_tarih = $anket_cek["anket_tarih"];
          $anket_no = $anket_cek["anket_no"];
          $soru_sayisi = $anket_cek["soru_sayi"];
          $anket_aciklama = $anket_cek["anket_aciklama"];
          $video = $anket_cek["anket_video"];
          $etiket = $anket_cek["etiket"];
          $anket_sahibi_kadi = $anket_cek["anket_sahibi_nick"];
  
          $kullanici = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$anket_sahibi_kadi'";
          $kullanici_baglan = mysqli_query($baglan, $kullanici);
          $kullanici_veri_cek = mysqli_fetch_array($kullanici_baglan);
          $profil_resmi = $kullanici_veri_cek["profil_foto"];
          $adsoyad = $kullanici_veri_cek["ad"].$kullanici_veri_cek["soyad"];
  
          for ($i=1; $i <= $soru_sayisi; $i++) {
            $url[$i] = $anket_cek["url".$i];
            $cevap[$i] = $anket_cek["cevap".$i];
            continue;
          }
          // Yukarısı resim link vb çekiyor düzenlenecek     
          $yorum_sayisi_sql = "SELECT * FROM anket_yorumlar WHERE anket_id = '$anket_no'";    
           $yorumlar_baglan = mysqli_query($baglan, $yorum_sayisi_sql);   
             $yorumlar_sayisi = mysqli_num_rows($yorumlar_baglan);
  
          echo "<div id='anket_gonderileri_profil' style='top: -10px;'>";
          echo "<div id='anket_gonderi_profil_resmi'><img src='$profil_resmi'></div>";
          echo "<div id='anket_gonderi_kullanici_bilgileri'><span><a href='$site_url/profil/$anket_sahibi_kadi'>$anket_sahibi_kadi</a></span><br><span>$adsoyad</span></div>";
          echo "<div id='anket_gonderi_bilgileri'><span><a href='$site_url/etiket/$etiket'>#$etiket</a></span> <span><a href='$site_url/anket/$anket_no' title='$anket_no'><i class='fa fa-clock'></i> ".tarih_duzenle($anket_tarih)."</a></span><a href='$site_url/anket/$anket_no' title='$anket_no'><span> <i class='fas fa-comments'></i> $yorumlar_sayisi</span></a></div>";
          echo "<div id='anket_begeni_dbegeni'><span onClick='begenveyabegenmejs($anket_no,1)' class='begen1-$anket_no'><i class='fa fa-heart'></i> ".anket_begeni_cek($baglan, $anket_no)."</span> <span onClick='begenveyabegenmejs($anket_no,2)' class='begen2-$anket_no'><i class='fa fa-heart-broken'></i> ".anket_dbegeni_cek($baglan ,$anket_no)."</span>";
           echo "</div>";
          anket_sonuclari($baglan, $anket_no, $soru_sayisi);
          echo "<div id='anket_aciklama'><span>$anket_aciklama</span></div>";
          if ($video == 0){
            anket_secenek_cek_resim($baglan, $url, $cevap, $anket_no, $soru_sayisi);
          }else{
              anket_secenek_cek_video($baglan, $url, $cevap, $anket_no ,$soru_sayisi);
          }
          echo "</div>";
        }
        echo "<div id='anket_gonderileri_profil'><div id='anket_paylasilmamis_profil' style='text-align: center;'>";
        if($sayfa != 1) echo ' <a href="anasayfa/g/1"><i class="fas fa-angle-left"></i></a> ';
        if($sayfa != 1) echo ' <a href="anasayfa/g/'.($sayfa-1).'"><i class="fas fa-angle-left"></i><i class="fas fa-angle-left"></i></a> ';
  
        for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
            if($sayfa == $s) {
                echo ' <i class="fa fa-home"></i> ';
            } else {
                echo '<a href="anasayfa/g/'.$s.'">'.$s.'</a> ';
            }
        }
  
        if($sayfa != $toplam_sayfa) echo ' <a href="anasayfa/g/'.($sayfa+1).'"><i class="fas fa-angle-right"></i></a> ';
        if($sayfa != $toplam_sayfa) echo ' <a href="anasayfa/g/'.$toplam_sayfa.'"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></a>';
        echo "</div></div>";
      }
      }else{
        if($durum == "t"){
            if(mysqli_num_rows($takip_edilenler_baglan) == "0"){
              echo "<div id='anket_gonderileri_profil' style='top: -10px;'>";
              echo "<div id='anket_paylasilmamis_profil'>Kimseyi takip etmiyorsun. <i class='fas fa-sad-cry'></i></div>";
              echo "</div>";
            }else{

              $sayfada = 30; // sayfada gösterilecek içerik miktarını belirtiyoruz.

              $sorgu = mysqli_query($baglan,"SELECT COUNT(*) AS toplam FROM urhoba_anketler WHERE anket_sahibi_nick IN($userStr)");
              $sonuc = mysqli_fetch_assoc($sorgu);
              $toplam_icerik = $sonuc['toplam'];
              $toplam_sayfa = ceil($toplam_icerik / $sayfada);
              $sayfa = isset($sayfa_kac) ? (int) $sayfa_kac : 1;
          
              if($sayfa < 1) $sayfa = 1;
              if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
          
              $limit = ($sayfa - 1) * $sayfada;
              $sayfa_goster = 11; // gösterilecek sayfa sayısı
          
              $en_az_orta = ceil($sayfa_goster/2);
              $en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;
          
              $sayfa_orta = $sayfa;
              if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
              if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
          
              $sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
              $sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta);
          
              if($sol_sayfalar < 1) $sol_sayfalar = 1;
              if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;

              // Takip edilenler ayarlanacak
             
              

              $anket_sql = "SELECT * FROM urhoba_anketler WHERE anket_sahibi_nick IN($userStr) ORDER BY anket_no DESC LIMIT $limit,$sayfada";
              $anket_baglan = mysqli_query($baglan, $anket_sql);    
      
              if($toplam_icerik == 0){
                echo "<div id='anket_gonderileri_profil' style='top: -10px;'>";
                echo "<div id='anket_paylasilmamis_profil'>Şu an için sana gösterebileceğimiz anket bulunmuyor <i class='fas fa-sad-cry'></i></div>";
                echo "</div>";
              }else{
              while ($anket_cek = mysqli_fetch_array($anket_baglan)) {
      
                $anket_tarih = $anket_cek["anket_tarih"];
                $anket_no = $anket_cek["anket_no"];
                $soru_sayisi = $anket_cek["soru_sayi"];
                $anket_aciklama = $anket_cek["anket_aciklama"];
                $video = $anket_cek["anket_video"];
                $etiket = $anket_cek["etiket"];
                $anket_sahibi_kadi = $anket_cek["anket_sahibi_nick"];
        
                $kullanici = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$anket_sahibi_kadi'";
                $kullanici_baglan = mysqli_query($baglan, $kullanici);
                $kullanici_veri_cek = mysqli_fetch_array($kullanici_baglan);
                $profil_resmi = $kullanici_veri_cek["profil_foto"];
                $adsoyad = $kullanici_veri_cek["ad"].$kullanici_veri_cek["soyad"];
        
                for ($i=1; $i <= $soru_sayisi; $i++) {
                  $url[$i] = $anket_cek["url".$i];
                  $cevap[$i] = $anket_cek["cevap".$i];
                  continue;
                }
                // Yukarısı resim link vb çekiyor düzenlenecek   
                  $yorum_sayisi_sql = "SELECT * FROM anket_yorumlar WHERE anket_id = '$anket_no'";   
                    $yorumlar_baglan = mysqli_query($baglan, $yorum_sayisi_sql);   
                      $yorumlar_sayisi = mysqli_num_rows($yorumlar_baglan);
        
                echo "<div id='anket_gonderileri_profil' style='top: -10px;'>";
                echo "<div id='anket_gonderi_profil_resmi'><img src='$profil_resmi'></div>";
                echo "<div id='anket_gonderi_kullanici_bilgileri'><span><a href='$site_url/profil/$anket_sahibi_kadi'>$anket_sahibi_kadi</a></span><br><span>$adsoyad</span></div>";
                echo "<div id='anket_gonderi_bilgileri'><span><a href='$site_url/etiket/$etiket'>#$etiket</a></span> <span><a href='$site_url/anket/$anket_no' title='$anket_no'><i class='fa fa-clock'></i> ".tarih_duzenle($anket_tarih)."</a></span><a href='$site_url/anket/$anket_no' title='$anket_no'><span> <i class='fas fa-comments'></i> $yorumlar_sayisi</span></a></div>";
                echo "<div id='anket_begeni_dbegeni'><span onClick='begenveyabegenmejs($anket_no,1)' class='begen1-$anket_no'><i class='fa fa-heart'></i> ".anket_begeni_cek($baglan, $anket_no)."</span> <span onClick='begenveyabegenmejs($anket_no,2)' class='begen2-$anket_no'><i class='fa fa-heart-broken'></i> ".anket_dbegeni_cek($baglan ,$anket_no)."</span>";
                 echo "</div>";
                anket_sonuclari($baglan, $anket_no, $soru_sayisi);
                echo "<div id='anket_aciklama'><span>$anket_aciklama</span></div>";
                if ($video == 0){
                  anket_secenek_cek_resim($baglan, $url, $cevap, $anket_no, $soru_sayisi);
                }else{
                    anket_secenek_cek_video($baglan, $url, $cevap, $anket_no ,$soru_sayisi);
                }
                echo "</div>";
              }
              echo "<div id='anket_gonderileri_profil'><div id='anket_paylasilmamis_profil' style='text-align: center;'>";
              if($sayfa != 1) echo ' <a href="anasayfa/t/1"><i class="fas fa-angle-left"></i></a> ';
              if($sayfa != 1) echo ' <a href="anasayfa/t/'.($sayfa-1).'"><i class="fas fa-angle-left"></i><i class="fas fa-angle-left"></i></a> ';
        
              for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
                  if($sayfa == $s) {
                      echo ' <i class="fa fa-home"></i> ';
                  } else {
                      echo '<a href="anasayfa/t/'.$s.'">'.$s.'</a> ';
                  }
              }
        
              if($sayfa != $toplam_sayfa) echo ' <a href="anasayfa/t/'.($sayfa+1).'"><i class="fas fa-angle-right"></i></a> ';
              if($sayfa != $toplam_sayfa) echo ' <a href="anasayfa/t/'.$toplam_sayfa.'"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></a>';
              echo "</div></div>";
            }
            }
        }
      }
    


}

function takipet_takipbirak_button($baglan,$session_kadi,$session_id,$get_kadi){
  $get_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi ='$get_kadi'";
  $get_baglan = mysqli_query($baglan, $get_sql);
  $get_cek = mysqli_fetch_array($get_baglan);
  $get_id = $get_cek["id"];

  $takip_sql = "SELECT * FROM urhoba_takip WHERE takip_eden='$session_kadi' AND takip_edilen='$get_kadi'";
  $takip_baglan = mysqli_query($baglan, $takip_sql);
  $takip_varmi = mysqli_num_rows($takip_baglan);
  $takip_durumu = mysqli_fetch_array($takip_baglan);
    if($takip_varmi == 1 AND $takip_durumu["takip_durumu"] == 1){
      echo "<button onclick='takip_et_etme(".$get_id.",2)' class='takip'>Takibi bırak</button>";
    }else{
      echo "<button onclick='takip_et_etme(".$get_id.",1)' class='takip'>Takip et</button>";
    }
}

function takip_et_fun($baglan, $takip_edilcek_id, $islem, $session_kadi, $session_id){
  $get_sql = "SELECT * FROM urhoba_hesaplar WHERE id ='$takip_edilcek_id'";
  $get_baglan = mysqli_query($baglan, $get_sql);
  $get_cek = mysqli_fetch_array($get_baglan);
  $takip_edilen_kadi = $get_cek["kullanici_adi"];

  $takip_sorgu_sql = "SELECT * FROM urhoba_takip WHERE takip_eden='$session_kadi' AND takip_edilen='$takip_edilen_kadi'";
  $takip_sorgu_baglan = mysqli_query($baglan, $takip_sorgu_sql);
  $takip_ediliyormu = mysqli_num_rows($takip_sorgu_baglan);

  if($islem == "2"){
    $takipci_durumu_sql = "UPDATE urhoba_takip SET takip_durumu = 2 WHERE takip_eden='$session_kadi' AND takip_edilen='$takip_edilen_kadi'";
    if($takipci_ekle = mysqli_query($baglan, $takipci_durumu_sql)){
      echo "Takip bırakıldı";
    }else{
      echo "Lütfen daha sonra tekrar deneyin!";
    }

  }else{
  if($islem == "1"){
    if(empty($takip_ediliyormu) OR $takip_ediliyormu == 2){
      $takipci_ekle_sql = "INSERT INTO urhoba_takip (takip_eden, takip_eden_id, takip_edilen, takip_edilen_id, takip_durumu) VALUES('$session_kadi','$session_id','$takip_edilen_kadi','$takip_edilcek_id','1')";
      if($takipci_ekle = mysqli_query($baglan, $takipci_ekle_sql)){
        echo "Takip edildi";
      }else{
        echo "Lütfen daha sonra tekrar deneyin!";
      }
    }else{
      $takipci_durumu_sql = "UPDATE urhoba_takip SET takip_durumu = '1' WHERE takip_eden='$session_kadi' AND takip_edilen='$takip_edilen_kadi'";
      if($takipci_ekle = mysqli_query($baglan, $takipci_durumu_sql)){
        echo "Takip edildi";
      }else{
        echo "Lütfen daha sonra tekrar deneyin!";
      }
    }
  }
}
}

function anket_gonderileri_profil($baglan , $site_url, $site_isim, $get_kadi, $session_id, $session_kadi,$sayfa_kac){
  $hesap_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$get_kadi'";
  $hesap_baglan = mysqli_query($baglan, $hesap_sql);
  if (!empty(mysqli_num_rows($hesap_baglan))) {


    $hb_cek = mysqli_fetch_array($hesap_baglan);
    $id = $hb_cek["id"];
    $profil_resmi = $hb_cek["profil_foto"];
    $adsoyad = $hb_cek["ad"].' '.$hb_cek["soyad"];


    $sayfada = 30; // sayfada gösterilecek içerik miktarını belirtiyoruz.

    $sorgu = mysqli_query($baglan,"SELECT COUNT(*) AS toplam FROM urhoba_anketler WHERE anket_sahibi_nick='$get_kadi' AND anket_sahibi_id='$id'");
    $sonuc = mysqli_fetch_assoc($sorgu);
    $toplam_icerik = $sonuc['toplam'];
    $toplam_sayfa = ceil($toplam_icerik / $sayfada);
    $sayfa = isset($sayfa_kac) ? (int) $sayfa_kac : 1;

    if($sayfa < 1) $sayfa = 1;
    if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;

    $limit = ($sayfa - 1) * $sayfada;
    $sayfa_goster = 11; // gösterilecek sayfa sayısı

    $en_az_orta = ceil($sayfa_goster/2);
    $en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;

    $sayfa_orta = $sayfa;
    if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
    if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;

    $sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
    $sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta);

    if($sol_sayfalar < 1) $sol_sayfalar = 1;
    if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;

    $anket_sql = "SELECT * FROM urhoba_anketler WHERE anket_sahibi_nick='$get_kadi' AND anket_sahibi_id='$id' ORDER BY anket_no DESC LIMIT $limit,$sayfada";
    $anket_baglan = mysqli_query($baglan, $anket_sql);
    
    if ($toplam_icerik == 0) {
      if ($session_kadi == $get_kadi) {
        echo "<div id='anket_gonderileri_profil'>";
        echo "<div id='anket_paylasilmamis_profil'>Hiç anket paylaşmamışsın hemen yukarıdaki anket paylaşma kısmından ilk anketini paylaşabilirsin.</div>";
        echo "</div>";
      }else{
        echo "<div id='anket_gonderileri_profil' style='top: -10px;'>";
        echo "<div id='anket_paylasilmamis_profil'>Kullanıcı tarafından hiç anket paylaşılmamış!</div>";
        echo "</div>";
      }

    }else{
        if ($session_kadi == $get_kadi) {

          while ($anket_cek = mysqli_fetch_array($anket_baglan)) {
            $anket_tarih = $anket_cek["anket_tarih"];
            $anket_no = $anket_cek["anket_no"];
            $soru_sayisi = $anket_cek["soru_sayi"];
            $anket_aciklama = $anket_cek["anket_aciklama"];
            $video = $anket_cek["anket_video"];
            $etiket = $anket_cek["etiket"];
            for ($i=1; $i <= $soru_sayisi; $i++) {
              $url[$i] = $anket_cek["url".$i];
              $cevap[$i] = $anket_cek["cevap".$i];
              continue;
            }
            // Yukarısı resim link vb çekiyor düzenlenecek   
              $yorum_sayisi_sql = "SELECT * FROM anket_yorumlar WHERE anket_id = '$anket_no'";  
                 $yorumlar_baglan = mysqli_query($baglan, $yorum_sayisi_sql);  
                    $yorumlar_sayisi = mysqli_num_rows($yorumlar_baglan);

            echo "<div id='anket_gonderileri_profil'>";
            echo "<div id='anket_gonderi_profil_resmi'><img src='$profil_resmi'></div>";
            echo "<div id='anket_gonderi_kullanici_bilgileri'><span><a href='$site_url/profil/$get_kadi'>$get_kadi</a></span><br><span>$adsoyad</span></div>";
            echo "<div id='anket_gonderi_bilgileri'><span><a href='$site_url/etiket/$etiket' title='$etiket'>#$etiket</a></span> <span><a href='$site_url/anket/$anket_no' title='$anket_no'><i class='fa fa-clock'></i> ".tarih_duzenle($anket_tarih)."</a></span><a href='$site_url/anket/$anket_no' title='$anket_no'><span> <i class='fas fa-comments'></i> $yorumlar_sayisi</span></a></div>";
            echo "<div id='anket_begeni_dbegeni'><span onClick='begenveyabegenmejs($anket_no,1)' class='begen1-$anket_no'><i class='fa fa-heart'></i> ".anket_begeni_cek($baglan, $anket_no)."</span> <span onClick='begenveyabegenmejs($anket_no,2)' class='begen2-$anket_no'><i class='fa fa-heart-broken'></i> ".anket_dbegeni_cek($baglan ,$anket_no)."</span>";
             echo "</div>";
            anket_sonuclari($baglan, $anket_no, $soru_sayisi);
            echo "<div id='anket_aciklama'><span>$anket_aciklama</span></div>";
            if ($video == 0){
              anket_secenek_cek_resim($baglan, $url, $cevap, $anket_no, $soru_sayisi);
            }else{
                anket_secenek_cek_video($baglan, $url, $cevap, $anket_no ,$soru_sayisi);
            }
            echo "</div>";

          }
          echo "<div id='anket_gonderileri_profil'><div id='anket_paylasilmamis_profil' style='text-align: center;'>";
          if($sayfa != 1) echo ' <a href="profil/'.$get_kadi.'/1"><i class="fas fa-angle-left"></i></a> ';
          if($sayfa != 1) echo ' <a href="profil/'.$get_kadi.'/'.($sayfa-1).'"><i class="fas fa-angle-left"></i><i class="fas fa-angle-left"></i></a> ';

          for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
              if($sayfa == $s) {
                  echo ' <i class="fa fa-home"></i> ';
              } else {
                  echo '<a href="profil/'.$get_kadi.'/'.$s.'">'.$s.'</a> ';
              }
          }

          if($sayfa != $toplam_sayfa) echo ' <a href="profil/'.$get_kadi.'/'.($sayfa+1).'"><i class="fas fa-angle-right"></i></a> ';
          if($sayfa != $toplam_sayfa) echo ' <a href="profil/'.$get_kadi.'/'.$toplam_sayfa.'"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></a>';
          echo "</div></div>";
        }else{
          while ($anket_cek = mysqli_fetch_array($anket_baglan)) {
            $anket_tarih = $anket_cek["anket_tarih"];
            $anket_no = $anket_cek["anket_no"];
            $soru_sayisi = $anket_cek["soru_sayi"];
            $anket_aciklama = $anket_cek["anket_aciklama"];
            $video = $anket_cek["anket_video"];
            $etiket = $anket_cek["etiket"];
            for ($i=1; $i <= $soru_sayisi; $i++) {
              $url[$i] = $anket_cek["url".$i];
              $cevap[$i] = $anket_cek["cevap".$i];
              continue;
            }
            // Yukarısı resim link vb çekiyor düzenlenecek   
              $yorum_sayisi_sql = "SELECT * FROM anket_yorumlar WHERE anket_id = '$anket_no'";   
                $yorumlar_baglan = mysqli_query($baglan, $yorum_sayisi_sql);   
                  $yorumlar_sayisi = mysqli_num_rows($yorumlar_baglan);

            echo "<div id='anket_gonderileri_profil' style='top: -10px;'>";
            echo "<div id='anket_gonderi_profil_resmi'><img src='$profil_resmi'></div>";
            echo "<div id='anket_gonderi_kullanici_bilgileri'><span><a href='$site_url/profil/$get_kadi'>$get_kadi</a></span><br><span>$adsoyad</span></div>";
            echo "<div id='anket_gonderi_bilgileri'><span><a href='$site_url/etiket/$etiket'>#$etiket</a></span> <span><a href='$site_url/anket/$anket_no' title='$anket_no'><i class='fa fa-clock'></i> ".tarih_duzenle($anket_tarih)."</a></span><a href='$site_url/anket/$anket_no' title='$anket_no'><span> <i class='fas fa-comments'></i> $yorumlar_sayisi</span></a></div>";
            echo "<div id='anket_begeni_dbegeni'><span onClick='begenveyabegenmejs($anket_no,1)' class='begen1-$anket_no'><i class='fa fa-heart'></i> ".anket_begeni_cek($baglan, $anket_no)."</span> <span onClick='begenveyabegenmejs($anket_no,2)' class='begen2-$anket_no'><i class='fa fa-heart-broken'></i> ".anket_dbegeni_cek($baglan ,$anket_no)."</span>";
             echo "</div>";
            anket_sonuclari($baglan, $anket_no, $soru_sayisi);
            echo "<div id='anket_aciklama'><span>$anket_aciklama</span></div>";
            if ($video == 0){
              anket_secenek_cek_resim($baglan, $url, $cevap, $anket_no, $soru_sayisi);
            }else{
                anket_secenek_cek_video($baglan, $url, $cevap, $anket_no ,$soru_sayisi);
            }
            echo "</div>";
          }
          echo "<div id='anket_gonderileri_profil'><div id='anket_paylasilmamis_profil' style='text-align: center;'>";
          if($sayfa != 1) echo ' <a href="profil/'.$get_kadi.'/1"><i class="fas fa-angle-left"></i></a> ';
          if($sayfa != 1) echo ' <a href="profil/'.$get_kadi.'/'.($sayfa-1).'"><i class="fas fa-angle-left"></i><i class="fas fa-angle-left"></i></a> ';

          for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
              if($sayfa == $s) {
                  echo ' <i class="fa fa-home"></i> ';
              } else {
                  echo '<a href="profil/'.$get_kadi.'/'.$s.'">'.$s.'</a> ';
              }
          }

          if($sayfa != $toplam_sayfa) echo ' <a href="profil/'.$get_kadi.'/'.($sayfa+1).'"><i class="fas fa-angle-right"></i></a> ';
          if($sayfa != $toplam_sayfa) echo ' <a href="profil/'.$get_kadi.'/'.$toplam_sayfa.'"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></a>';
          echo "</div></div>";
        }
    }

  }
}

function profil_hesap_aktifmi($baglan, $session_kadi){
  $hesap_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$session_kadi'";
  if ($hesap_baglan = mysqli_query($baglan, $hesap_sql)) {
    $aktifmi_cek = mysqli_fetch_array($hesap_baglan);
    $aktifmi = $aktifmi_cek["aktif"];
    if ($aktifmi == "0") {
      return FALSE;
    }else{
      return TRUE;
    }
  }
}

function profil_ad_soyad_cek($baglan, $get_kadi){
  $hesap_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$get_kadi'";
  if ($hesap_baglan = mysqli_query($baglan, $hesap_sql)) {
    $adsad_cek = mysqli_fetch_array($hesap_baglan);
    $ad = $adsad_cek["ad"];
    $sad = $adsad_cek["soyad"];
    return $ad.' '.$sad;
  }
}

function profil_kullanici_bilgileri_cek($baglan, $get_kadi){
  $hesap_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$get_kadi'";
  $takip_edilen_sql = "SELECT * FROM urhoba_takip WHERE takip_eden = '$get_kadi' AND takip_durumu='1'";
  $takip_edenler_sql = "SELECT * FROM urhoba_takip WHERE takip_edilen='$get_kadi' AND takip_durumu='1'";
  if ($hesap_baglan = mysqli_query($baglan, $hesap_sql) AND $takip_edilen_baglan = mysqli_query($baglan, $takip_edilen_sql) AND $takip_eden_baglan = mysqli_query($baglan, $takip_edenler_sql)) {
    $bilgi_cek = mysqli_fetch_array($hesap_baglan);
    $hakkinda_1 = $bilgi_cek["hakkinda"];
    $kayit_tarihi = $bilgi_cek["kayit_tarihi"];
    $takip_edenler = mysqli_num_rows($takip_eden_baglan);
    $takip_edilen = mysqli_num_rows($takip_edilen_baglan);
    if (empty($hakkinda_1)) {
      $hakkinda_1 = $get_kadi." Kendisi hakkında hiçbir bilgi vermemiş.";
    }
    if($takip_edenler == "0"){
      $takip_edenler = $get_kadi. " Kimse tarafından takip edilmiyor.";
    }
    if ($takip_edilen == "0") {
      $takip_edilen = $get_kadi. " Kimseyi takip etmiyor.";
    }
    $hakkinda = "<h3><i class='fas fa-address-book'></i> Hakkımda</h3><span>".$hakkinda_1."</span>
    <h3><i class='fas fa-clock'></i> Hesap oluturulma tarihi</h3><span>".tarih_duzenle($kayit_tarihi)."</span>
    <h3><i class='fas fa-hiking'></i> Takip edenler</h3><span>".$takip_edenler."</span>
    <h3><i class='fas fa-user-secret'></i> Takip edilenler</h3><span>".$takip_edilen."</span><h3></h3>";
    return $hakkinda;
  }
}

function anasayfa_etiket_cek($baglan, $site_url,$etiket_limit){
  $anketler_sql = "SELECT * FROM urhoba_anketler";
  if($anketler_baglan = mysqli_query($baglan, $anketler_sql)){
    $i = "1";
    while($anket_etiket_cek = mysqli_fetch_array($anketler_baglan)){
      $i++;
      $a[$i] = $anket_etiket_cek["etiket"];
      
    }
    if(empty($a)){
      echo "Şu anda gündemde hiçbir etiket bulunmuyor. <i class='fas fa-sad-cry'></i>";
    }else{
      $a2= array_count_values($a);
      arsort($a2);
      $count = "0";
      foreach($a2 as $x => $y) { 
        // $y ile sayısını gösterebilirsin.
        echo(" <a href='$site_url/etiket/$x'>#$x</a>");
        $count++;
        if($count >= $etiket_limit){
          break;
        }
      }
    }


  }
}

function video_url_duzenle($url){
  if (empty($url)) {
    $a = "";
    return $a;
  }else{
    $eski = array("www.youtube.com/watch?v=","youtu.be/");
    $yeni = array("www.youtube.com/embed/","youtube.com/embed/");
    $degistir = str_replace($eski, $yeni ,$url);
    return $degistir;
  }
}

function dosya_uzantisi($file){
  $ext = pathinfo($file);
  return $ext['extension'];
}

function resim_yukle($site_url,$file_resim,$session_kadi,$resim_konum_neresi){
  $resim_konum = "resimler/$session_kadi/$resim_konum_neresi";
  if(empty($file_resim["name"])){
      $a = "";
      return $a;
  }else{
      if(file_exists($resim_konum)){
      $uzanti= array('image/jpeg','image/jpg','image/png','image/x-png','image/gif');
      if(in_array(strtolower($file_resim['type']),$uzanti)){
          $uzantial = dosya_uzantisi($file_resim["name"]);
          $random_karakter = random_karakter("72");
          $resim_url = $site_url."/".$resim_konum."/$random_karakter.".$uzantial;
          move_uploaded_file($file_resim['tmp_name'],"./$resim_konum/$random_karakter.$uzantial");
          return $resim_url;
      }else{
          $a = "Lütfen resim yüklediğinizden emin olun.";
          exit($a);
      }
  }else{
      $klasor_olustur = mkdir($resim_konum,0777, true);
      if ($klasor_olustur) {
          if(file_exists($resim_konum)){
              $uzanti= array('image/jpeg','image/jpg','image/png','image/x-png','image/gif');
              if(in_array(strtolower($file_resim['type']),$uzanti)){
                  $uzantial = dosya_uzantisi($file_resim["name"]);
                  $resim_url = $site_url."/".$resim_konum."/$random_karakter.".$uzantial;
                  move_uploaded_file($file_resim['tmp_name'],"./$resim_konum/$random_karakter.$uzantial");
                  return $resim_url;
              }else{
                  $a = "Lütfen resim yüklediğinizden emin olun.";
                  exit($a);
              }
      }
  }
}
}}


function anket_gonder($baglan, $site_url, $cevaplar, $resimler, $aciklama, $video, $session_kadi, $session_id, $etiket, $upload, $yuklenen_resimler){
  if (karakter_kontrol($etiket)) {
  if(!empty($session_kadi) AND !empty($session_id)){
    $hesap_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi ='$session_kadi' AND id='$session_id'";
    if ($hesap_baglan = mysqli_query($baglan, $hesap_sql)) {
      $aktifmi_cek = mysqli_fetch_array($hesap_baglan);
      $aktifmi = $aktifmi_cek["aktif"];
      if ($aktifmi == "1") {
        if($upload == "0"){
          if(empty($resimler[0]) OR empty($resimler[1])){
            echo "<span>Lütfen resim url kısmını boş bırakmayın! <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
            echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
            header('Refresh: 3; url='.$site_url.'');
          }else{
            if ($video == "0") {
              // Resim
              for ($i=0; $i < count(array_filter($resimler)) ; $i++) {
                if (resim_kontrol($resimler[$i])) {
                  if ($i = count(array_filter($resimler))-1) {
                    $soru_sayisi = count(array_filter($resimler));
                    $resimler_inik = array(url_resim_indir($site_url,$resimler[0],$session_kadi,"anket"),url_resim_indir($site_url,$resimler[1],$session_kadi,"anket"),url_resim_indir($site_url,$resimler[2],$session_kadi,"anket"),url_resim_indir($site_url,$resimler[3],$session_kadi,"anket"),url_resim_indir($site_url,$resimler[4],$session_kadi,"anket"));
                    $sql = "INSERT INTO urhoba_anketler(anket_sahibi_id,anket_sahibi_nick,anket_aciklama,anket_video,soru_sayi,cevap1,cevap2,cevap3,cevap4,cevap5,url1,url2,url3,url4,url5,etiket) VALUES('$session_id', '$session_kadi', '$aciklama','$video','$soru_sayisi','$cevaplar[0]','$cevaplar[1]','$cevaplar[2]','$cevaplar[3]','$cevaplar[4]','$resimler_inik[0]','$resimler_inik[1]','$resimler_inik[2]','$resimler_inik[3]','$resimler_inik[4]','$etiket')";
                    if ($anket_gonder_baglan = mysqli_query($baglan, $sql)) {
                      echo "<span>Başarılı bir şekilde anketiniz gönderildi. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
                      echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
                      header('Refresh: 3; url='.$site_url.'');
                    }else{
                      echo "<span>Lütfen daha sonra tekrar deneyin! <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
                      echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
                      header('Refresh: 3; url='.$site_url.'');
                    }
                  }
                }else{
                  echo "<span>Lütfen resim bağlantınızı kontrol edin. Resim için şimdilik sadecek 'jpg, png, gif ve jpeg' dosya türlerini destekliyoruz. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
                  echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
                  header('Refresh: 3; url='.$site_url.'');
                  break;
                }
              }
            }else if($video == "1"){
              for ($i=0; $i < count(array_filter($resimler))  ; $i++) {
                if (video_kontrol($resimler[$i])) {
                  if ($i = count(array_filter($resimler))-1) {
                    $soru_sayisi = count(array_filter($resimler));
                    $sql = "INSERT INTO urhoba_anketler(anket_sahibi_id,anket_sahibi_nick,anket_aciklama,anket_video,soru_sayi,cevap1,cevap2,cevap3,cevap4,cevap5,url1,url2,url3,url4,url5,etiket) VALUES('$session_id', '$session_kadi', '$aciklama','$video','$soru_sayisi','$cevaplar[0]','$cevaplar[1]','$cevaplar[2]','$cevaplar[3]','$cevaplar[4]','".video_url_duzenle($resimler[0])."','".video_url_duzenle($resimler[1])."','".video_url_duzenle($resimler[2])."','".video_url_duzenle($resimler[3])."','".video_url_duzenle($resimler[4])."','$etiket')";
                    if ($anket_gonder_baglan = mysqli_query($baglan, $sql)) {
                      echo "<span>Başarılı bir şekilde anketiniz gönderildi. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
                      echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
                      header('Refresh: 3; url='.$site_url.'');
                    }else{
                      echo "<span>Lütfen daha sonra tekrar deneyin! <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
                      echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
                      header('Refresh: 3; url='.$site_url.'');
                    }
    
                  }
                }else{
                  echo "<span>Lütfen video bağlantınızı kontrol edin. Video için şimdilik sadecek 'youtube' üzerinden videoları destekliyoruz. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
                  echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
                  header('Refresh: 3; url='.$site_url.'');
                  break;
                }
              }
            }
          }

        
        }else if($upload == "1"){
           if(empty($yuklenen_resimler[0]["name"]) OR empty($yuklenen_resimler[1]["name"])){
            echo "<span>Lütfen resim dosyanızı boş bırakmayın! <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
            echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
            header('Refresh: 3; url='.$site_url.'');
           }else{
            $resimler_inik = array(resim_yukle($site_url,$yuklenen_resimler["0"],$session_kadi,"anket"),resim_yukle($site_url,$yuklenen_resimler["1"],$session_kadi,"anket"),resim_yukle($site_url,$yuklenen_resimler["2"],$session_kadi,"anket"),resim_yukle($site_url,$yuklenen_resimler["3"],$session_kadi,"anket"),resim_yukle($site_url,$yuklenen_resimler["4"],$session_kadi,"anket"));
            for ($i=0; $i < count(array_filter($resimler_inik)) ; $i++) {
              if (resim_kontrol(dosya_uzantisi($yuklenen_resimler[$i]["name"]))) {
                if ($i = count(array_filter($resimler_inik))-1) {
                  $soru_sayisi = count(array_filter($resimler_inik));
                     $sql = "INSERT INTO urhoba_anketler(anket_sahibi_id,anket_sahibi_nick,anket_aciklama,anket_video,soru_sayi,cevap1,cevap2,cevap3,cevap4,cevap5,url1,url2,url3,url4,url5,etiket) VALUES('$session_id', '$session_kadi', '$aciklama','$video','$soru_sayisi','$cevaplar[0]','$cevaplar[1]','$cevaplar[2]','$cevaplar[3]','$cevaplar[4]','$resimler_inik[0]','$resimler_inik[1]','$resimler_inik[2]','$resimler_inik[3]','$resimler_inik[4]','$etiket')";
                  if ($anket_gonder_baglan = mysqli_query($baglan, $sql)) {
                    echo "<span>Başarılı bir şekilde anketiniz gönderildi. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
                    echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
                    header('Refresh: 3; url='.$site_url.'');
                  }else{
                    echo "<span>Lütfen daha sonra tekrar deneyin! <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
                    echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
                    header('Refresh: 3; url='.$site_url.'');
                  }
                }
              }else{
                echo "<span>Lütfen resim bağlantınızı kontrol edin. Resim için şimdilik sadecek 'jpg, png, gif ve jpeg' dosya türlerini destekliyoruz. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
                echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
                header('Refresh: 3; url='.$site_url.'');
                break;
              }
            }
           }
        }


      }else{
        echo "<span>Lütfen ilk olarak hesabınızı onaylayın. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
        header('Refresh: 3; url='.$site_url.'');
      }
    }else{
      echo "<span>Basit bir hata ile karşı karşıyayız lütfen daha sonra tekrar deneyin! <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
      echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
      header('Refresh: 3; url='.$site_url.'');
    }
  }else{
    echo "<span>Lütfen ilk olarak kullanıcı girişi yapın! <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
    echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
    header('Refresh: 3; url='.$site_url.'');
  }
}else{
  echo "<span>Etiketiniz büyük karakter içeremez ve etiketinizde Türkçe karakterler veya özel karakter kullanmayın, kullanabileceğiniz özel karakterler '_' ve '.' olarak belirlenmiştir.  <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
  echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.</span>";
  header('Refresh: 3; url='.$site_url.'');
}
}

function sifre_yenile($baglan, $site_url, $site_isim, $kadi, $sifre1, $sifre2, $kontrol){
  if ($sifre1 == $sifre2) {
    $sifre = md5($sifre1);
    $hesap_sql = "UPDATE urhoba_hesaplar SET sifre ='$sifre' WHERE kullanici_adi ='$kadi' AND aktiflestirme_kodu='$kontrol'";
    if (mysqli_query($baglan, $hesap_sql)) {
      echo "Başarılı bir şekilde hesabının şifresi değiştirildi. <u><a href='$site_url/giris-yap'>Hesabınıza giriş yapmak için tıklayın.</a></u>";
      echo "<br/><br/> 3 Saniye içerisinde giriş sayfasına yönlendirileceksiniz.";
      header('Refresh: 3; url='.$site_url.'/giris-yap');
    }else{
      echo "Hay aksi bir şeyler yanlış gitti, lütfen daha sonra tekrar dene. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
      echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.";
      header('Refresh: 3; url='.$site_url.'');
    }
  }else{
    echo "Girdiğiniz şifreler birbirleri ile aynı değil! <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
    echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.";
    header('Refresh: 3; url='.$site_url.'');
  }
}

function sifremi_unuttum($baglan, $site_url, $site_isim, $site_logo, $kadi, $mail){
  $hesap_baglan_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$kadi' AND mail='$mail'";
  $hesap_baglan = mysqli_query($baglan, $hesap_baglan_sql);
  if (mysqli_num_rows($hesap_baglan) == "0") {
    echo "Böyle bir kullanıcı bulunamadı, kullanıcı adı veya mail hatalı olabilir. <u><a href='$site_url/sifremi-unuttum'> Şifrenizi unuttuysanız tıklayın.</a></u>";
    echo "<br/><br/> 3 Saniye içerisinde şifremi unuttum sayfasına yönlendirileceksiniz.";
    header('Refresh: 3; url='.$site_url.'/sifremi-unuttum');
  }else{
     $hesap_cek = mysqli_fetch_array($hesap_baglan);
      if ($kadi == $hesap_cek["kullanici_adi"] AND $mail == $hesap_cek["mail"]) {
        $dogrulama_kodu = random_karakter("32");
        $hesap_dogrulama_kodu_sql = "UPDATE urhoba_hesaplar SET aktiflestirme_kodu='$dogrulama_kodu' WHERE kullanici_adi='$kadi' AND mail='$mail'";
        if (mysqli_query($baglan, $hesap_dogrulama_kodu_sql)) {
          $sifre_yenile_url = $site_url.'/sifre-yenile/'.$kadi.'-'.$dogrulama_kodu;
          $mail_kime = $mail;
          $mail_konu = $site_isim.' Şifre yenileme istegi';
          $mail_icerik = "<html>
            <head>
              <style>
              body{
                  margin: auto;
                  width: 600px;
                  mix-height: 100%;
                  position: relative;
                  background-color: #d7722c;
                  font-family: Arial;
                  color: #FFFFFFFF;
              }
              h1{
                margin: 20px 0;
                width: 100%;
                text-align:center;
              }
              img{
                position: relative;
                width: 150px;
                height: 150px;
                margin: 10px auto 10px auto;
                display: block;
                border-radius: 7px;
                border: solid 1px #883000;
              }
              span{
              display: block;
              width: 350px;
              margin: 20px auto;
              overflow: hidden;
              }
              a{
              color: white;
              text-decoration:none;
              }

              </style>
            </head>
            <body>
            <h1>".$site_isim."</h1>
            <img src='".$site_logo."'/>
            <span>Bize bildirdiğine göre şifreni unutmuşsun, şifreni yenilemek için aşağıdaki bağlantıyı kullanabilirsin.
            <br/> <br/> <a href='".$sifre_yenile_url."'><u>Buraya tıkla</u> ve hemen şifreni yenile.</a></span>

            </body>
            </html>";
          $basari_mesaji = "Başarılı bir şekilde şifre yenileme mailiniz gönderilmiştir. <u><a href='$site_url/giris-yap'>Hesabınıza giriş yapmak için tıklayın.</a></u>";
          $hata_mesaji = "İsteginizi şu anda yerine getiremiyoruz, lütfen daha sonra tekrar deneyin. <u><a href='$site_url/sifremi-unuttum'> Şifrenizi unuttuysanız tıklayın.</a></u>";
          mail_yolla($mail_kime, $kadi,$mail_konu,$mail_icerik,$basari_mesaji,$site_isim,$hata_mesaji);
          echo "<br/><br/> 3 Saniye anasayfaya yönlendirileceksiniz.";
          header('Refresh: 3; url='.$site_url.'');
        }else{
          echo "(2)İsteginizi şu anda yerine getiremiyoruz, lütfen daha sonra tekrar deneyin. <u><a href='$site_url/sifremi-unuttum'> Şifrenizi unuttuysanız tıklayın.</a></u>";
          echo "<br/><br/> 3 Saniye içerisinde şifremi unuttum sayfasına yönlendirileceksiniz.";
          header('Refresh: 3; url='.$site_url.'/sifremi-unuttum');
        }

      }
  }
}

function hesap_onayla($baglan, $site_url, $kadi, $kontrol){
  if(!empty($kadi) AND !empty($kontrol)){
      $hesap_cek_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$kadi'";
      $hesap_cek_baglan = mysqli_query($baglan, $hesap_cek_sql);
      $hesap_cek = mysqli_fetch_array($hesap_cek_baglan);
      if ($hesap_cek["aktif"] == "1") {
        echo "Hesap zaten daha önce aktifleştirilmiş. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.";
        header('Refresh: 3; url='.$site_url.'');
      }else{
        if ($kadi == $hesap_cek["kullanici_adi"] AND $kontrol == $hesap_cek["aktiflestirme_kodu"]) {
          $hesap_aktiflestir_sql = "UPDATE urhoba_hesaplar SET aktif='1' WHERE kullanici_adi='$kadi'";
          $hesap_aktiflestir = mysqli_query($baglan, $hesap_aktiflestir_sql);
          if ($hesap_aktiflestir) {
            echo "Hesabınız başarılı bir şekilde aktifleştirilmiştir. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
            echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.";
            header('Refresh: 3; url='.$site_url.'');
          }else{
            echo "Sunucu kaynaklı bir hatadan dolayı şu anda hesabınızı aktifleştiremiyoruz! Lütfen daha sonra tekrar deneyin. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
            echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.";
            header('Refresh: 3; url='.$site_url.'');
          }
        }else{
          echo "Kontrol kodunuz veya kullanıcı adınız hatalı olduğu için hesabınız şimdilik aktif hale getirilemiyor! <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
          echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.";
          header('Refresh: 3; url='.$site_url.'');
        }
      }


  }else{
    echo "Lütfen buraya direkt giriş yapmaya çalışmayın <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
    echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.";
    header('Refresh: 3; url='.$site_url.'');
  }
}

function giris_yap($baglan, $site_url, $kadi, $sifre){
  if(!empty($kadi) OR !empty($sifre)){
     $kadi = strtolower($kadi);
      $sifre = md5($sifre);
      $kullanici_cek_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$kadi' AND sifre='$sifre'";
      $kullanici_cek_baglan = mysqli_query($baglan, $kullanici_cek_sql);
      $kullanici_cek = mysqli_fetch_array($kullanici_cek_baglan);
      if ($kadi == $kullanici_cek["kullanici_adi"] AND $sifre == $kullanici_cek["sifre"]) {
        $_SESSION["kadi"] = $kullanici_cek["kullanici_adi"];
        $_SESSION["id"] =  $kullanici_cek["id"];
        $_SESSION["sifre"] =$kullanici_cek["sifre"] ;
        echo "Başarılı bir şekilde giriş yapıldı. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.";
        header('Refresh: 3; url='.$site_url.'');
      }else{
        echo "Kullanıcı adınız veya şifreniz hatalı! <u><a href='$site_url/giris-yap'>Hesabınıza giriş yapmak için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde giriş sayfasına yönlendirileceksiniz.";
        header('Refresh: 3; url='.$site_url.'/giris-yap');
      }


  }else{
    echo "Lütfen boş yer bırakamyın! <u><a href='$site_url/giris-yap'>Hesabınıza giriş yapmak için tıklayın.</a></u>";
    echo "<br/><br/> 3 Saniye içerisinde giriş sayfasına yönlendirileceksiniz.";
    header('Refresh: 3; url='.$site_url.'/giris-yap');
  }
}

function hesap_olustur($baglan, $site_url, $site_isim, $site_logo, $kadi , $ad , $soyad , $mail , $sifre, $ip){
  if (!empty($kadi) OR !empty($ad) OR !empty($soyad) OR !empty($mail) OR !empty($sifre)) {
    if (karakter_kontrol($kadi)) {
    if (mail_kontrol($mail, $baglan) == "0") {
      echo "Lütfen geçerli bir mail girin. <u><a href='$site_url/hesap-olustur'>Hesap açmak için tıklayın.</a></u>";
      echo "<br/><br/> 3 Saniye içerisinde hesap oluşturma sayfasına yönlendirileceksiniz.";
      header('Refresh: 3; url='.$site_url.'/hesap-olustur');
    }else{
      $hesap_cek_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi ='$kadi' OR mail = '$mail'";
      $hesap_baglan = mysqli_query($baglan, $hesap_cek_sql);
      if (mysqli_num_rows($hesap_baglan) != 0) {
        echo "Kullanıcı adı veya mail ile daha önce bir hesap oluşturulmuş. <u><a href='$site_url/hesap-olustur'>Hesap açmak için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde hesap oluşturma sayfasına yönlendirileceksiniz.";
        header('Refresh: 3; url='.$site_url.'/hesap-olustur');
      }else{
        $sifre = md5($sifre);
        $onay_kontrol = random_karakter("32");
        $hesap_olustur_sql = "INSERT INTO urhoba_hesaplar(kullanici_adi, ad, soyad, sifre, mail, ip, aktiflestirme_kodu) VALUES('$kadi', '$ad', '$soyad', '$sifre', '$mail', '$ip','$onay_kontrol')";
        if (mysqli_query($baglan, $hesap_olustur_sql)) {

          $hesap_onay_link = $site_url.'/hesap-onay/'.$kadi.'-'.$onay_kontrol;
          $mail_kime = $mail;
          $mail_konu = $site_isim ."'a Hoşgeldin ". $kadi;
          $mail_icerik = "  		  <html>
          <head>
            <style>
            body{
                margin: auto;
                width: 600px;
                mix-height: 100%;
                position: relative;
                background-color: #d7722c;
                font-family: Arial;
                color: #FFFFFFFF;
            }
            h1{
              margin: 20px 0;
              width: 100%;
              text-align:center;
            }
            img{
              position: relative;
              width: 150px;
              height: 150px;
              margin: 10px auto 10px auto;
              display: block;
              border-radius: 7px;
              border: solid 1px #883000;
            }
            span{
            display: block;
            width: 350px;
            margin: 20px auto;
            overflow: hidden;
            }
            a{
            color: white;
            text-decoration:none;
            }

            </style>
          </head>
          <body>
          <h1>".$site_isim."</h1>
          <img src='".$site_logo."'/>
          <span>Sitemize hoş geldin <b>".$kadi."</b> başarılı bir şekilde hesabın oluşuturuldu ve kullanıma hazır sayılır. <br/> <br/> Hesabını kullanmadan önce yapman gereken son bir işlem kaldı, o da aşağıdaki hesabımı onayla butonuna basmak ve hesabını hemen aktif hale getirmek. <br/> <br/> <b><a href='".$hesap_onay_link."'>Hesabımı aktif hale getir!</a></b> <br/> <br/></span>

          </body>
          </html>";
          $basari_mesaji = "Onay mailiniz yollandı ve ";
          $hata_mesaji = "";
          mail_yolla($mail_kime, $kadi,$mail_konu,$mail_icerik,$basari_mesaji,$site_isim,$hata_mesaji);


          echo "Başarılı bir şekilde hesabınız oluşturuldu. <u><a href='$site_url'>Anasayfaya gitmek için tıklayın.</a></u>";
          echo "<br/><br/> 3 Saniye içerisinde anasayfaya yönlendirileceksiniz.";
          header('Refresh: 3; url='.$site_url.'');
          $hesap_session_sql = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi = '$kadi'";
          $hesap_session_baglan = mysqli_query($baglan, $hesap_session_sql);
          $hesap_session_cek = mysqli_fetch_array($hesap_session_baglan);
          $_SESSION["kadi"] = $hesap_session_cek["kullanici_adi"];
          $_SESSION["id"] = $hesap_session_cek["id"];
          $_SESSION["sifre"] = $hesap_session_cek["sifre"];
        }else{
          echo "Lütfen daha sonra tekrar deneyin. <u><a href='$site_url/hesap-olustur'>Hesap açmak için tıklayın.</a></u>";
          echo "<br/><br/> 3 Saniye içerisinde hesap oluşturma sayfasına yönlendirileceksiniz.";
          header('Refresh: 3; url='.$site_url.'/hesap-olustur');
        }
      }
    }
  }else{
    echo "Lütfen kullanıcı adınız büyük karakter içeremez ve kullanıcı adınızda Türkçe karakterler veya özel karakter kullanmayın, kullanabileceğiniz özel karakterler '_' ve '.' olarak belirlenmiştir. <u><a href='$site_url/hesap-olustur'>Hesap açmak için tıklayın.</a></u>";
    echo "<br/><br/> 3 Saniye içerisinde hesap oluşturma sayfasına yönlendirileceksiniz.";
    header('Refresh: 3; url='.$site_url.'/hesap-olustur');
  }
  }else{
    echo "Lütfen boş yer bırakmayın! <u><a href='$site_url/hesap-olustur'>Hesap açmak için tıklayın.</a></u>";
    echo "<br/><br/> 3 Saniye içerisinde hesap oluşturma sayfasına yönlendirileceksiniz.";
    header('Refresh: 3; url='.$site_url.'/hesap-olustur');
  }
}


function bildirim_butonu($baglan, $session_kadi, $session_id){
  $bildirim_sql = "SELECT * FROM bildirimler WHERE bildirim_sahibi_id = '$session_id' AND bildirim_sahibi_nick ='$session_kadi' ORDER BY bild_id DESC";
  $bildirimler_baglan = mysqli_query($baglan, $bildirim_sql);
  $bildirim_varmi = mysqli_num_rows($bildirimler_baglan);
  if($bildirim_varmi == "0"){
    echo '<span title="Bildirimler" onclick="bildirim_goster()"><i id="bildirim_ac_kapa" class="far fa-bell"></i></span>';
  }else{
    echo '<span title="Bildirimler" onclick="bildirim_goster()"><i id="bildirim_ac_kapa" class="fas fa-bell"></i></span>';
  }
  
  
}

function bildirim_sil($baglan, $session_kadi, $session_id){
  if(empty($session_kadi) OR empty($session_id)){
    echo "<p>Bildirimleri görmek için kullanıcı girişi yapmanız gerekiyor.</p>";
  }else{
    $bildirim_sil_sql = "DELETE FROM bildirimler WHERE bildirim_sahibi_id = '$session_id' AND bildirim_sahibi_nick ='$session_kadi'";
    $bildirim_sil = mysqli_query($baglan, $bildirim_sil_sql);
    if($bildirim_sil){
      echo "<p>Bütün bildirimleriniz silindi. <i class='fas fa-laugh-beam'></i></p>";
    }else{
      echo "<p>Şu anda bildirimler silinemiyor lütfen sonra tekrar deneyin!</p>";
    }

  }
}

function bildirimleri_cek($baglan, $site_url, $session_kadi, $session_id){
  if(empty($session_kadi) OR empty($session_id)){
    echo "<p>Bildirimleri görmek için kullanıcı girişi yapmanız gerekiyor.</p>";
  }else{
    $bildirim_sql = "SELECT * FROM bildirimler WHERE bildirim_sahibi_id = '$session_id' AND bildirim_sahibi_nick ='$session_kadi' ORDER BY bild_id DESC";
    $bildirimler_baglan = mysqli_query($baglan, $bildirim_sql);
    $bildirim_varmi = mysqli_num_rows($bildirimler_baglan);
    if($bildirim_varmi == "0"){
      echo "<p>Hiç bir bildirimin yok <i class='fa fa-sad-cry'></i></p>";
    }else{
      while($bildirim_cek = mysqli_fetch_array($bildirimler_baglan)){
        echo "<a href='$site_url/anket/".$bildirim_cek["anket_id"]."'><p>".tarih_duzenle($bildirim_cek["bildirim_tarih"]).": <b>".$bildirim_cek["bildirim_icerik"]."</b> anketine <b>".$bildirim_cek["bildirim_yyapan_nick"]."</b> tarafından <i class='fas fa-comments'></i> yorum yapıldı.</p></a>";
      }
      echo "<h3 id='bildirimleri_sil' onclick='bildirimleri_sil()'>Bildirimleri temizle</h3>";
    }
  }
}

function profil_bilgilerini_guncelle($site_url,$baglan,$kadi,$id,$ad,$soyad,$mail,$pp,$kp,$dogum_tarihi,$hakkimda,$sifre, $ppupload, $kpupload){
  $hesap_kontrol = "SELECT * FROM urhoba_hesaplar WHERE kullanici_adi='$kadi' AND id='$id'";
  $hesap_kontrol_baglan = mysqli_query($baglan, $hesap_kontrol);
  $hesap_veri_cek = mysqli_fetch_array($hesap_kontrol_baglan);
  $session_kadi = $kadi;
  if(empty($ppupload["name"]) AND empty($kpupload["name"])){
  if(empty($sifre)){
  
  if ($hesap_veri_cek["profil_foto"] == $pp AND $hesap_veri_cek["kapak_foto"] == $kp) {
    $duzenle_sql = "UPDATE urhoba_hesaplar SET ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$pp', kapak_foto='$kp' WHERE kullanici_adi='$kadi' AND id='$id'";
    $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
    if ($duzenle_baglan) {
      echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
      echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
      header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
    }else{
      exit("HATA");
    }
  }else{
    if ($hesap_veri_cek["profil_foto"] == $pp){
      // kp değiştirilmiş
      $yenikp = url_resim_indir($site_url,$kp,$kadi,"profil");
      $duzenle_sql = "UPDATE urhoba_hesaplar SET ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$pp', kapak_foto='$yenikp' WHERE kullanici_adi='$kadi' AND id='$id'";
      $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
      if ($duzenle_baglan) {
        echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
        header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
      }else{
        exit("HATA");
      }
    }else{
      if ($hesap_veri_cek["kapak_foto"] == $kp) {
        // pp değiştirilmiş
        $yenipp = url_resim_indir($site_url,$pp,$kadi,"profil");
        $duzenle_sql = "UPDATE urhoba_hesaplar SET ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$yenipp', kapak_foto='$kp' WHERE kullanici_adi='$kadi' AND id='$id'";
        $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
        if ($duzenle_baglan) {
          echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
          echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
          header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
        }else{
          exit("HATA");
        }
      }else{
        $yenikp = url_resim_indir($site_url,$kp,$kadi, "profil");
        $yenipp = url_resim_indir($site_url,$pp, $kadi, "profil");
        $duzenle_sql = "UPDATE urhoba_hesaplar SET ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$yenipp', kapak_foto='$yenikp' WHERE kullanici_adi='$kadi' AND id='$id'";
        $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
        if ($duzenle_baglan) {
          echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
          echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
          header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
        }else{
          exit("HATA");
        }
      }
    }
  }
}else{
  $pass = md5($sifre);
  if ($hesap_veri_cek["profil_foto"] == $pp AND $hesap_veri_cek["kapak_foto"] == $kp) {
    $duzenle_sql = "UPDATE urhoba_hesaplar SET sifre='$pass', ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$pp', kapak_foto='$kp' WHERE kullanici_adi='$kadi' AND id='$id'";
    $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
    if ($duzenle_baglan) {
      echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
      echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
      header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
    }else{
      exit("HATA");
    }
  }else{
    if ($hesap_veri_cek["profil_foto"] == $pp){
      // kp değiştirilmiş
      $yenikp = url_resim_indir($site_url,$kp,$kadi,"profil");
      $duzenle_sql = "UPDATE urhoba_hesaplar SET sifre='$pass', ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$pp', kapak_foto='$yenikp' WHERE kullanici_adi='$kadi' AND id='$id'";
      $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
      if ($duzenle_baglan) {
        echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
        echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
        header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
      }else{
        exit("HATA");
      }
    }else{
      if ($hesap_veri_cek["kapak_foto"] == $kp) {
        // pp değiştirilmiş
        $yenipp = url_resim_indir($site_url,$pp,$kadi,"profil");
        $duzenle_sql = "UPDATE urhoba_hesaplar SET sifre='$pass', ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$yenipp', kapak_foto='$kp' WHERE kullanici_adi='$kadi' AND id='$id'";
        $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
        if ($duzenle_baglan) {
          echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
          echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
          header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
        }else{
          exit("HATA");
        }
      }else{
        $yenikp = url_resim_indir($site_url,$kp,$kadi, "profil");
        $yenipp = url_resim_indir($site_url,$pp, $kadi, "profil");
        $duzenle_sql = "UPDATE urhoba_hesaplar SET sifre='$pass', ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$yenipp', kapak_foto='$yenikp' WHERE kullanici_adi='$kadi' AND id='$id'";
        $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
        if ($duzenle_baglan) {
          echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
          echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
          header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
        }else{
          exit("HATA");
        }
      }
    }


  }
}
}else{
    if(empty($sifre)){
      if(empty($ppupload["name"])){
        // kp yüklenmiş
        $kpuploadfoto = resim_yukle($site_url,$kpupload,$session_kadi,"profil");
        $duzenle_sql = "UPDATE urhoba_hesaplar SET ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$pp', kapak_foto='$kpuploadfoto' WHERE kullanici_adi='$kadi' AND id='$id'";
        $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
        if ($duzenle_baglan) {
          echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
          echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
          header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
        }else{
          exit("HATA");
        }

      }else{
        if(empty($kpupload["name"])){
          // pp yüklenmiş
          $ppuploadfoto = resim_yukle($site_url,$ppupload,$session_kadi,"anket");
          $duzenle_sql = "UPDATE urhoba_hesaplar SET ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$ppuploadfoto', kapak_foto='$kp' WHERE kullanici_adi='$kadi' AND id='$id'";
          $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
          if ($duzenle_baglan) {
            echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
            echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
            header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
          }else{
            exit("HATA");
          }
            

        }else{
          // 2side aynanda yüklenmiş
          $kpuploadfoto = resim_yukle($site_url,$kpupload,$session_kadi,"profil");
          $ppuploadfoto = resim_yukle($site_url,$ppupload,$session_kadi,"anket");

          $duzenle_sql = "UPDATE urhoba_hesaplar SET ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$ppuploadfoto', kapak_foto='$kpuploadfoto' WHERE kullanici_adi='$kadi' AND id='$id'";
          $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
          if ($duzenle_baglan) {
            echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
            echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
            header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
          }else{
            exit("HATA");
          }
        }
      }
    }else{
      $pass = md5($sifre);

      if(empty($ppupload["name"])){
        // kp yüklenmiş
        $kpuploadfoto = resim_yukle($site_url,$kpupload,$session_kadi,"profil");
        $duzenle_sql = "UPDATE urhoba_hesaplar SET sifre='$pass', ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$pp', kapak_foto='$kpuploadfoto' WHERE kullanici_adi='$kadi' AND id='$id'";
        $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
        if ($duzenle_baglan) {
          echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
          echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
          header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
        }else{
          exit("HATA");
        }

      }else{
        if(empty($kpupload["name"])){
          // pp yüklenmiş
          $ppuploadfoto = resim_yukle($site_url,$ppupload,$session_kadi,"anket");
          $duzenle_sql = "UPDATE urhoba_hesaplar SET sifre='$pass', ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$ppuploadfoto', kapak_foto='$kp' WHERE kullanici_adi='$kadi' AND id='$id'";
          $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
          if ($duzenle_baglan) {
            echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
            echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
            header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
          }else{
            exit("HATA");
          }
            

        }else{
          // 2side aynanda yüklenmiş
          $kpuploadfoto = resim_yukle($site_url,$kpupload,$session_kadi,"profil");
          $ppuploadfoto = resim_yukle($site_url,$ppupload,$session_kadi,"anket");

          $duzenle_sql = "UPDATE urhoba_hesaplar SET sifre='$pass', ad='$ad', soyad='$soyad', mail='$mail', dogum_tarihi='$dogum_tarihi', hakkinda='$hakkimda', profil_foto='$ppuploadfoto', kapak_foto='$kpuploadfoto' WHERE kullanici_adi='$kadi' AND id='$id'";
          $duzenle_baglan = mysqli_query($baglan, $duzenle_sql);
          if ($duzenle_baglan) {
            echo "Bilgileriniz başarılı bir şekilde güncellendi. <u><a href='$site_url/profil/$kadi'>Profilinize gitmek için tıklayın.</a></u>";
            echo "<br/><br/> 3 Saniye içerisinde profil sayfanıza yönlendirileceksiniz.";
            header('Refresh: 3; url='.$site_url.'/profil/'.$kadi.'');
          }else{
            exit("HATA");
          }
        }
      }


    }

}
}

function mobil_kontrol($site_url){
  $mobil_link_tarama = $_SERVER["REQUEST_URI"];
  if(strstr($mobil_link_tarama , "/mobil")){
  //   echo "mobildesin";
  }else{
  $mobil_cihazlar = array(
    "Android",
    "iPod",
    "iPad",
    "iPhone",
    "webOS",
    "BlackBerry",
    "Windows Phone",
    "Opera Mini",
    "IEMobile",
    "Mobile"
  );
  $site_adresive_konum_mobil = $site_url.'/mobil'.$_SERVER["REQUEST_URI"];
  $site_adresive_konum = $site_url.$_SERVER["REQUEST_URI"];
if(preg_match('@('.implode('|',$mobil_cihazlar).')@si',$_SERVER['HTTP_USER_AGENT'])){
  // mobil sayfaya 
  header('Refresh: 0; url='.$site_adresive_konum_mobil.'');
  
}else{
  // mobil olmayan sayfaya yönlendir
}
}
}


 ?>
