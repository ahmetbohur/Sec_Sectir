<?PHP
include_once "config/fonksiyonlar.php";
if(empty($_GET["sayfa"])){
$sayfa_kac = "0";
}else{
$sayfa_kac = htmlspecialchars($_GET["sayfa"]);
}

$sayfada = 10000; // sayfada gösterilecek içerik miktarını belirtiyoruz.

$sorgu = mysqli_query($baglan,"SELECT COUNT(*) AS toplam FROM urhoba_hesaplar");
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

$sql = "SELECT * FROM urhoba_hesaplar ORDER BY id DESC LIMIT $limit,$sayfada";
$baglan_sql = mysqli_query($baglan, $sql);
?>
<?php header('Content-type: application/xml; ',true);  ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">


<?php while($cek = mysqli_fetch_assoc($baglan_sql)) { ?>

    <url>
        <loc><?php echo $site_url."/profil/".$cek["kullanici_adi"]; ?></loc>
        <lastmod><?PHP echo ' '.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").' 00:00';?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

<?php } ?>

</urlset>