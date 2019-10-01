<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  exit("Giriş Yasak!");
}
if (empty($session_kadi) OR empty($session_id)) {
  ?>
    <!-- Alt taraf giriş yapılmamış -->
    <footer>
      <div id="footer_orta">
          <div id="footer_hesaplar">
            <?PHP footer_hesap_cek($baglan, $site_url); ?>
          </div>
          <div id="footer_copyright">
            <span><?PHP echo $site_footer_yazi; ?></span>
          </div>
      </div>
    </footer>
    <!-- Alt taraf giriş yapılmamış biter -->
  <?PHP
  }else{
    // Giriş yapılmış hesaplar için footer
    ?>
    <footer>
      <div id="footer_orta">
          <div id="footer_hesaplar">
            <?PHP footer_hesap_cek($baglan, $site_url); ?>
          </div>
          <div id="footer_copyright">
            <span><?PHP echo $site_footer_yazi; ?></span>
          </div>
      </div>
    </footer>
    <?PHP
  }

  ?>
