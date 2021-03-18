<!DOCTYPE html>
<html lang="ja">
<meta charset="UTF-8">
<head>
<title>mission_5-1</title>
</head>
<body>
<form action="" method="post">
    <input type="text" name="name"  placeholder="名前"
    value="<?php if(!empty($_POST["edit"])&&$_POST["password"])echo$edit_name;?>"> 

    <br>
    <input type="text" name="comment" placeholder="コメント"
    value="<?php if(!empty($_POST["edit"])&&$_POST["password"])echo$edit_comment;?>"> 

    <br>
    <input hidden="number" name="edit2"
    value="<?php if(!empty($_POST["edit"])&&$_POST["password"])echo $edit_number;?>">
    <br>
    <input type="text" name="password" 
    placeholder="パスワード">
    <input type="submit" name="submit"> 
    </form>
    <br>
<form action="" method="post">
    <input type="text" name="delete" placeholder="削除する番号">
    <input type="text" name="password" placeholder="パスワード">
    <input type="submit" name="submit" value="削除">
    </form>

<form action=""method="post">
    <input type="text" name="edit" placeholder="編集番号">
    <input type="text" name="password" placeholder="パスワード">
    <input type="submit" name="submit" value="編集">
    </form>


<?php

error_reporting(E_ALL&~E_NOTICE);

//データベースの接続
$dsn=データベースの接続
$user=ユーザー名
$password=パスワード
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

//データベース内にテーブルを作成
$sql="CREATE TABLE IF NOT EXISTS tbtest"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date DATETIME,"
."password char(32)"
.");";
$stmt=$pdo->query($sql);

$date = date("Y-m-d H:i:s");

//name, comment,password存在したら、データベースに挿入して抽出して表示
if($_POST["name"]!=""&&$_POST["comment"]!=""&&$_POST["password"]!="")
{
$name=$_POST["name"];
$comment=$_POST["comment"];
$date = date("Y-m-d H:i:s");
$password=$_POST["password"];

 $sql=$pdo->prepare("INSERT INTO tbtest (name,comment,date,password) VALUES(:name,:comment,:date,:password)");
 $sql->bindParam(':name',$name,PDO::PARAM_STR);
 $sql->bindParam(':comment',$comment,PDO::PARAM_STR);
 $sql->bindParam(':date',$date,PDO::PARAM_STR);
 $sql->bindParam(':password',$password,PDO::PARAM_STR);
 $sql->execute();

 $sql = 'SELECT * FROM tbtest';
 $stmt = $pdo->query($sql);
 $results = $stmt->fetchAll();
 foreach ($results as $row){
		
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
	    echo $row['date'].',';
        echo $row['password'].',';
        echo "<hr>";
	}
 }

 //削除番号とパスワードが存在したら、データベースから削除番号と一致するものを削除し、削除が完了したデータを抽出し、表示する
if($_POST["delete"]!=""&&$_POST["password"]!=""){
    $id = $_POST["delete"];
	$sql = 'delete from tbtest where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();

    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].',';
        echo $roe['password'].',';
        echo "<hr>";
    }
	}
	

//編集フォーム入力時に、名前、コメント、編集番号を取得
if(isset($_POST["edit"])&&$_POST["password"]!=""){
    $edit=$_POST["edit"];
    $_POST["edit"]=$id;
    $edit_name = $name;
    $edit_comment=$comment;

        
//編集番号と投稿番号が等しいとき、データベースを編集してから、抽出して表示
if($edit_numbar!=""&&$edit_number == $id){
   $id = "$edit_numbar"; 
   $name="$edit_name";
   $comment="$edit_comment"; 
   $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
   $stmt = $pdo->prepare($sql);
   $stmt->bindParam(':id', $id, PDO::PARAM_INT);
   $stmt->bindParam(':name', $name, PDO::PARAM_STR);
   $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
   $stmt->bindParam(':date',$date, PDO::PARAM_STR);
   $stmt->bindParam(':password'.$password,PDO::PARAM_STR);
   $stmt->execute();

   $sql = 'SELECT * FROM tbtest';
   $stmt = $pdo->query($sql);
   $results = $stmt->fetchAll();
   foreach ($results as $row){
       
       echo $row['id'].',';
       echo $row['name'].',';
       echo $row['comment'].',';
       echo $row['date'].',';
       echo $roe['password'].',';
       echo "<hr>";
   }
}
	}
    

$sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    echo $stmt->rowCount()."個のデータあります! (デバッグ)<br>";
    $results = $stmt->fetchAll(); 
    foreach ($results as $row){
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
        echo $row['password'].',';
        echo "<hr>";
        }

    
?>

</body>
</html>