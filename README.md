# 程序运行前，需要您做以下步骤以正常使用
## 0.修改to-do-list.html
`phpUrl = "";    //后端地址`

填上后端地址，如
"http://meteora.ml/mysql"
## 1.修改to-do-list.php
修改连接sql信息
```php
$dbhost = '';  
$dbuser = '';            
$dbpass = '';
$dbdatabase = '';   //数据库名
$dbtable = '';      //表名
```
## 2.创建sql数据库表
|  名字   | 类型  |  排序规则 |
|  ----  | ----  |  ----  |
| id     | int | |
| content| text | gbk_bin|
| states | int | |
| createtime| datetime | |
| ip  | text | |
| address  | text | gbk_bin|
| changetime  | datetime | |
| lastip  | text | |
| lastaddress  | text |gbk_bin |