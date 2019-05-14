<?php
session_start();

header('Content-Type: text/html; charset=UTF-8');

$dbUrl = parse_url(getenv('DATABASE_URL'));

$db['host'] = $dbUrl['host'];  // DBURL
$db['user'] = $dbUrl['user'];  // username
$db['pass'] = $dbUrl['pass'];  // pass
$db['dbname'] = ltrim($dbUrl['path'], '/');  // db名

$name = $_SESSION('NAME');

//エラーメッセージの初期化
$errorMessage = "";

if(isset($_POST['confirm'])){
	if(empty($_POST['waka'])){
		$errorMessage='画像を一つを選択してください';
	}
	$checked = $("input[name='waka']:checked").val();
	$insert = sprinf("Insert Into questionnaire(name,gazou,systimestamp)values('%s','%s',current_timestamp);",$name,$checked);
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
<script>
$(function(){
	$("body").append("<div id='mom_layer'></div><div id='kids_layer'></div>");
	$("#mom_layer").click(function(){
		$(this).hide();
		$("#kids_layer").hide();
	});
	$("a.modal").click(function(){
		$("#mom_layer").show();
		$("#kids_layer").show().html("<img src='img/close.png' class='close' />"+"<img src='"+$(this).attr("href")+"'>");
		$("#kids_layer img.close").click(function(){
		$("#kids_layer").hide();
		$("#mom_layer").hide();
		});
		return false;
	});
});
</script>
<!--<script type="text/javascript" src="scripts.js"></script>-->
</head>
	<body>

			<div id="modal_window">
			<h1>あなたの若月ベストショットアンケート</h1>
			<h2>ながちむが独断で選出した若月画像！<br>あなたが好きな若月を１つ選択してください。<br>※画像を選択で拡大されます</h2>
				<section>
					<table border="1" cellspacing="0" cellpadding="1">
					<tr>
						<td>
							<a href="img/waka1.jpg" class="modal"><img src="img/waka1_thum.jpg" alt="若月１" title="わかちゅき"></a>
							<br>
							<input type="radio" name="waka" value="waka1"><label>若月１</label>
						</td>
						<td>
							<a href="img/waka2.jpg" class="modal"><img src="img/waka2_thum.jpg" alt="若月２" title="わかちゅき"></a>
							<br>
							<input type="radio" name="waka" value="waka2"><label>若月２</label>
						</td>
					</tr>
					</table>
				</section>
			</div>
			<br>
			<label for="username">twitterネームorニックネーム：</label><input type="text" id="username" name="username" placeholder="20文字以内" value="">
			<br>
			<input type="submit" id="confirm" name="confirm" value="確定">
			<font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font>
			<p>お一人様、一度限りの投票でお願いいたします。
    </body>
</html>