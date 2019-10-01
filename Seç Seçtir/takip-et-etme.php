<?PHP
include_once 'config/fonksiyonlar.php';
if ($_SERVER['HTTP_REFERER'] == "") {
 exit("Giriş Yasak!");
}
if (empty($session_kadi) OR empty($session_id)) {}else{
if (empty($_GET["takip_edilcek"]) OR empty($_GET["islemno"])) {
  // code...
}else{

takip_et_fun($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["takip_edilcek"])), mysqli_real_escape_string($baglan, htmlspecialchars($_GET["islemno"])), $_SESSION["kadi"], $_SESSION["id"]);
}
}
?>
