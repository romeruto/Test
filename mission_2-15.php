<?php
	header("Content-Type: text/html; charset=UTF-8");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<h1> <font color = "#87ceeb">プログラミングのお勉強 </font></h1>

<?php

//DBにmysql,データベース名のテストを指定
$dsn = 'データベース名';
//user名
$user = 'ユーザー名';
//password名
$sqlPassword = 'パスワード名';

$editNumber = "";

//入力フォームに表示
if(!empty($_POST['edit']) && $_POST['editButton']){
	$getNumber = $_POST['edit'];
	$editName = "";
	$editComment = "";
	$editPass = "";
	$getPass = $_POST['editPassword'];
	$editFlag = false;
	try{
		$pdo = new PDO($dsn,$user,$sqlPassword);
		$sql5 = "SELECT * FROM DB2";
		$stmt = $pdo->query($sql5);
		//echo $stmt;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$editNumber = $row['id'];
			$editPass = $row['password'];
			if($editPass == $getPass && $editNumber == $getNumber){
				echo "【編集モード】".$getNumber."番目の編集を行います！名前、パスワード、コメントを入力して送信で編集！";
				$editName = $row['name'];
				$editPass = $row['password'];
				$editComment = $row['comment'];
				$editFlag = true;
			
			}
		}
		$pdo = null;
	}
	catch(PDOExcepiton $e){
		print('エラーが発生しました'.e-getMessage());
		die();
	}
	if($editFlag != true){
		echo "編集パスワードが違います";
		$editName = "";
		$editComment = "";
		$editPass = "";
		$editFlag = false;
		
	}
//editNumberを数字に変更
	$editNumber = $getNumber;

}

//削除処理
if($_POST['remove'] != NULL && $_POST['removePassword'] != NULL && $_POST['removeButton']){
	$getNumber = $_POST['remove'];
	$getPass = $_POST['removePassword'];
	$removeFlag = false;

	try{
		$pdo = new PDO($dsn,$user,$sqlPassword);

		$sql5 = "SELECT * FROM DB2";
		$stmt = $pdo->query($sql5);
		//echo $stmt;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$removeNumber = $row['id'];
			$removePass = $row['password'];
			if($removePass == $getPass && $removeNumber == $getNumber){
				$sql3 = "UPDATE DB2 SET name = '', time = '', comment = '削除されました' WHERE id = $getNumber";
				$stmt = $pdo->query($sql3);
				echo "【".$removeNumber."番目のコメントが削除されました】";
				$removeFlag = true;
			
			}
		}
		$pdo = null;
	//	$flag = true;
	}
	catch(PDOExcepiton $e){
		print('エラーが発生しました'.e-getMessage());
		die();
	}
	if($removeFlag != true){
 		echo "削除失敗！パスワードと番号が違うか、既に削除されています<br>";
		$removeFlag = false;
	}

	//editNumberを""に変更
	$editNumber = "";
}

?>

<body bgcolor="#f0f8f8">
<title>楽しいプログラミング</title>
<form action = "mission_2-15.php" method = "post">
名前  :
<input type = "text" name = "name" value = "<?php echo $editName;?>">
パスワード  :
<input type = "text" name = "password" value = "<?php echo $editPass;?>">
</br>
</br>
<div style="margin-left:10px;">
コメント  :</br>
<textarea name = "comment"  cols = "50" rows = "5"><?php echo $editComment?></textarea></br>
</div>
<!--<input type = "text" name = "comment" value = "<?php echo $editComment;?>" size = "80"></br>-->
<input type = "hidden" name = "editable" value = "<?php echo $editNumber;?>"></br>


<input type = "submit" value = "送信"></br>


削除対象番号 :
<input type = "text" name = "remove">
pass:<input type = "text" name = "removePassword"></br>
<input type = "submit" name = "removeButton" value = "削除" ></br>

編集対象番号 :
<input type = "text" name = "edit">
pass:<input type ="text" name = "editPassword"></br>
<input type = "submit" name = "editButton" value = "編集"></br>

</form>


<?php
$textfile = 'text26.txt';



//普通の送信
if($_POST['name'] != NULL && $_POST['comment'] != NULL && $_POST['password'] != NULL){

	$editNumber = $_POST['editable'];
	//echo $flag;
 	if($editNumber == ""){
 		$name1 = $_POST['name'];
 		$comment1 = $_POST['comment'];
		$time = date("Y/m/d/ H:i:s");
		$password = $_POST['password'];

		
		// echo "書き込みモードですよ<br>";
		
		//mysql
		try{
			$pdo = new PDO($dsn,$user,$sqlPassword);
			$sql1 = "INSERT INTO DB2(name, comment, time, password, hensyuu) VALUES('$name1', '$comment1', '$time', '$password', '')";
			$stmt = $pdo->query($sql1);
			$pdo = null;
		}
		catch(PDOExcepiton $e){
			print('エラーが発生しました'.e-getMessage());
			die();
		}
 	}

//編集処理
	if($editNumber != ""){
		$name1 = $_POST['name'];
 		$comment1 = $_POST['comment'];
		$time = date("Y/m/d/ H:i:s");
		$password = $_POST['password'];

		try{
		//	echo "油型ブラホイホイ補遺";
			$pdo = new PDO($dsn,$user,$sqlPassword);
			$sql4 = "UPDATE DB2 SET name = '$name1', comment = '$comment1', time = '$time', password = '$password', hensyuu = '(編集済みコメント)' WHERE id = $editNumber";
			$stmt = $pdo->query($sql4);
			
			$pdo = null;
		}
		catch(PDOExcepiton $e){
			print('エラーが発生しました'.e-getMessage());
			die();
		}
	}
}
//editNumberを""に変更
$editNumber = "";

//以下表示処理

try{
	$pdo = new PDO($dsn,$user,$sqlPassword);
	$sql2 = "SELECT * FROM DB2";
	$stmt = $pdo->query($sql2);
	//echo $stmt;
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo('<p>');
		echo($row['id'].': ');
		echo($row['name'].'さん'.':: ');
		echo($row['time']);
		echo "<font color = \"#cococo\">".$row['hensyuu']."</font>"."<br>";
		echo nl2br(($row['comment']));
	//	echo(',time='.$row['time']);
		
   //	echo(',name='.$row['name']);
   		echo('</p>');
	}
	$pdo = null;
}
catch(PDOExcepiton $e){
	print('エラーが発生しました'.e-getMessage());
	die();
}
//}


?>

</html>