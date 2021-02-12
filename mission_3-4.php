<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>mission_3-4</title>
    </head>
    <body>
        
<?php
    $filename = "mission_3-4.txt";
    
    // 投稿フォームの変数定義
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y/m/d H:i:s");
    $editNumber = $_POST["editNumber"];
    
    // 削除フォームの変数定義
    $delete = $_POST["delete"];
    
    // 編集フォームの変数定義
    $edit = $_POST["edit"];
    
    //通し番号
    $fp = fopen($filename, "r");
    for( $count = 1; fgets( $fp ); $count++ ); 
    fclose($fp);
    
    //ファイルへの書き込み（投稿フォーム）
    if(isset($name, $comment)  && empty($editNumber)) {
        $fp = fopen($filename,"a");
        $data = $count . "<>" . $name . "<>" . $comment . "<>" . $date . PHP_EOL; 
        fwrite($fp, $data);
        fclose($fp);
    } else {
        if(file_exists($filename)) {
            $fp = fopen($filename,"a");
            $items = file($filename, FILE_IGNORE_NEW_LINES);
            foreach($items as $item){
                        if (isset($item)) {
                                $splitItem = explode("<>", $item);
                                // 投稿番号を取得
                                $postNumber = $splitItem[0];
                                if ($postNumber === $editNumber) {
                                    // 編集したいnameとcommentの値を取得
                                    $edit2 = $editNumber;
                                    $editName2 = $name;
                                    $editComment2 = $comment;
                                    
                                    $change_data = $edit2 . "<>" . $editName2 . "<>" . $editComment2 . 
                                    "<>";
                                    file_put_contents($filename, $change_data . PHP_EOL);
                                } 
        
    }
    
    //ファイルへの書き込み（削除フォーム）
    if(isset($delete)){ //delete変数があるか判定
            $items = file($filename, FILE_IGNORE_NEW_LINES);//items変数を定義
            $fp = fopen($filename, "w");//新規ファイルに書き込み
            fclose($fp);//ファイルをクローズ
        foreach($items as $item) {//配列を変数に代入してループ処理
            $outcome =explode("<>", $item);//文字列を分割
            if($delete !== $outcome[0]) {//$deleteと$outcome[0]が一致しない場合
                $fp = fopen($filename,"a");//追記モード
                fwrite($fp, $item.PHP_EOL);//書き込み
                fclose($fp);//クローズ
            }else {
                //変化なし
            }
        }
    }
    
    //ファイルへの書き込み（編集フォーム） 
    if(isset($edit)) {
        $fp = fopen($filename,"r"); 
        $items = file($filename, FILE_IGNORE_NEW_LINES);
        foreach($items as $item) {
            $splitItem = explode("<>", $item);
            $postNumber = $splitItem[0];
            
            if($postNumber === $edit) {
                $editName = $splitItem[1];
                $editComment = $splitItem[2];
                
                fclose($fp);
            }
            
        }
        
    }
    
    
    
    ?>
    
    <!--投稿フォーム-->
        <form action="mission_3-4.php" method="POST">
            <input type="text" name="name" value="<?php echo $editName; ?>" placeholder="名前"><br>
            <input type="text" name="comment" value="<?php echo $editComment; ?>" placeholder="コメント">
            <input type="hidden" name="editNumber" value="<?php echo $editNumber; ?>">
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
        
        <!--編集番号指定フォーム-->
        
        <p>
            <form action="" method="POST">
                <input type="number" name="edit" placeholder="編集番号を指定してください">
                <input type="submit" name="submit" value="編集">
            </form>
        </p>
    
    
        
    <?php
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
