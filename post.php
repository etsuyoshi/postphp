<?php
//日本語対応するには以下のコードでutf-8指定した後、日本語文章をソースコード内に埋め込み、ファイルの文字コードをutf-8に設定する
header('Content-Type: text/html; charset=UTF-8');
require_once("./FC2BlogManager.php");


echo "start php<BR>";

function fc2($title, $text) {
 
    define('USER_ID', 'kosodateriko');
    define('USER_PASS', 'pswd2005');
 
    $fc2_host = "blog.fc2.com";
    $fc2_xmlrpc_path = "/xmlrpc.php";
    echo "function start.<BR>";

    try {
	echo "trying to newing FC2BlogManager...<BR>";

        $bm = new FC2BlogManager($fc2_host, $fc2_xmlrpc_path);



	echo "complete<BR>";
	echo "trying to setUser...";
        $bm->setUser(USER_ID);


	echo "compele<BR>";
	echo "trying to setPassword...";
        $bm->setPassword(USER_PASS);
	echo "compelete<BR>trying to postEntry...";
        $bm->postEntry($title, $text);
	echo "complete<BR>trying to dump...";
        var_dump($bm->getBlogs());
	//echo "complete fc2 ,title:" . $title . " => text:" . $text . "<BR>";

    } catch(Exception $e) {
	echo "error!";
        echo $e->getMessage();
    }
}

echo "aaa<BR>";
fc2('aaa', 'bbb');
echo "complete fc2";

?>