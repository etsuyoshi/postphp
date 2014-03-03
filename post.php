<?php
ini_set("mbstring.internal_encoding", "UTF-8");
//日本語対応するには以下のコードでutf-8指定した後、日本語文章をソースコード内に埋め込み、ファイルの文字コードをutf-8に設定する
header('Content-Type: text/html; charset=UTF-8');
require_once("./FC2BlogManager.php");


echo "start php<BR>";
function fc2($title, $text) {

	$user_id0 = 'sakashitaemi';
	$user_pass0 = '1981tysendsan';


	// if(mt_rand() % 3 == 0){
	// 	// define('USER_ID', 'kosodateriko');
 //  //   	define('USER_PASS', 'pswd2005');
	// 	$user_id0 = 'kosodateriko';
	// 	$user_pass0 = 'pswd2005';
	// }else if(mt_rand() % 2 == 0){
	if(mt_rand() % 2 == 0){//temporary
		// define('USER_ID', 'sakashitaemi');
	 //    define('USER_PASS', '1981tysendsan');
		$user_id0 = 'sakashitaemi';
		$user_pass0 = '1981tysendsan';
	}else{
		// define('USER_ID', 'kanazawa02');
	 //    define('USER_PASS', 'aassddff2013');
		$user_id0 = 'kanazawa02';
		$user_pass0 = 'aassddff2013';
	}

	if(mt_rand() % 2 == 0){
		$user_id0 = 'satoko2013';
		$user_pass0 = 'pswd2005';
	}
 	echo 'user_id=' . $user_id0 . "<BR>";
 	echo 'user_pass=' . $user_pass0 . "<BR>";

    define('USER_ID', $user_id0);
    define('USER_PASS', $user_pass0);


//  kosodateriko	pswd2005
//  sakashitaemi	1981tysendsan
//	satoko2013	pswd2005
//	kanazawa02	aassddff2013
    $fc2_host = "blog.fc2.com";
    $fc2_xmlrpc_path = "/xmlrpc.php";
    echo "[[[[[[fc2]]]]]function start.<BR>";

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

		//文字エンコードの変換「ASCII」「JIS」「UTF-8」「EUC-JP」「SJIS」
		// $title = mb_convert_encoding($title, "EUCJP", "auto");


	        $bm->postEntry($title, $text);
		echo "complete<BR>trying to dump...";
	        var_dump($bm->getBlogs());
		echo "<BR>complete fc2 ,title:" . $title . " => text:" . $text . "<BR>";
		
    } catch(Exception $e) {
		echo "error!";
        echo $e->getMessage();
        return 0;//失敗した場合
    }

    return 1;//成功した場合
}


function ameba($title, $text) {
 	

// skmtyumi	1981tysendsan
// satokoamb	pswd2005
// yossii34	asdf2013
//	cwk2013	password
	if(mt_rand() % 4 == 0){

		$user_id0 = 'skmtyumi';
		$user_pass0 = '1981tysendsan';
	}else if(mt_rand() % 3 == 0){
		$user_id0 = 'satokoamb';
		$user_pass0 = 'pswd2005';
	}else if(mt_rand() % 2 == 0){
		
		$user_id0 = 'yossii34';
		$user_pass0 = 'asdf2013';
	}else{
		$user_id0 = 'cwk2013';
		$user_pass0 = 'password';
	}


    define('USER_ID', 'cwk2013');
    define('USER_PASS', 'password');


    echo 'ameba start:[' . $title . ']:' . $text . "<BR>";
 
    $atomapi_url = 'http://atomblog.ameba.jp/servlet/_atom/blog';
 
    $created = date('Y-m-d\TH:i:s\Z');
    $nonce = sha1(md5(time()));
    $pass_digest = base64_encode(pack('H*', sha1($nonce.$created.strtolower(md5(USER_PASS)))));
 
    $wsse = 'UsernameToken Username="'.USER_ID.'", '.
            'PasswordDigest="'.$pass_digest.'", '.
            'Nonce="'.base64_encode($nonce).'", '.
            'Created="'.$created.'"';
 
    $ameHeader = "X-WSSE: " . $wsse;
 
    $rawdata = sprintf('
<?xml version="1.0" encoding="utf-8"?>
<entry xmlns="http://purl.org/atom/ns#" xmlns:app="http://www.w3.org/2007/app#" xmlns:mt="http://www.movabletype.org/atom/ns#">
<title>%s</title>
<content type="application/xhtml+xml">
<![CDATA[%s]]>
</content>
</entry>', a, b);
 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $atomapi_url);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER,array($ameHeader));
    //curl_setopt($ch, CURLOPT_GET, true);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($ch);
    curl_close($ch);
 
    preg_match('/rel="service.post" type="application\/x\.atom\+xml" href="(.*?)"/',$res,$postURl);
 
    $rawdata = sprintf('
<?xml version="1.0" encoding="utf-8"?>
<entry xmlns="http://purl.org/atom/ns#"
xmlns:app="http://www.w3.org/2007/app#"
xmlns:mt="http://www.movabletype.org/atom/ns#">
<title>%s</title>
<content type="application/xhtml+xml">
<![CDATA[%s]]>
</content>
</entry>', $title, $text);
 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $postURl[1]);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER,array($ameHeader));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$rawdata);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($ch);
    curl_close($ch);

    echo 'ameba finished' . "<BR>";
    return 1;//成功した場合
}


