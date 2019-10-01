<?PHP
include_once "config/fonksiyonlar.php";

?>
<?php header('Content-type: application/xml; ',true);  ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<url>
        <loc><?php echo $site_url; ?></loc>
        <lastmod><?PHP echo ' '.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").' 00:00';?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>

    
<url>
        <loc><?php echo $site_url; ?>/hakkimizda</loc>
        <lastmod><?PHP echo ' '.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").' 00:00';?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc><?php echo $site_url; ?>/kullanim-kosullari</loc>
        <lastmod><?PHP echo ' '.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").' 00:00';?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc><?php echo $site_url; ?>/giris-yap</loc>
        <lastmod><?PHP echo ' '.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").' 00:00';?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc><?php echo $site_url; ?>/sifremi-unuttum</loc>
        <lastmod><?PHP echo ' '.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").' 00:00';?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc><?php echo $site_url; ?>/hesap-olustur</loc>
        <lastmod><?PHP echo ' '.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").' 00:00';?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    </urlset>