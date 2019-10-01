<?PHP
include_once 'config/fonksiyonlar.php';
if ($_SERVER['HTTP_REFERER'] == "") {
  exit("Giriş Yasak!");
}
if (empty($session_kadi) OR empty($session_id)) {}else{
    bildirim_sil($baglan, $_SESSION["kadi"], $_SESSION["id"]);
}
?>
