<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_5-1</title>
    </head>
    
    <body>
        <?php
        //DBへ接続
        $dsn = 'mysql:dbname=*****;host=localhost';
        $user = '******';
        $password = 'PASSWORD';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
         
        //DBへテーブルの作成
        $sql = "CREATE TABLE IF NOT EXISTS tbtest"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT,"
        . "pass char(32),"
        . "date DATETIME"
        .");";
        $stmt = $pdo->query($sql);
    
        
        if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"]) && empty($_POST["editn"]))
        {   //DB入力
            $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment, pass, date) VALUES (:name, :comment, :pass, :date)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(":pass", $pass, PDO::PARAM_STR);
            $sql -> bindParam(":date", $date, PDO::PARAM_STR);
            $name = ($_POST["name"]);
            $comment = ($_POST["comment"]);
            $pass= ($_POST["pass"]);
            $date = date("Y/m/d H:i:s");
            $sql -> execute();
        }
            
            //削除機能
            if(!empty($_POST["delete"]) && !empty($_POST["delpass"]))
            {
              $id = $_POST["delete"];
              $delpass = $_POST["delpass"];
              $sql = 'SELECT * FROM tbtest WHERE id=:id ';  
              $stmt = $pdo->prepare($sql);                  
              $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
              $stmt->execute();                             
              $results = $stmt->fetchAll(); 
              foreach ($results as $row2)
              {  
                if($row["id"]==$id && $pass==$delpass)
                {
                $sql = 'delete from tbtest where id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                }
              }
            }
            
            //編集機能
if(!empty($_POST['edit'])&&!empty($_POST['edipass']))
{ //編集フォームが埋まっていたら 
        $id = ($_POST["edit"]); 
        $edipass = ($_POST["edipass"]);
        $sql = 'SELECT * FROM tbtest WHERE id=:id'; //idが一致する行を抜き出し 
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、 
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、 
        $stmt->execute();                             // ←SQLを実行する。 
        $results = $stmt->fetchAll(); 
        foreach ($results as $row2)
        {
        if($row['id'] == $id && $row["pass"] ==$edipass)
            { 
               $results[0]=$row2["id"];
               $results[1]=$row2["name"];
               $results[2]=$row2["comment"];
            }
        }
}
    //編集 
    if(!empty($_POST['editn']))
    {
                 $id = ($_POST["editn"]);
                 $name = ($_POST["name"]); 
                 $comment =  ($_POST["comment"]); 
                 $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id'; 
                 $stmt = $pdo->prepare($sql); 
                 $stmt->bindParam(':name', $name, PDO::PARAM_STR); 
                 $stmt->bindParam(':comment', $comment, PDO::PARAM_STR); 
                 $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
                 $stmt->execute(); 
    }

      
        $sql ='SHOW CREATE TABLE tbtest';
        $result = $pdo -> query($sql);
        foreach ($result as $row){
        echo $row[1];
        }
        echo "<hr>";
     ?>
     <form action="m5-1.php" method="post">
            <input type="text" name="name" value="<?php if(!empty($row2["name"])) {echo $row2['name'];}?>" placeholder="名前"><br>
            <input type="text" name="comment" value="<?php if(!empty($row2["comment"])) {echo $row2['comment'];}?>" placeholder="コメント"><br>
            <input type="text" name="pass" value="" placeholder="パスワード"><br>
            <input type="submit" name="submit" value = "送信"><br>
            <input type="hidden" name="editn" value="<?php if(!empty($row2["id"])) {echo $row2['id'];}?>"placeholder="編集">
            
            <input type="delete" name="delete" value="" placeholder="削除"><br>
            <input type="text" name="delpass" value="" placeholder="パスワード"><br>
            <input type="submit" name="submit" value="削除">
            <br>
            <input type="edit" name="edit" value="" placeholder="編集"><br>
            <input type="text" name="edipass" value="" placeholder="パスワード"><br>
            <input type="submit" name="submit" value="編集">
    </form>
    <?php
    // DB表示
            $sql = 'SELECT * FROM tbtest';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row3)
            {
               echo $row3['id'].' ';
               echo $row3['name'].' ';
               echo $row3['comment']." ";
               echo $row3["pass"]." ";
               echo $row3["date"]." ";
               echo "<hr>";
            }
    
    ?>
    </body>
    </html>
    
        
    


        
        
        