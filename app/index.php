<?php
  require_once 'model/post.php';
  session_start();

  if (isset($_POST['create'])) {
    $err = [];

    $text = filter_input(INPUT_POST, 'text');
    if(strlen($text) < 1){
      $err['text'] = "内容が入力されていません。\n";
    }

    if (empty($err)) {
      Post::create([
        'user_id' => $_SESSION['id'],
        'text' => $text,
      ]);
      header('Location: ./');
    }
  }

  if (isset($_POST['delete'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    Post::delete([
      'user_id' => $_SESSION['id'],
      'id' => $id,
    ]);
    header('Location: ./');
  }

  $posts = Post::fetch_all();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>研修</title>
  </head>
  <body>
    <h1>PHP掲示板</h1>
    <div>

      <?php if(isset($_SESSION['email'])): ?>
        <a href="./logout.php">Logout</a>
      <?php else: ?>
        <a href="./sign_up.php">SignUp</a>
        <a href="./login.php">Login</a>
      <?php endif; ?>



      <?php if(isset($_SESSION['email'])): ?>
        <p style="border-bottom: solid #ccc 1px;">ログイン中：<?=$_SESSION['name']?></p>
      <?php else: ?>
        <p style="border-bottom: solid #ccc 1px;">未ログイン</p>
      <?php endif; ?>


      <?php if(isset($_SESSION['email'])): ?>
        <form action="" method="post">
          <textarea name="text" cols="50" rows="10"></textarea>
          <button type="submit" name="create">Create</button>
        </form>
        <?php if( !empty($err) ): ?>
          <ul>
            <?php foreach( $err as $value ): ?>
              <li><?php echo $value; ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      <?php endif; ?>

      <?php foreach( $posts as $post ): ?>
        <div style="border-bottom: solid #ccc 1px;">
          <p>投稿ID: <?=$post['id']?></p>
          <p>内容: <?=$post['text']?></p>
          <p>投稿者: <?=$post['create_by']?></p>
          <p>投稿日時: <?=$post['create_at']?></p>
          <?php if($_SESSION['id']===$post['user_id']): ?>
            <form action="" method="post">
              <input type="hidden" name="id" value="<?=$post['id']?>">
              <button type="submit" name="delete">Delete</button>
            </form>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </body>
</html>