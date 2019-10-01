<?PHP
include_once 'config/fonksiyonlar.php';
if ($_SERVER['HTTP_REFERER'] == "") {
  exit("Giriş Yasak!");
}
if (empty($session_kadi) OR empty($session_id)) {}else{
if (empty($_GET["anketno"]) OR empty($_GET["secenekno"])) {
  // code...
}else{

oy_kullan_fun($baglan, mysqli_real_escape_string($baglan, htmlspecialchars($_GET["anketno"])), mysqli_real_escape_string($baglan, htmlspecialchars($_GET["secenekno"])), $_SESSION["kadi"], $_SESSION["id"]);

}
}
?>
