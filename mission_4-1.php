
<?php
header("Content-Type: text/html; charset=UTF-8");

/*MySQLの設定とデータベースの作成*/
$dsn = "DatabaseName";
$user = "UserName";
$password = "Password";		
$pdo = new PDO($dsn,$user,$password);

$sql = "CREATE TABLE tb4_1"
." ("
."id INT AUTO_INCREMENT,"
."name char(32),"
."comment TEXT,"
."pass char(32),"
."time TIMESTAMP,"
."INDEX(id)"
.");";
$stmt = $pdo->query($sql);

//


$name_e = "名前";
$comment_e = "コメント";
$enum = "編集対象番号";
if(isset($_POST["name"])&&$_POST["name"]!=""&&isset($_POST["comment"])&&$_POST["comment"]!=""){
	if($_POST["enum"]=="編集対象番号"){
		$sql = 'SELECT NOW();';
		$time = $pdo->query($sql); 	
		$sql = $pdo -> prepare("INSERT INTO tb4_1 (name,comment,pass) VALUES (:name,:comment,:pass)");
		$sql -> bindParam(':name',$name,PDO::PARAM_STR);
		$sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
		$sql -> bindParam(':pass',$pass,PDO::PARAM_STR);			
		$name=$_POST["name"];
		$comment=$_POST["comment"];
		$pass=$_POST["pass"];
		$sql -> execute();
	}
}

if(isset($_POST["delete"])&&$_POST["delete"]!=""){
	$id=$_POST["delete"];
	$pass = $_POST["pass_d"];
	$sql = 'SELECT*FROM tb4_1';
	$result = $pdo->query($sql);
	foreach($result as $row){
		if($id==$row['id']){
			if($pass==$row['pass']){	
				$sql = "delete from tb4_1 where id=$id";
				$result = $pdo->query($sql);
			}
		}
	}
	
}

if(isset($_POST["edit"])&&$_POST["edit"]!=""){
	$id=$_POST["edit"];
	$pass=$_POST["pass_e"];
	$enum=$_POST["edit"];
	$sql = 'SELECT*FROM tb4_1';
	$result = $pdo->query($sql);
	foreach($result as $row){
		if($id == $row['id']){
			if($pass==$row['pass']){
				$name_e = $row['name'];
				$comment_e = $row['comment'];
			}else{
				$enum="編集対象番号";
			}
		}
	}
}

?>


<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UTF-8">
<font size="2">
</head>
<body>
<form action = "mission_4-1.php" method = "POST" name = "form1">
<input type = "text" name = "name" value = <?php echo $name_e; ?> ><br/>
<form action = "mission_4-1.php" method = "POST" name = "form2">
<input type = "text" name = "comment" value = <?php echo $comment_e; ?> >
<form action = "mission_4-1.php" method = "POST"><br/>
新規パスワード<br/>
<input type = "text" name = "pass" value = "password"><br/>
<input type = "hidden" name = "enum" value = <?php echo $enum; ?> >
<input type = "submit" value = "送信">
</form>
<br/>
<form action = "mission_4-1.php" method = "POST" >
<input type = "text" name ="delete" value = "削除対象番号">
<form action = "mission_4-1.php" method = "POST"><br/>
パスワード<br/>
<input type = "password" name = "pass_d" value = ""><br/>
<input type = "submit" value = "送信">
</form>
<br/>
<form action = "mission_4-1.php" method = "POST" >
<input type = "text" name ="edit" value = <?php echo $enum; ?> >
<form action = "mission_4-1.php" method = "POST"><br/>
パスワード<br/>
<input type = "password" name = "pass_e" value = ""><br/>
<input type = "submit" value = "送信">
</form>
<font size="3">


<?php

if(isset($_POST["name"])&&$_POST["name"]!=""&&isset($_POST["comment"])&&$_POST["comment"]!=""){
	if($_POST["enum"]!="編集対象番号"){
		$name = $_POST["name"];
		$comment = $_POST["comment"];
		$id=$_POST["enum"];
		$pass=$_POST["pass"];	
		$sql = 'SELECT*FROM tb4_1';
		$result = $pdo->query($sql);
		$sql = "update tb4_1 set name='$name', comment='$comment' , pass='$pass' where id = $id";
		$result = $pdo -> query($sql);
	}
}


	
$sql = 'SELECT*FROM tb4_1 ORDER BY id';
$results = $pdo -> query($sql);
foreach($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['time'].'<br>';
	//echo $row['pass'].'<br>';
}	  

?>