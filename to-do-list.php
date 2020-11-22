<?php
$conn = null;
$dbhost = '';  
$dbuser = '';            
$dbpass = '';
$dbdatabase = '';
$dbtable = '';  

//选择功能
$func=$_GET["f"];	//0:插入新任务 1:任务标记完成 -1.删除任务 2/3.查看任务 4.任务标记恢复


//登录sql
function login_sql()
{
    global $conn;        
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
	if(! $conn )
	{
		die('连接数据库失败: ' . mysqli_error());
	}
	mysqli_query($conn , "set names utf8");
	mysqli_select_db($conn, $$dbdatabase);
}

//0
function create_task()
{
	global $conn;
	$content=$_GET["content"];
	$ndate=$_GET["ndate"];
	$cip=$_GET["cip"];
	$cname=$_GET["cname"];

	$sql = "SELECT max(id)
			FROM ".$dbtable;
	$retval = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_array($retval,MYSQLI_NUM))
	{
		$maxid=$row[0]+1;
	}
	$sql = "INSERT INTO ".$dbtable.
			" (content,states,createtime,ip,address)".
			" VALUES".
			" ('$content',0,'$ndate','$cip','$cname')";
			
	$retval = mysqli_query( $conn, $sql );
	if(! $retval )
	{
	  die('无法插入数据: ' . mysqli_error($conn));
    }
	echo $maxid.":数据插入成功\n";
}

//2
function get_list_uf()
{
	global $conn;
	$state=0;
	$sql = 'SELECT id,content
			FROM '.$dbtable.
			'WHERE states=0';
	$retval = mysqli_query( $conn, $sql );
	$list = "";
	$i = 0;
	while($row=mysqli_fetch_array($retval, MYSQLI_NUM))
	{

		$list = $list.$row[0].":".$row[1]."/";
		$i = $i+1;
	}
	echo $list;
}

//3
function get_list_f()
{
	global $conn;
	$state=0;
	$sql = 'SELECT id,content
            FROM '.$dbtable.
            'WHERE states=1';
	$retval = mysqli_query( $conn, $sql );
	$list = "";
	$i = 0;
	while($row=mysqli_fetch_array($retval, MYSQLI_NUM))
	{

		$list = $list.$row[0].":".$row[1]."/";
		$i = $i+1;
	}
	echo $list;
}

//1
function task_f()
{
	global $conn;
	$id=$_GET["mid"];
	$cdate=$_GET["cdate"];
	$cip=$_GET["cip"];
	$cname=$_GET["cname"];
    $sql = "UPDATE list
            SET states=1, changetime='$cdate', lastip='$cip', lastaddress='$cname'
            WHERE id=".$id;
	$retval = mysqli_query( $conn, $sql );
	
    if(! $retval )
    {
		die('无法更新数据: ' . mysqli_error($conn));
    }
	echo "任务已标记完成";
}

//4
function task_uf()
{
	global $conn;
	$id=$_GET["mid"];
	$cdate=$_GET["cdate"];	
	$cip=$_GET["cip"];
	$cname=$_GET["cname"];
    $sql = "UPDATE ".$dbtable.
            "SET states=0, changetime='$cdate', lastip='$cip', lastaddress='$cname'
            WHERE id=".$id;
	$retval = mysqli_query( $conn, $sql );
	
    if(! $retval )
    {
		die('无法更新数据: ' . mysqli_error($conn));
    }
	echo "任务已标记待完成";
}

//-1
function task_del()
{
	global $conn;
	$id=$_GET["mid"];	
	$cdate=$_GET["cdate"];
	$cip=$_GET["cip"];
	$cname=$_GET["cname"];
    $sql = "UPDATE ".$dbtable.
            "SET states=-1, changetime='$cdate', lastip='$cip', lastaddress='$cname' 
            WHERE id=".$id;
	$retval = mysqli_query( $conn, $sql );
	
    if(! $retval )
    {
		die('无法更新数据: ' . mysqli_error($conn));
    }
	echo "任务已删除";
}

login_sql();

//0:添加新任务 1:标记完成 -1:删除任务 2/3:初始化加载待完成、已完成任务 4:恢复为未完成
switch ($func)
{
	case 0:
		create_task();
		break;
	case 2:
		get_list_uf();
		break;
    case 3:
		get_list_f();
		break;
	case -1:
		task_del();
		break;
	case 1:
		task_f();
		break;
    case 4:
		task_uf();
		break;
}

//关闭sql
mysqli_close($conn);
?>