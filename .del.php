<?php
if($_SERVER['HTTP_REFERER'] == "http://stats.in.soho.net.ua/smart/ping.php") {
if(isset($_GET['1'])) {
 unlink("/media/data/www/stats.in.soho.net.ua/smart/ping/".$_GET['1']);
// echo $_SERVER['HTTP_REFERER'];
  echo "<script>document.location.href='http://stats.in.soho.net.ua/smart/ping.php';</script>\n";
  exit;
 } else {
  echo "<script>document.location.href='http://stats.in.soho.net.ua/smart/ping.php';</script>\n";
  exit;
}
}
 else {
  echo "<script>document.location.href='http://stats.in.soho.net.ua/smart/ping.php';</script>\n";
  exit;
}
?>
                  
 