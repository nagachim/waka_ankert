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
		
	}else{
	
		$name = $_POST['name'];
	
		//DB接続情報作成
		$connectString = "host={$db['host']} dbname={$db['dbname']} port=5432 user={$db['user']} password={$db['pass']}";
		//DB接続
		if(!$result = pg_connect($connectString)){
			//接続失敗
			$errorMessage = '予期せぬエラーが発生';
			exit();
		}
		$select = sprintf("SELECT * FROM questionnaire WHERE name = '%s'",$name);
		$selectresult = pg_query($select);
		$array = pg_fetch_array($selectresult,0,PGSQL_NUM);
		
		//入力した名前とDBにある名前が一致した場合
		if($name = $array[1]){
			$errorMesage = '入力された名前は既に使われています。';
		}else{
			$_SESSION['NAME'] = $name;
			pg_close($result);
			header("Location: questionnaire.php");
		}
	}

}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=600">
<title>若月アンケート</title>
<link rel= "stylesheet" href="top_page.css">
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
</head>
	<body>
		<h1>あなたの若月ベストショットアンケート</h1>
		<div class="login">
			<form id="loginForm" name="loginForm" action="" method="POST" accept-charset="UTF-8">
				<fieldset>
					<legend>ログイン情報</legend>
					<label for="name">twitterネームorニックネーム</label><br><input type="text" id="name" name="name" placeholder="20文字以内" value="">
					<br>
					<br>
					<input type="submit" id="login" name="login" value="ログイン">
					<div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
				</fieldset>
			</form>
			<div class="tyuui">
				<p class="txt">
				※これはながちむの個人的な趣味の為のアンケートです。<br/>
				　個人情報は一切頂きたくないので、名前のみ登録して頂きます。<br/>
				　名前の公開などは考えておりません。<br/>
				　（どの画像が一番多くの人に選ばれたかくらいの情報公開のみ）<br/>
				　又、完全同一のお名前が先に登録されていた場合、<br/>
				　先の画面に進めなくなっておりますので、ご了承ください<br/>
				　（故にTwitterネームを推奨します。私も把握しやすいので！）<br/>
				　若月さん推しには勿論、沢山の人に協力して頂けると嬉しいです！
				</p>
			</div>
		</div>
		<br>
	</body>
</html>