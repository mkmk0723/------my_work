<?php

session_start(); 
 
require '../libs/functions.php'; 
 

$_POST = checkInput( $_POST );
 

if ( isset( $_POST[ 'ticket' ], $_SESSION[ 'ticket' ] ) ) {
  $ticket = $_POST[ 'ticket' ];
  if ( $ticket !== $_SESSION[ 'ticket' ] ) {

    die( 'Access Denied!' );  
  }
} else {
 
  die( 'Access Denied（直接このページにはアクセスできません）' );
}
 

$name = isset( $_POST[ 'name' ] ) ? $_POST[ 'name' ] : NULL;
$email = isset( $_POST[ 'email' ] ) ? $_POST[ 'email' ] : NULL;
$message = isset( $_POST[ 'message' ] ) ? $_POST[ 'message' ] : NULL;
 

$name = trim( $name );
$email = trim( $email );
$message = trim( $message);
 

$error = array();
 

if ( $name == '' ) {
  $error['name'] = '*お名前は必須項目です。';

} else if ( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $name ) == 0 ) {
  $error['name'] = '*お名前は30文字以内でお願いします。';
}
if ( $email == '' ) {
  $error['email'] = '*メールアドレスは必須項目です。';
} else {
  $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/uiD';
  if ( !preg_match( $pattern, $email ) ) {
    $error['email'] = '*メールアドレスの形式が正しくありません。';
  }
}

if ( $message == '' ) {
  $error['message'] = '*内容は必須項目です。';
  //制御文字（タブ、復帰、改行を除く）でないことと文字数をチェック
} else if ( preg_match( '/\A[\r\n\t[:^cntrl:]]{1,1050}\z/u', $message ) == 0 ) {
  $error['message'] = '*内容は1000文字以内でお願いします。';
}
 
//POSTされたデータとエラーの配列をセッション変数に保存
$_SESSION[ 'name' ] = $name;
$_SESSION[ 'email' ] = $email;
$_SESSION[ 'message' ] = $message;
$_SESSION[ 'error' ] = $error;
 
//チェックの結果にエラーがある場合は入力フォームに戻す
if ( count( $error ) > 0 ) {
  //エラーがある場合
  $dirname = dirname( $_SERVER[ 'SCRIPT_NAME' ] );
  $dirname = $dirname == DIRECTORY_SEPARATOR ? '' : $dirname;
  $url = ( empty( $_SERVER[ 'HTTPS' ] ) ? 'http://' : 'https://' ) . $_SERVER[ 'SERVER_NAME' ] . $dirname . '/input.php';
  header( 'HTTP/1.1 303 See Other' );
  header( 'location: ' . $url );
  exit;
} 
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Annemiki ポートフォリオ">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="../images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="theme-color" content="#ffffff">
    <script src="https://kit.fontawesome.com/007c7ca2db.js" crossorigin="anonymous"></script>
    
    <title>確認画面 | Annemiki</title>
    <!--CSS-->
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,500&display=swap" rel="css/style.css">
    <link rel="stylesheet" href="../css/style.css">
   <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

   

</head>
<body>
 



<section id="contact" class="wrapper contact-bg">
    <h1 class="name-logo-contact">Annemike</h1> 
    <div>
      
	 <form id="confirm" action="../contact/thanks.php" method="post">
            <h1 class="section-title">お問い合わせ 内容確認</h1>
            <p>お問い合わせ内容はこちらで宜しいでしょうか？<br>よろしければ「送信する」ボタンを押して下さい。<br>
            内容を変更する場合は「戻る」をクリックして入力画面にお戻りください。</p>
            <div>
                <br>
                <div>
                    <label>NAME:</label>
                    <p><?php echo h($name); ?></p>
                </div>
                <br>
                <div>
                    <label>E-mail:</label>
                    <p><?php echo h($email); ?></p>
                </div>
                 <br>
                <div>
                    <label>MESSAGE:</label>
                    <p><?php echo nl2br(h($message)); ?></p>
                </div>
                
                <div class="btn-item">
                 <button type="button" class="btn btn-secondary"onclick="history.back(-1)">戻る</button>
                 <input type="hidden" name="ticket" value="<?php echo h($ticket);?>">
                 <button type="submit"  class="btn btn-success">送信する</button>
              
              </div>
            </div>
   </form>
  </div>
   
</section><!--#contact-->
 


<footer>
    <P><small>&copy;2021 Annemiki</small></P>
</footer>





</body>
</html>