function goo($title, $text) {
	//sakashitaami	1981tysendsan
	//satokolog	pswd2005
	//choochoorain	asdf2013
	$user_id0 = 'sakashitaami';
	$user_pass0 = '1981tysendsan';

	if(mt_rand() % 3 == 0){
		$user_id0 = 'satokolog';
		$user_pass0 = 'pswd2005';
	}else if(mt_rand() % 2 == 0){
		$user_id0 = 'choochoorain';
		$user_pass0 = 'asdf2013';
	}

    define('USER_ID', $user_id0);
    define('USER_PASS', $user_pass0);
 	echo 'username:' . $user_id0 . "<BR>";
 	echo 'goo start:[' . $title . ']:' . $text . "<BR>";

 	
    $goo_host = "blog.goo.ne.jp";
    $goo_xmlrpc_path = "/xmlrpc.php";
 
    try {
        $bm = new FC2BlogManager($goo_host, $goo_xmlrpc_path);
        $bm->setUser(USER_ID);
        $bm->setPassword(USER_PASS);
        $bm->postEntry($title, $text, USER_ID);
        var_dump($bm->getBlogs());
    } catch(Exception $e) {
        echo $e->getMessage();
        return 0;
    }

    echo 'goo finished';
    return 1;//成功した場合
}
 

function jugem($title, $text) {
 
    // define('USER_ID', '[ID]');
    // define('USER_PASS', '[PASSWORD]');

	// skstemi	1981tysendsan
	//satoko2013	pswd2005
	//okiniirisupot 	asdf2013

	$user_id0 = 'skstemi';
	$user_pass0 = '1981tysendsan';

	if(mt_rand() % 3 == 0){
		$user_id0 = 'satoko2013';
		$user_pass0 = 'pswd2005';
	}else if(mt_rand() % 2 == 0){
		$user_id0 = 'okiniirisupot';
		$user_pass0 = 'asdf2013';
	}

    define('USER_ID', $user_id0);
    define('USER_PASS', $user_pass0);
 	echo 'username:' . $user_id0;
 	echo 'goo start:[' . $title . ']:' . $text;

 
    $jugem_host = USER_ID . ".jugem.jp";
    $jugem_xmlrpc_path = "/admin/xmlrpc.php";
 
    try {
        $bm = new FC2BlogManager($jugem_host, $jugem_xmlrpc_path);
        $bm->setUser(USER_ID);
        $bm->setPassword(USER_PASS);
        $bm->postEntry($title, $text);
        var_dump($bm->getBlogs());
    } catch(Exception $e) {
        echo $e->getMessage();
        return 0;
    }
    echo 'jugem finished';
    return 1;//成功した場合

}
 
