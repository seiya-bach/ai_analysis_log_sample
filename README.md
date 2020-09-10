# ai_analysis_log_sample

## 概要
実行ファイルはsrc/ai_analysis_log.phpです。
画像ファイルを指定して実行するとAPIの応答をもとにDBのai_analysis_logテーブルに登録されます。

引数に画像ファイルのパスを付けて実行します。成功するとSuccess!のメッセージが表示されます。
```
$ php ai_analysis_log.php /Users/seiya/photo.jpg
Success!
```
引数がない場合や画像ファイルではない場合はエラーになります。
```
$ php ai_analysis_log.php
Error: Require image path.
```
APIの応答をもとにai_analysis_logテーブルにデータが登録されます。
```
mysql> select * from ai_analysis_log;
+----+------------------------+---------+--------------+-------+------------+-------------------+--------------------+
| id | image_path             | success | message      | class | confidence | request_timestamp | response_timestamp |
+----+------------------------+---------+--------------+-------+------------+-------------------+--------------------+
|  1 | /Users/seiya/photo.jpg | true    | success      |     3 |     0.8683 |        1599752179 |         1599752179 |
|  2 | /Users/seiya/photo.jpg | false   | Error:E50012 |  NULL |       NULL |        1599752265 |         1599752265 |
+----+------------------------+---------+--------------+-------+------------+-------------------+--------------------+
2 rows in set (0.00 sec)
```
