<?php
session_start();

header('Content-Type: text/html; charset=UTF-8');

$dbUrl = parse_url(getenv('DATABASE_URL'));

$db['host'] = $dbUrl['host'];  // DBURL
$db['user'] = $dbUrl['user'];  // username
$db['pass'] = $dbUrl['pass'];  // pass
$db['dbname'] = ltrim($dbUrl['path'], '/');  // db名

$name = $_SESSION['NAME'];

//エラーメッセージの初期化
$errorMessage = "";

if(isset($_POST['confirm'])){
	if(empty($_POST['waka'])){
		$errorMessage='画像を一つを選択してください';
	}else{
		//ラジオボタンのvalue値取得
		$value = $_POST['waka'];
		
		//DB接続情報作成
		$connectString = "host={$db['host']} dbname={$db['dbname']} port=5432 user={$db['user']} password={$db['pass']}";
		//DB接続
		if(!$result = pg_connect($connectString)){
			//接続失敗
			$errorMessage = '予期せぬエラーが発生';
			exit();
		}
		$insert = sprintf("Insert Into questionnaire(name,gazou,systimestamp)values('%s','%s',current_timestamp);",$name,$value);
		$insertresult = pg_query($insert);
		if($insertresult != ""){
			header("Location: thanks.html");
		}
	}
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=700,initial-scale="1">
<title>若月アンケート</title>
<link rel= "stylesheet" href="style.css">
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
<script>
$(function(){
	$("body").append("<div id='layer_min'></div><div id='layer_max'></div>");
	$("#layer_min").click(function(){
		$(this).hide();
		$("#layer_max").hide();
	});
	$("a.modal").click(function(){
		$("#layer_min").show();
		$("#layer_max").show().html("<img src='img/close.png' class='close' />"+"<img src='"+$(this).attr("href")+"'>");
		$("#layer_max img.close").click(function(){
		$("#layer_max").hide();
		$("#layer_min").hide();
		});
		return false;
	});
});
</script>
</head>
	<body>
		<br>
		<p><?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?> で参加中</p>
		<h1>あなたの若月ベストショットアンケート</h1>
		<div class="center">
			<p class="txt">ながちむが独断で選出した若月画像！<br>あなたが好きな若月を１つ選択してください。<br>※画像を選択で拡大されます<p/>
		</div>
		<div id="modal_window">
		<form id="ankertForm" name="ankertForm" action="" method="POST" accept-charset="UTF-8">
			<section>
				<table border="1" cellspacing="0" cellpadding="1">
				<tr>
					<td>
						<a href="img/waka1.jpg" class="modal"><img src="img/waka1_thum.jpg" title="若１"></a>
						<br>
						<input type="radio" name="waka" value="waka1"><label>乃木恋</label>
					</td>
					<td>
						<a href="img/waka2.jpg" class="modal"><img src="img/waka2_thum.jpg" title="若２"></a>
						<br>
						<input type="radio" name="waka" value="waka2"><label>イケメン</label>
					</td>
					<td>
						<a href="img/waka3.jpg" class="modal"><img src="img/waka3_thum.jpg" title="若３"></a>
						<br>
						<input type="radio" name="waka" value="waka3"><label>OFFICIAL</label>
					</td>
					<td>
						<a href="img/waka4.jpg" class="modal"><img src="img/waka4_thum.jpg" title="若４"></a>
						<br>
						<input type="radio" name="waka" value="waka4"><label>ほっぺムギュ</label>
					</td>
					<td>
						<a href="img/waka5.jpg" class="modal"><img src="img/waka5_thum.jpg" title="若５"></a>
						<br>
						<input type="radio" name="waka" value="waka5"><label>サヨナラの意味</label>
					</td>
				</tr>
				</table>
			</section>
			<br>
			<input type="submit" id="confirm" name="confirm" value="確定">
			<font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font>
			<p>お一人様、一度限りの投票でお願いいたします。
		</form>
		</div>
    </body>
</html>