function seesaa($title, $text) {
// BLOG_ID  pass 			user_id
// skmtnami	1981tysendsan	skstemi@yahoo.co.jp
// sakashitanami	1981tysendsan	skstemi@yahoo.co.jp
// skstnami	1981tysendsan	skstemi@yahoo.co.jp

// satokoss	pswd2005	ssaattookkoo2013@yahoo.co.jp
// satokossactive	pswd2005	ssaattookkoo2013@yahoo.co.jp
// bikatu	pswd2005	ssaattookkoo2013@yahoo.co.jp

// qkaoqkao@yahoo.co.jp	asdf2013	qkaoqkao@yahoo.co.jp
// qkaoqkao@yahoo.co.jp	asdf2013	qkaoqkao@yahoo.co.jp
// qkaoqkao@yahoo.co.jp   kiiiitttiiiiinnnn	asdf2013	qkaoqkao@yahoo.co.jp
	
	$user_id0 = 'skstemi@yahoo.co.jp';
	$user_pass0 = '1981tysendsan';
	$blog_id0 = 'skmtnami';
	if(mt_rand() % 9 == 0){
		$user_id0 = 'skstemi@yahoo.co.jp';
		$user_pass0 = '1981tysendsan';
		$blog_id0 = 'skmtnami';
	}else if(mt_rand() % 8 == 0){
		$user_id0 = 'skstemi@yahoo.co.jp';
		$user_pass0 = '1981tysendsan';
		$blog_id0 = 'sakashitanami';
	}else if(mt_rand() % 7 == 0){
		$user_id0 = 'skstemi@yahoo.co.jp';
		$user_pass0 = '1981tysendsan';
		$blog_id0 = 'skstnami';
	}else if(mt_rand() % 6 == 0){
		$user_id0 = 'ssaattookkoo2013@yahoo.co.jp';
		$user_pass0 = 'pswd2005';
		$blog_id0 = 'satokoss';
	}else if(mt_rand() % 5 == 0){
		$user_id0 = 'ssaattookkoo2013@yahoo.co.jp';
		$user_pass0 = 'pswd2005';
		$blog_id0 = 'satokossactive';
	}else if(mt_rand() % 4 == 0){
		$user_id0 = 'ssaattookkoo2013@yahoo.co.jp';
		$user_pass0 = 'pswd2005';
		$blog_id0 = 'bikatu';
	}else if(mt_rand() % 3 == 0){
		$user_id0 = 'qkaoqkao@yahoo.co.jp';
		$user_pass0 = 'asdf2013';
		$blog_id0 = 'kiiiitttiiiiinnnn';
	}else if(mt_rand() % 2 == 0){
		$user_id0 = 'qkaoqkao@yahoo.co.jp';
		$user_pass0 = 'asdf2013';
		$blog_id0 = 'eoskeifer';
	}else{
		$user_id0 = 'qkaoqkao@yahoo.co.jp';
		$user_pass0 = 'asdf2013';
		$blog_id0 = 'zmdkru';
	}

//github
//各ブログテスト

    define('USER_ID', $user_id0);
    define('USER_PASS', $user_pass0);
    define('BLOG_ID', $blog_id0);
 
    $seesaa_host = "blog.seesaa.jp";
    $seesaa_xmlrpc_path = "/rpc";
 
    try {
        $bm = new FC2BlogManager($seesaa_host, $seesaa_xmlrpc_path);
        $bm->setUser(USER_ID);
        $bm->setPassword(USER_PASS);
        $bm->postEntry($title, $text, BLOG_ID);
        var_dump($bm->getBlogs());
    } catch(Exception $e) {
        echo $e->getMessage();
        return 0;
    }


    return 1;//成功した場合
}
 /*
function so-net($title, $text) {
 
    define('USER_ID', '[ID]');
    define('USER_PASS', '[PASSWORD]');
 
    $so-net_host = "blog.so-net.ne.jp";
    $so-net_xmlrpc_path = "/_rpc";
 
    try {
        $bm = new FC2BlogManager($so-net_host, $so-net_xmlrpc_path);
        $bm->setUser(USER_ID);
        $bm->setPassword(USER_PASS);
        $bm->postEntry($title, $text, USER_ID);
        var_dump($bm->getBlogs());
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}
*/

