<?php
ini_set("mbstring.internal_encoding", "UTF-8");
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

		//文字エンコードの変換「ASCII」「JIS」「UTF-8」「EUC-JP」「SJIS」
		// $title = mb_convert_encoding($title, "EUCJP", "auto");


	        $bm->postEntry($title, $text);
		echo "complete<BR>trying to dump...";
	        var_dump($bm->getBlogs());
		echo "<BR>complete fc2 ,title:" . $title . " => text:" . $text . "<BR>";
		return 1;//成功した場合
    } catch(Exception $e) {
		echo "error!";
        echo $e->getMessage();
        return 0;//失敗した場合
    }
}

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