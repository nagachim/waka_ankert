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
		$value = $_GET['waka'];
		$insert = sprinf("Insert Into questionnaire(name,gazou,systimestamp)values('%s','%s',current_timestamp);",$name,$value);
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
	$("body").append("<div id='layer'></div><div id='layer_min'></div>");
	$("#layer").click(function(){
		$(this).hide();
		$("#layer_min").hide();
	});
	$("a.modal").click(function(){
		$("#layer").show();
		$("#layer_min").show().html("<img src='img/close.png' class='close' />"+"<img src='"+$(this).attr("href")+"'>");
		$("#layer_min img.close").click(function(){
		$("#layer_min").hide();
		$("#layer").hide();
		});
		return false;
	});
});
</script>
</head>
	<body>
		<p><?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?> で参加中</p>
		<h1>あなたの若月ベストショットアンケート</h1>
		<div class="center">
			<p class="txt">ながちむが独断で選出した若月画像！<br>あなたが好きな若月を１つ選択してください。<br>※画像を選択で拡大されます<p/>
		</div>
		<div class="modal_window">
			<section>
				<table border="1" cellspacing="0" cellpadding="1">
				<tr>
					<td>
						<a href="img/waka1.jpg" class="modal"><img src="img/waka1_thum.jpg" alt="若月１" title="わかちゅき１"></a>
						<br>
						<input type="radio" name="waka" value="waka1"><label>乃木恋</label>
					</td>
					<td>
						<a href="img/waka2.jpg" class="modal"><img src="img/waka2_thum.jpg" alt="若月２" title="わかちゅき２"></a>
						<br>
						<input type="radio" name="waka" value="waka2"><label>イケメン</label>
					</td>
					<td>
						<a href="img/waka3.jpg" class="modal"><img src="img/waka3_thum.jpg" alt="若月３" title="わかちゅき３"></a>
						<br>
						<input type="radio" name="waka" value="waka2"><label>OFFICIAL</label>
					</td>
					<td>
						<a href="img/waka4.jpg" class="modal"><img src="img/waka4_thum.jpg" alt="若月４" title="わかちゅき４"></a>
						<br>
						<input type="radio" name="waka" value="waka2"><label>ほっぺムギュ</label>
					</td>
					<td>
						<a href="img/waka5.jpg" class="modal"><img src="img/waka5_thum.jpg" alt="若月５" title="わかちゅき５"></a>
						<br>
						<input type="radio" name="waka" value="waka2"><label>サヨナラの意味</label>
					</td>
				</tr>
				</table>
			</section>
		</div>
		<br>
		<input type="submit" id="confirm" name="confirm" value="確定">
		<font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font>
		<p>お一人様、一度限りの投票でお願いいたします。
    </body>
</html>