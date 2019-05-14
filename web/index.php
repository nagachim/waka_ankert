<?php
session_start();

header('Content-Type: text/html; charset=UTF-8');

$dbUrl = parse_url(getenv('DATABASE_URL'));

$db['host'] = $dbUrl['host'];  // DBURL
$db['user'] = $dbUrl['user'];  // username
$db['pass'] = $dbUrl['pass'];  // pass
$db['dbname'] = ltrim($dbUrl['path'], '/');  // db名

//エラーメッセージの初期化
$errorMessage = "";

if(isset($_POST['login'])){
	if(empty($_POST['name'])){
		$errorMessage = '名前を入力してください';
	}
	
	//DB接続情報作成
		$connectString = "host={$db['host']} dbname={$db['dbname']} port=5432 user={$db['user']} password={$db['pass']}";
		//DB接続
		if(!$result = pg_connect($connectString)){
			//接続失敗
			$errorMessage = '予期せぬエラーが発生';
			exit();
		}
	$select = sprintf("SELECT * FROM questionnaire WHERE name = %s",$_POST['name']);
	$selectresult = pg_query($select);
	$array = pg_fetch_array($selectresult,0,PGSQL_NUM);
	
	//入力した名前とDBにある名前が一致した場合
	if($_POST['name'] = $array[1]){
		$errorMesage = '入力された名前は既に使われています。';
	}
	$_SESSION['name'] = $_POST['name'];

	pg_close($result);
	header("Location:questionnaire.php");
}
?>