//＜ispostblogがゼロでabstforblogが「nullでない」もしくは「空でない」の最大のidを取得＞
function makeId(){
	header('Content-Type: text/html; charset=UTF-8');

	$con = 
	mysql_connect(
		"mysql010.phy.lolipop.lan",
		"LAA0452117",
		"pswd2005")
		 or 
		 die(mysql_error());

	mysql_select_db ("LAA0452117-newsdb") or die(mysql_error());
	mysql_query('set character set utf8');
	//$sql = "select $_POST[id] from rss t1 where id = '$_POST[id]'";//SQL
	//他の条件追加する時には以下の2つのwhere句のそれぞれにandで条件追加する
	//t2はt1を超えるものがないことを示すための仮データ
	$sql = 
	"select id from `rss` t1 
	 where (!(t1.abstforblog IS NULL OR t1.abstforblog = '') and
		    t1.ispostblog = 0)
	           and
		   not exists (select 1 from `rss` t2 
				   where (!(t2.abstforblog IS NULL OR t2.abstforblog = '') AND
				   		  t2.ispostblog = 0 AND
					      t2.id > t1.id))";
	// $sql = "select abstforblog from `rss` t1 where id = 1";//4886";

	$res = mysql_query($sql) or die(mysql_error());
	$data = mysql_fetch_array($res);
	// echo "data = [" . $data[0] . "]<BR>";


	mysql_close($con);



	return $data[0];
}

//<指定したidのレコードにおける指定したcolumnを取得する
//デフォルトではid=1,column="title"
function makeValue($id=1, $column="title"){
	header('Content-Type: text/html; charset=UTF-8');

	$con = 
	mysql_connect(
		"mysql010.phy.lolipop.lan",
		"LAA0452117",
		"pswd2005")
		 or 
		 die(mysql_error());

	mysql_select_db ("LAA0452117-newsdb") or die(mysql_error());
	mysql_query('set character set utf8');
	//$sql = "select $_POST[id] from rss t1 where id = '$_POST[id]'";//SQL
	//他の条件追加する時には以下の2つのwhere句のそれぞれにandで条件追加する
	//t2はt1を超えるものがないことを示すための仮データ
	$sql = "select " . $column . " from `rss` t1 where id = " . $id;


	$res = mysql_query($sql) or die(mysql_error());
	$data = mysql_fetch_array($res);
	echo "id" . $id . "における" . $column . "は[" . $data[0] . "]<BR>";


	mysql_close($con);



	return $data[0];
	
}

function makeArticle($lastId)
{
	// ＜ispostblogがゼロで最大のabstforblogがnullの最大のidを取得＞
	// $lastId = makeId();
	echo "makeArticle at id=" . $lastId . "<BR>";
	
	//＜取得したidのtitleとabstforblogをそれぞれ$titleと$textに格納＞
	$title = makeValue($lastId, "title");
	$text = makeValue($lastId, "abstforblog");

	return array( 'title' => $title, 'text' => $text);//連想配列(NSDictionaryみたい)
}

function updateValue($id, $column, $newvalue){
	echo "updateValue<BR>";
	$con = 
	mysql_connect(
		"mysql010.phy.lolipop.lan",
		"LAA0452117",
		"pswd2005")
		 or 
		 die(mysql_error());
	mysql_select_db ("LAA0452117-newsdb") or die(mysql_error());
	$sql = "update rss SET " . $column . " = " . $newvalue . " WHERE id = " . $id;
	echo "updateValue : sql = " . $sql;
	$res = mysql_query($sql) or die(mysql_error());//クエリの実行
	mysql_close($con);//切断
}


$lastId = makeId();
$article = makeArticle($lastId);
$title = $article["title"];
$text = $article["text"] . "http://xn--wifi-to4c3j9d.jp/";

$isSuccessUpdate = fc2($title, $text);
echo "isSuccess = " . $isSuccessUpdate;
if($isSuccessUpdate == 1){
	echo "is Success updated";
	//updateしたことをDBにフラグとして上げる
	// 即ち$lastIdレコードのispostblogに１を立てる
	updateValue($lastId, "ispostblog", 1);
	echo "<BR>complete update<BR>";
}

?>