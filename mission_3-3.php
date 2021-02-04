<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>mission_3-3</title>
    </head>
    <body>
        
        <!--投稿フォーム-->
        <form action="" method="POST">
            <input type="text" name="name" placeholder="名前"><br>
            <input type="text" name="comment" placeholder="コメント">
            <input type="submit" name="submit" value="送信">
            <br>
        </form>
        
        <!--削除フォーム-->
        <p>
            <form action="" method="POST">
              <input type="number" name="delete" placeholder="削除対象番号">
              <input type="submit" name="submit" value="削除">
            </form>
        </p>
        
        
<?php
    $filename = "mission_3-3.txt";
    
    // 投稿フォームの変数定義
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y/m/d H:i:s");
    
    // 削除フォームの変数定義
    $delete = $_POST["delete"];
    
    //通し番号
    $fp = fopen($filename, "r");
    for( $count = 1; fgets( $fp ); $count++ ); 
    fclose($fp);
    
    //ファイルへの書き込み（投稿フォーム）
    if(isset($name, $comment)) {
        $fp = fopen($filename,"a");
        $data = $count . "<>" . $name . "<>" . $comment . "<>" . $date . PHP_EOL; 
        fwrite($fp, $data);
        fclose($fp);
    } 
    
    //ファイルへの書き込み（削除フォーム）
    if(isset($delete)){
        $fp = fopen($filename, "a");
        ftruncate($fp, 0); //ファイルを空にする
        fclose($fp);
        foreach($items as $item) {
            $outcome =explode("<>", $item);
            if($delete !== $count) {
                $fp = fopen($filename,"a");
                $data = $count . "<>" . $name . "<>" . $comment . "<>" . $date . PHP_EOL; 
                fwrite($fp, $data);
                fclose($fp);
            }else {
                //書き込まない
            }
        }
    }
    
    
        
    
    //ブラウザへの表示
    if(file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        foreach($lines as $line) {
            $result = explode("<>", $line);
            echo $result[0]. " ". $result[1]. " ". $result[2]. " ". $result[3]. "<br>";
            
        }
        
        
    }
    
?>
    </body>
</html>
