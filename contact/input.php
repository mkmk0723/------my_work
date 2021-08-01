<?php

session_start();
 

session_regenerate_id( TRUE );
 

require '../libs/functions.php';
 

$name = isset( $_SESSION[ 'name' ] ) ? $_SESSION[ 'name' ] : NULL;
$email = isset( $_SESSION[ 'email' ] ) ? $_SESSION[ 'email' ] : NULL;
$message = isset( $_SESSION[ 'message' ] ) ? $_SESSION[ 'message' ] : NULL;
$error = isset( $_SESSION[ 'error' ] ) ? $_SESSION[ 'error' ] : NULL;
 
$error_name = isset( $error['name'] ) ? $error['name'] : NULL;
$error_email = isset( $error['email'] ) ? $error['email'] : NULL;
$error_message = isset( $error['message'] ) ? $error['message'] : NULL;
 

if ( !isset( $_SESSION[ 'ticket' ] ) ) {
 
  $_SESSION[ 'ticket' ] = sha1( uniqid( mt_rand(), TRUE ) );
}
 

$ticket = $_SESSION[ 'ticket' ];
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
    
    <title>入力画面|Annemiki</title>
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
   
    <h2 class="section-title">Contact</h2>
    
    <form action="../contact/confirm.php" method="post" name="form" novalidate>
    
      <div>
        <label for="name">NAME:</label>
         <span class="error"><?php echo h($error_name);?></span>
        <input type="text" class="validate max50 required" id="name" name="name" value="<?php echo h($name);?>">
      </div>
        
      <div>
        <label for="e-mail">E-mail:</label>
       <span class="error"><?php echo h($error_email);?></span>
      <input type="email" class="validate mail required" id="email" name="email"  value="<?php echo h($email);?>">
      </div> 
       
      <div>
        <label for="message">MESSAGE:</label>          
        <span class="error"><?php echo h($error_message);?></span>
        <textarea class="validate max1000 required" id="message"name="message" ><?php echo h($message);?></textarea>
     </div>
    
     <button type="submit" class="btn btn_primary" name="submit"　value="確認する">確認する</button>
     <input type="hidden" name="ticket" value="<?php echo h($ticket);?>">
   
    </form>

</section><!--#contact-->

 


<footer>
    <P><small>&copy;2021 Annemiki</small></P>
</footer>






</body>
</html>