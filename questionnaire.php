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
			<p class="txt">ながちむが独断で選出した若月画像！<br>あなたが可愛いと思う画像を１つ選択してください。<br>※画像を選択で拡大されます<p/>
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
						<input type="radio" name="waka" value="waka2"><label>ぷくキュート</label>
					</td>
					<td>
						<a href="img/waka3.jpg" class="modal"><img src="img/waka3_thum.jpg" title="若３"></a>
						<br>
						<input type="radio" name="waka" value="waka3"><label>女子カル</label>
					</td>
					<td>
						<a href="img/waka4.jpg" class="modal"><img src="img/waka4_thum.jpg" title="若４"></a>
						<br>
						<input type="radio" name="waka" value="waka4"><label>鎖骨美人</label>
					</td>
				</tr>
				<tr class = "row2">
					<td>
						<a href="img/waka5.jpg" class="modal"><img src="img/waka5_thum.jpg" title="若５"></a>
						<br>
						<input type="radio" name="waka" value="waka5"><label>サヨナラの意味</label>
					</td>
					<td>
						<a href="img/waka6.jpg" class="modal"><img src="img/waka6_thum.jpg" title="若６"></a>
						<br>
						<input type="radio" name="waka" value="waka6"><label>ムギュ</label>
					</td>
					<td>
						<a href="img/waka7.jpg" class="modal"><img src="img/waka7_thum.jpg" title="若７"></a>
						<br>
						<input type="radio" name="waka" value="waka7"><label>パレット</label>
					</td>
					<td>
						<a href="img/waka8.jpg" class="modal"><img src="img/waka8_thum.jpg" title="若８"></a>
						<br>
						<input type="radio" name="waka" value="waka8"><label>ジコチュー制服</label>
					</td>
				</tr>
				<tr class = "row3">
					<td>
						<a href="img/waka9.jpg" class="modal"><img src="img/waka9_thum.jpg" title="若９"></a>
						<br>
						<input type="radio" name="waka" value="waka9"><label>クール若</label>
					</td>
					<td>
						<a href="img/waka10.jpg" class="modal"><img src="img/waka10_thum.jpg" title="若１０"></a>
						<br>
						<input type="radio" name="waka" value="waka10"><label>宣材写真1</label>
					</td>
					<td>
						<a href="img/waka11.jpg" class="modal"><img src="img/waka11_thum.jpg" title="若１１"></a>
						<br>
						<input type="radio" name="waka" value="waka11"><label>箸くん箸くん</label>
					</td>
					<td>
						<a href="img/waka12.jpg" class="modal"><img src="img/waka12_thum.jpg" title="若１２"></a>
						<br>
						<input type="radio" name="waka" value="waka12"><label>佑美ニャン</label>
					</td>
				</tr>
				<tr class = "row4">
					<td>
						<a href="img/waka13.jpg" class="modal"><img src="img/waka13_thum.jpg" title="若１３"></a>
						<br>
						<input type="radio" name="waka" value="waka13"><label>軍団長</label>
					</td>
					<td>
						<a href="img/waka14.jpg" class="modal"><img src="img/waka14_thum.jpg" title="若１４"></a>
						<br>
						<input type="radio" name="waka" value="waka14"><label>可愛い彼女感</label>
					</td>
					<td>
						<a href="img/waka15.jpg" class="modal"><img src="img/waka15_thum.jpg" title="若１５"></a>
						<br>
						<input type="radio" name="waka" value="waka15"><label>美アップ</label>
					</td>
					<td>
						<a href="img/waka16.jpg" class="modal"><img src="img/waka16_thum.jpg" title="若１６"></a>
						<br>
						<input type="radio" name="waka" value="waka16"><label>最高の一枚</label>
					</td>
				</tr>
				<tr class = "row5">
					<td>
						<a href="img/waka17.jpg" class="modal"><img src="img/waka17_thum.jpg" title="若１７"></a>
						<br>
						<input type="radio" name="waka" value="waka17"><label>れかつき</label>
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
