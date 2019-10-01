<?PHP

  if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    exit("Giriş Yasak!");
  }


  $mobil_link_tarama = $_SERVER["REQUEST_URI"];
  if(strstr($mobil_link_tarama , "/mobil")){
    if(!empty($session_kadi) AND !empty($session_id)){
      ?>
          <header>
        <div id="header_orta">
            <div id="header_yazilar_sol">
              <a title="Anasayfa" href="<?PHP echo $site_url; ?>/mobil/anasayfa"><span><i class="fa fa-home"></i></span></a>
              <a title="<?PHP echo $_SESSION["kadi"]; ?>" href="<?PHP echo $site_url.'/mobil/profil/'.$_SESSION["kadi"]; ?>"><span><i class="fa fa-user"></i></span></a>
              <?PHP bildirim_butonu($baglan, $_SESSION["kadi"], $_SESSION["id"]) ?>
              <a title="Ayarlar" href="<?PHP echo "$site_url"; ?>/mobil/ayarlar"><span><i class="fas fa-user-cog"></i></span></a>
              <a title="Çıkış yap" href="<?PHP echo $site_url; ?>/mobil/cikis"><span><i class="fas fa-sign-out-alt"></i></span></a>
              <span id="ara_ac_kapa_button" title="Neler merak ediyorsun?" onclick="ara_ac_kapa()"><i class="fas fa-search"></i></span>
            </div>
        </div>
        <div class="ara_goster" id="ara_dis" style="display:none;">
          <div id="ara_main_dis">
              <input id="aranankelime" type="text" name="ara" placeholder="Aranacak kelime"/>
              <button onclick="aramayap()"><i class="fas fa-search"></i></button>
          </div>
        </div>
        <div class="bildirimler_goster" id="bildirimler_dis" style="display: none;">
        <div id="bildirim_main_dis" class="bildirimler_ic_goster">
          <h3>Bildirimler</h3>
          <?PHP bildirimleri_cek($baglan, $site_url, $_SESSION["kadi"], $_SESSION["id"]); ?>
        </div>
        </div>
      </header> 
      <?PHP
    }else{
      ?>
   <header>
          <div id="header_orta">
              <div id="header_yazilar_sol">
                <a title="Anasayfa" href="<?PHP echo $site_url; ?>/mobil/anasayfa"><span><i class="fa fa-home"></i></span></a>
                <a title="Hakkımızda" href="/mobil/hakkimizda"><span><i class="fa fa-address-card"></i></span></a>
                <a title="Kullanım Koşulları" href="/mobil/kullanim-kosullari"><span><i class="fa fa-book"></i></span></a>
                <span id="ara_ac_kapa_button" title="Neler merak ediyorsun?" onclick="ara_ac_kapa()"><i class="fas fa-search"></i></span>
              </div>
          </div>
          <div class="ara_goster" id="ara_dis" style="display:none;">
          <div id="ara_main_dis">
              <input id="aranankelime" type="text" name="ara" placeholder="Aranacak kelime"/>
              <button onclick="aramayap()"><i class="fas fa-search"></i></button>
          </div>
        </div>
        </header>
<?PHP
    }
  }else{
  
  if (empty($session_kadi) OR empty($session_id)) {
    ?>
      <!-- Üst taraf giriş yapılmamış -->
        <header>
          <div id="header_orta">
              <div id="header_yazilar_sol">
                <a title="Anasayfa" href="<?PHP echo $site_url; ?>"><span><i class="fa fa-home"></i></span></a>
                <a title="Hakkımızda" href="/hakkimizda"><span><i class="fa fa-address-card"></i></span></a>
                <a title="Kullanım Koşulları" href="/kullanim-kosullari"><span><i class="fa fa-book"></i></span></a>
                <span id="ara_ac_kapa_button" title="Neler merak ediyorsun?" onclick="ara_ac_kapa()"><i class="fas fa-search"></i></span>
              </div>
              <div id="header_yazilar_sag">
                <h3>
                <?PHP echo "<a title='$site_isim' href='$site_url'>$site_isim <img src='/tema/ico.ico'/></a>"; ?>
                </h3>
              </div>
          </div>
          <div class="ara_goster" id="ara_dis" style="display:none;">
          <div id="ara_main_dis">
              <input id="aranankelime" type="text" name="ara" placeholder="Aranacak kelime"/>
              <button onclick="aramayap()"><i class="fas fa-search"></i></button>
          </div>
        </div>
        </header>
      <!-- Üst taraf giriş yapılmamış biter -->
    <?PHP
  }else{
    ?>
      <header>
        <div id="header_orta">
            <div id="header_yazilar_sol">
              <a title="Anasayfa" href="<?PHP echo $site_url; ?>"><span><i class="fa fa-home"></i></span></a>
              <a title="<?PHP echo $_SESSION["kadi"]; ?>" href="<?PHP echo $site_url.'/profil/'.$_SESSION["kadi"]; ?>"><span><i class="fa fa-user"></i></span></a>
              <?PHP bildirim_butonu($baglan, $_SESSION["kadi"], $_SESSION["id"]) ?>
              <a title="Ayarlar" href="<?PHP echo "$site_url"; ?>/ayarlar"><span><i class="fas fa-user-cog"></i></span></a>
              <a title="Çıkış yap" href="<?PHP echo $site_url; ?>/cikis"><span><i class="fas fa-sign-out-alt"></i></span></a>
              <span id="ara_ac_kapa_button" title="Neler merak ediyorsun?" onclick="ara_ac_kapa()"><i class="fas fa-search"></i></span>
            </div>
            <div id="header_yazilar_sag">
              <h3>
              <?PHP echo "<a title='$site_isim' href='$site_url'>$site_isim <img src='/tema/ico.ico'/></a>"; ?>
              </h3>
            </div>
        </div>
        <div class="ara_goster" id="ara_dis" style="display:none;">
          <div id="ara_main_dis">
              <input id="aranankelime" type="text" name="ara" placeholder="Aranacak kelime"/>
              <button onclick="aramayap()"><i class="fas fa-search"></i></button>
          </div>
        </div>
        <div class="bildirimler_goster" id="bildirimler_dis" style="display: none;">
        <div id="bildirim_main_dis" class="bildirimler_ic_goster">
          <h3>Bildirimler</h3>
          <?PHP bildirimleri_cek($baglan, $site_url, $_SESSION["kadi"], $_SESSION["id"]); ?>
        </div>
        </div>
      </header>    
    <?PHP
  }
  }
 ?>
