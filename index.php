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

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>若月アンケート</title>
<link rel= "stylesheet" href="style.css">
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
</head>
	<body>
		<div id="modal_window">
			<h1>あなたの若月ベストショットアンケート</h1>
			<form id="loginForm" name="loginForm" action="" method="POST" accept-charset="UTF-8">
				<fieldset>
					<legend>ログイン情報</legend>
					<label for="name">ユーザ名　：</label><input type="text" id="name" name="name" placeholder="ユーザ名を入力" value="">
					<br>
					<br>
					<input type="submit" id="login" name="login" value="ログイン">
					<div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
				</fieldset>
			</form>
		</div>
		<br>
	</body>
</html>
