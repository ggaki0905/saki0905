<head>
  <meta charset = "utf-8">
 </head>
  <h1>掲示板</h1>
  <h2>就活終わったらやりたいこと掲示板<h2>
  <br>
   <p>

<?php
	$dsn = 'データベース名';// ・データベース名：tb210880db
	$user = 'ユーザー名';// ・ユーザー名：tb-210880
	$password = 'パスワード';	// ・パスワード：PZ6T4LVVzj
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));// の学生の場合：
	
	$sql = "CREATE TABLE IF NOT EXISTS mission5text"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
        . "day TEXT,"
        . "pass TEXT"
	.");";
	$stmt = $pdo->query($sql);
//名前とコメントの欄がどちらも埋まっていたら

 if (!empty($_POST['name']) && !empty($_POST['comment'])){
   //パスワードが埋まっていたら
   if (!empty($_POST['pass'])){
     $name = $_POST['name'];
     $comment = $_POST['comment'];
     $day = date("Y年m月d日 H:i:s");
     $password = $_POST['pass'];

     //新規投稿
     if (empty($_POST['editnumber'])){
        //投稿番号を設定
$sql = $pdo -> prepare("INSERT INTO mission5text (name, comment, day, pass) VALUES (:name, :comment, :day, :pass)");
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$sql -> bindParam(':day', $day, PDO::PARAM_STR);
$sql -> bindParam(':pass', $password, PDO::PARAM_STR);
$sql -> execute();
//編集
  }else{
$edit  = $_POST_["editnumber"];
$id = $edit; //変更する投稿番号
	$sql = 'update mission5text set name=:name,comment=:comment,day =:day,pass = :pass where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':day', $id, PDO::PARAM_INT);
	$stmt->bindParam(':pass', $id, PDO::PARAM_INT);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
}
  	}else{
      echo "パスワードを設定してください<br>";
      echo "<hr>";
	 }
}

	
//削除
if(!empty($_POST["deletenumber"])){
	$delete = $_POST["deletenumber"];
	if(empty($_POST["dpass"])){
	echo "パスワードを入力してください<br>";
	}else{
		$password = $_POST["dpass"];
		$sql = 'SELECT * FROM mission5text';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
			if($delete == $row['id']){
				if($password ==$row['pass']){
					$id = $delete;
					$sql = 'delete from mission5text where id=:id';
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':id', $id, PDO::PARAM_INT);
					$stmt->execute();
				}else{
					echo "パスワードが違います<br>";
					echo "<hr>";
			}
		}
	}
}
}
if(!empty($_POST["editnumber"])){
echo "ha";
	 $edit =$_POST["editnumber"];
	 if(empty($_POST["epass"])){
		echo "パスワードを入力してください";
 	}else{;
		$password = $_POST["epass"];
		$sql = 'SELECT * FROM mission5text';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			if ($edit == $row["id"]){              					$editnum = $row["id"];
				if($password ==$row['pass']){
					$editname = $row["name"];
					$editcomment = $row["comment"];
				}else{
					echo "パスワードが違います<br>";
					echo "<hr>";
				}
			}
		}
	}
}

$sql ='SELECT * FROM mission5text';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll(); //結果データを全件まとめて配列で取得
foreach ($results as $row){
//$rowの中にはテーブルのカラム名が入る
echo $row['id'].',';
echo $row['name'].',';
echo $row['comment'].',';
echo $row['day'].'<br>';
echo "<hr>";
}
?>


  </p>
 </div>
 <br>
  
   <form action = "mission_5-1.php" method = "post">
    <div>
     <label for = "name">名前:</label>
     <input type ="text" id = "name" name = "name" value = "<?php if(!empty($editname)){echo $editname;} ?>">
    </div>
    <div> 
     <label for = "comment">コメント:</label> 
     <input type = "text" id = "comment" name="comment" value = "<?php if(!empty($editcomment)){echo $editcomment;} ?>">
    </div>
<input type="hidden" name ="emode" size="30"  value="<?php if(!empty($editname)) {echo $edit;}?>"><br>

    <div>
     <label for = "pass">パスワード:</label> 
     <input type = "text" id = "pass" name="pass">
    </div>
    <input type = "submit" name = "sub" value = "送信">
    <div>
    <input type = "hidden" id = "editednumber" name="editednumber" value = "<?php if(!empty($editnum)){echo $editnum;} ?>">
    </div>
   </form>

   <hr>

  <form action = "mission_5-1.php" method = "post">
   <div>
    <label for = "deletenumber">削除対象番号:</label>
    <input type = "text" id = "deletenumber" name = "deletenumber">
   </div>
   <div>
     <label for = "dpass">パスワード:</label> 
     <input type = "text" id = "dpass" name="dpass">
    </div>
   <input type = "submit" name = "delete" value = "削除">
  </form>

   <hr>

  <form action = "mission_5-1.php" method = "post">
   <div>
    <label for = "editnumber">編集対象番号:</label>
    <input type = "text" id = "editnumber" name = "editnumber">
   </div>
   <div>
     <label for = "epass">パスワード</label> 
     <input type = "text" id = "epass" name="epass">
    </div>
   <input type = "submit" name = "edit" value = "編集">
  </form>

 </body>
</html>

