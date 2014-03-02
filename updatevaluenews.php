<?php

//abstforblog,ispostblogの２カラムに対して実行するために作成
$con = mysql_connect("mysql010.phy.lolipop.jp","LAA0452117","pswd2005") or die(mysql_error());
mysql_set_charset('utf8');//日本語対応
mysql_select_db ("LAA0452117-newsdb") or die(mysql_error());//接続
$sql = "update rss SET $_POST[column] = '$_POST[value]' WHERE id = '$_POST[id]'";//SQL文の作成
$res = mysql_query($sql) or die(mysql_error());//クエリの実行
mysql_close($con);//切断
echo 'complete updating!'; 
?>