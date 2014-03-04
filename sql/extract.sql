
//要約アプリから要約文章が送られているが、まだブログにポストされていない記事
SELECT * FROM `rss` WHERE ispostblog = 0 and !(abstforblog is null or abstforblog = "")

//ポストされていないレコード数をカウント
SELECT count(*) FROM `rss` WHERE ispostblog = 0 and !(abstforblog is null or abstforblog = "");


//idで降順(大きいものから)に表示
SELECT * FROM `rss` order by id desc

//idで昇順(小さいものから)に表示
SELECT * FROM `rss` order by id (asc省略可能)


//まだポストされていないレコードを新しい順番に
select * from `rss` where abstforblog is not null order by id desc


//objective-cプログラムによって更新されていない数字
select * from `rss` where abstforblog is null or abstforblog = "" order by id desc