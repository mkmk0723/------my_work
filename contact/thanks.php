<?php

session_start(); 

require '../libs/functions.php'; 

require '../libs/mailvars.php'; 
 

date_default_timezone_set('Asia/Tokyo'); 

$_POST = checkInput( $_POST );
 

if ( isset( $_POST[ 'ticket' ], $_SESSION[ 'ticket' ] ) ) {
  $ticket = $_POST[ 'ticket' ];
  if ( $ticket !== $_SESSION[ 'ticket' ] ) {

    die( 'Access denied' );
  }
} else {

  $dirname = dirname( $_SERVER[ 'SCRIPT_NAME' ] );
  $dirname = $dirname == DIRECTORY_SEPARATOR ? '' : $dirname;
  $url = ( empty( $_SERVER[ 'HTTPS' ] ) ? 'http://' : 'https://' ) . $_SERVER[ 'SERVER_NAME' ] . $dirname . '/contact.php';
  header( 'HTTP/1.1 303 See Other' );
  header( 'location: ' . $url );
  exit; 
}
 

$name = h( $_SESSION[ 'name' ] );
$email = h( $_SESSION[ 'email' ] ) ;
$message = h( $_SESSION[ 'message' ] );
 
//メール本文の組み立て
$mail_body = 'コンタクトページからのお問い合わせ' . "\n\n";
$mail_body .=  date("Y年m月d日 H時i分") . "\n\n"; 
$mail_body .=  "【 NAME 】:  " .$name . "\n\n";
$mail_body .=  "【 E-mail 】： " . $email . "\n\n"  ;
$mail_body .=  "【 MESSAGE 】 :" . "\n\n" . $message;
  
//-------- sendmail（mb_send_mail）を使ったメールの送信処理------------
 

$mailTo = mb_encode_mimeheader(MAIL_To_NAME) ."<" . MAIL_To. ">";
 
$subject = 'Annemiki Portfolio から　お問い合わせがありました。';
$returnMail = MAIL_RETURN_PATH; 

mb_language( 'ja' );
mb_internal_encoding( 'UTF-8' );
 

$header = "From: " . mb_encode_mimeheader($name) ."<" . $email. ">\n";


if ( ini_get( 'safe_mode' ) ) {

  $result = mb_send_mail( $mailTo, $subject, $mail_body, $header );
} else {
  $result = mb_send_mail( $mailTo, $subject, $mail_body, $header, '-f' . $returnMail );
}
 

if ( $result ) {

  $_SESSION = array(); 
  session_destroy();

   //自動返信メールの送信処理
  //自動返信メールの送信が成功したかどうかのメッセージを表示する場合は true
  $show_autoresponse_msg = true;
  
  //ヘッダー情報
  $ar_header = "MIME-Version: 1.0\n";
  $ar_header .= "From: " . mb_encode_mimeheader( AUTO_REPLY_NAME ) . " <" . MAIL_To . ">\n";
  $ar_header .= "Reply-To: " . mb_encode_mimeheader( AUTO_REPLY_NAME ) . " <" . MAIL_To . ">\n";
  
  //件名
  $ar_subject = '[自動送信]Annemiki Portfolio お問い合わせ内容の確認';
          
  
  // メール本文
  $ar_body = $name." 様\n\n";
  $ar_body .= "お問い合わせありがとうございます。" . "\n\n";
  $ar_body .= "以下のお問い合わせ内容を、メールにて確認させていただきました。\n\n";
 
  $ar_body .= "～～♪～～♪♪～～♪～～♪～～♪♪～～♪～～♪～～♪♪～～♪～～♪～～♪♪～～♪～～♪～～♪♪～～♪"."\n\n";
 
  $ar_body .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n\n\n";
 
  $ar_body .= "【 NAME 】: " . $name . "\n\n\n";
 
  $ar_body .= "【 E-mail 】：" . $email . "\n\n\n";
  
  $ar_body .= "【 MESSAGE 】 " . "\n\n" . $message."\n\n";
 
  $ar_body .= " ～～♪～～♪♪～～♪～～♪～～♪♪～～♪～～♪～～♪♪～～♪～～♪～～♪♪～～♪～～♪～～♪♪～～♪"."\n\n";        
 
  $ar_body .= "内容を確認のうえ、ご連絡させて頂きます。"."\n\n";
  $ar_body .=  "しばらくお待ちください。" ."\n\n";      
  
  //自動返信の送信（結果を変数 result2 に格納）
  if ( ini_get( 'safe_mode' ) ) {
    $result2 = mb_send_mail( $email, $ar_subject, $ar_body , $ar_header  );
  } else {
    $result2 = mb_send_mail( $email, $ar_subject, $ar_body , $ar_header , '-f' . $returnMail );
  }

  //送信失敗時（もしあれば）

} else {
 
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
    
    <title>完了画面|Annemiki</title>
    <!--CSS-->
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,500&display=swap" rel="css/style.css">
    <link rel="stylesheet" href="../css/style.css">
  

</head>
<body>


<section id="contact" class="wrapper contact-bg">
  <h1 class="name-logo-contact">Annemike</h1> 
     <div class="thanks_text">
       <?php if ( $result ): ?>
		 <h1 class="section-title">お問い合わせ 送信完了</h1>
		 <p>
		  お問い合わせありがとうございました。<br>
		  内容を確認のうえ、回答させて頂きます。<br>
		  しばらくお待ちください。
		</p>
       
        <?php else: ?>
        
        <p>申し訳ございませんが、送信に失敗しました。</p>
        <p>しばらくしてもう一度お試しになるか、メールにてご連絡ください。</p>
        <p>ご迷惑をおかけして誠に申し訳ございません。</p>
       
        <?php endif; ?>
			<button type="button" onclick="location.href='../index.html'">トップページに戻る</button>
    </div> 
</section><!--#contact-->

<footer>
    <P><small>&copy;2021 Annemiki</small></P>
</footer>
</body>
</html>