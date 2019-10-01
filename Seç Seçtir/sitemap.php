<?PHP
include_once "config/fonksiyonlar.php";

$limit = 10000;

$sorgu_anket = mysqli_query($baglan,"SELECT COUNT(*) AS toplam FROM urhoba_anketler");
$sonuc_anket = mysqli_fetch_assoc($sorgu_anket);
$toplam_icerik_anket = $sonuc_anket['toplam'];

$sorgu_hesap = mysqli_query($baglan,"SELECT COUNT(*) AS toplam FROM urhoba_hesaplar");
$sonuc_hesap = mysqli_fetch_assoc($sorgu_hesap);
$toplam_icerik_hesap = $sonuc_hesap['toplam'];


?>
<?php header('Content-type: application/xml; ',true);  ?>
   <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <?PHP for ($i=0; $i < $toplam_icerik_hesap/$limit ; $i++) { ?>
   <sitemap>
      <loc><?PHP echo $site_url; ?>/sitemap-hesaplar.xml?sayfa=<?PHP echo $i+1; ?></loc>
      <lastmod><?PHP echo ' '.date("Y").'-'.date("m").'-'.date("d").' ';?></lastmod>
   </sitemap>
   <?PHP } ?>
  <?PHP for ($i=0; $i < $toplam_icerik_anket/$limit ; $i++) { ?>
   <sitemap>
      <loc><?PHP echo $site_url; ?>/sitemap-anketler.xml?sayfa=<?PHP echo $i+1; ?></loc>
      <lastmod><?PHP echo ' '.date("Y").'-'.date("m").'-'.date("d").' ';?></lastmod>
   </sitemap>
 <?PHP } ?>
   <sitemap>
      <loc><?PHP echo $site_url; ?>/sitemap-genel.xml</loc>
      <lastmod><?PHP echo ' '.date("Y").'-'.date("m").'-'.date("d").' ';?></lastmod>
   </sitemap>
   </sitemapindex>