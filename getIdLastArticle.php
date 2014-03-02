<?php

header('Content-Type: text/html; charset=UTF-8');

$con = mysql_connect("mysql010.phy.lolipop.lan","LAA0452117","pswd2005") or die(mysql_error());

mysql_select_db ("LAA0452117-newsdb") or die(mysql_error());
mysql_query('set character set utf8');
//$sql = "select $_POST[id] from rss t1 where id = '$_POST[id]'";//SQL
//他の条件追加する時には以下の2つのwhere句のそれぞれにandで条件追加する
$sql = "select id from `rss` t1 
 where (t1.id < $_POST[id] and
	    t1.ispostblog = 0 and
	    (t1.abstforblog IS NULL OR t1.abstforblog = '') and
	    t1.category = $_POST[category])
           and
	   not exists (select 1 from `rss` t2 
			   where (t2.id < $_POST[id] and
				      t2.ispostblog = 0 AND
				      t2.id > t1.id and 
				      (t2.abstforblog IS NULL OR t2.abstforblog = '') and
				      t2.category = $_POST[category]))";
$res = mysql_query($sql) or die(mysql_error());
$data = mysql_fetch_array($res);
echo $data[0];
mysql_close($con);
?>