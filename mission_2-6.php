<?php
	header("Content-Type: text/html; charset=UTF-8");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<h1> プログラミングのお勉強 </h1>

<?php
//ファイル作成orそのまま
$textfile = 'text26.txt';
if(file_exists($textfile) == false){
	touch($textfile);
}
$editNumber = "";
//編集ボタンを押した後の処理
if(!empty($_POST['edit']) && !empty($_POST['editPassword'])){

	$arrayList = file($textfile);
	$getNumber = $_POST['edit'];
	$editName = "";
	$editComment = "";
	$editPass = "";
	$getPass = $_POST['editPassword'];
	$flag = false;
	foreach($arrayList as $line){
		$word = explode("<>", $line);
		if($word[4] == $getPass){
			if($word[0] == $getNumber){
				$editName = $word[1];
				$editComment = $word[2];
				$editPass = $word[4];
				// echo $editName."\n<br>";
				// echo $editComment."\n<br>";
				 echo "【編集モード】".$getNumber."番目の編集を行います！名前、パスワード、コメントを入力して送信で編集！";
				$flag = true;
			}
		}
	}
if($flag != true){
	echo "編集パスワードが違います";
	$flag = false;
}
//editNumberを数字に変更
	$editNumber = $getNumber;
//echo $_POST['editable'];
}
?>


<title>楽しいプログラミング</title>
<form action = "mission_2-6.php" method = "post">
名前  :
<input type = "text" name = "name" value = "<?php echo $editName;?>">
パスワード  :
<input type = "text" name = "password" value = "<?php echo $editPass;?>">
</br>
</br>

コメント  :
<!--<textarea name = "comment" value = "<?php echo $editComment;?>" cols = "50" rows "10"></textarea></br>-->
<input type = "text" name = "comment" value = "<?php echo $editComment;?>" size = "60"></br>
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


//削除処理
if($_POST['remove'] != NULL && $_POST['removePassword'] != NULL && $_POST['removeButton']){
	$arrayList = file($textfile);
	$getNumber = $_POST['remove'];
	$getPass = $_POST['removePassword'];
	$text = "";
	$flag = false;
	foreach($arrayList as $line){
 		$pieces = explode("<>",$line);
		if($getPass == $pieces[4]){
			if($pieces[0] != $getNumber){
				$text = $text.$line;
			 }
		if($pieces[0] == $getNumber){
			$text = $text."削除されました"."\n";
     		$flag = true;
   		}
   		}elseif($getPass != $pieces[4]){
    		$text = $text.$line;
  		}
 	}
	if($flag != true){
 		echo "削除失敗！パスワードが違います<br>";
		$flag = false;
	}
	file_put_contents($textfile, $text);
	
 	
	//file_put_contents($textfile, $text);
	//editNumberを""に変更
	$editNumber = "";
}
//普通の送信
if($_POST['name'] != NULL && $_POST['comment'] != NULL && $_POST['password'] != NULL){

	$flag = $_POST['editable'];

 	if($flag == ""){
 		$name1 = $_POST['name'];
 		$comment1 = $_POST['comment'];
		$time = date("Y/m/d/ H:i:s");
		$num = count(file($textfile)) + 1;
		$password = $_POST['password'];
		$addText = $num."<>".$name1."<>".$comment1."<>".$time."<>".$password."<>";
		
		
		
		
		$corrent = file_get_contents($textfile);
		$corrent = $corrent.$addText."\n";
 		
		file_put_contents($textfile, $corrent);
 		// echo "書き込みモードですよ<br>";
 	}

//編集送信
	if($flag != ""){
		$arrayList = file($textfile);
		$text = "";
		foreach($arrayList as $line){
			$word = explode("<>", $line);
			if($word[0] != $flag){
				$text = $text.$line;
			}
			if($word[0] == $flag){
				$text = $text.$flag."<>".$_POST['name']."<>".$_POST['comment']."<>".date("Y/m/d H:i:s")."<>".$_POST['password']."<>"."\n";
			}
		}
		file_put_contents($textfile, $text);
	}
}
//editNumberを""に変更
$editNumber = "";

//以下表示処理
$arrayList = file($textfile);

foreach($arrayList as $list){
	$pieces = explode("<>", $list);
	if(count($pieces) > 1){
		echo $pieces[0].":".$pieces[1]."さん ::".$pieces[3]."<br>「".$pieces[2]."」";
		/* foreach($pieces as $word){
		echo $word[0].":".$word[1]."さん ::".$word[3]."<br>「".$word[2]."」";
 	}*/
 	}else{
 		 echo $pieces[0];
	}
	echo "<br><br>";
}


?>

</html>