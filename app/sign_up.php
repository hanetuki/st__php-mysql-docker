<?php
  require_once 'const.php';
  require_once 'model/user.php';
  session_start();

  if (isset($_POST['sign_up'])) {
    $err = [];

    $name = filter_input(INPUT_POST, 'name');
    if(strlen($name) < 1){
      $err['name'] = "名前が入力されていません\n";
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!is_string($email)) {
      $err['email'] = "Eメールアドレスの形式が不正です\n";
    }

    $password = filter_input(INPUT_POST, 'password');
    $pass_length = strlen($password);
    if ($pass_length <= MIN_LENGTH_PASSWORD || MAX_LENGTH_PASSWORD <= $pass_length) {
      $err['password'] = "パスワードは8文字以上16文字以内です\n";
    }

    if (empty($err)) {
      $result = User::sign_up([
        'name' => $name,
        'email' => $email,
        'password' => $password,
      ]);

      $_SESSION['id'] = $result['id'];
      $_SESSION['name'] = $result['name'];
      $_SESSION['email'] = $result['email'];
      header('Location: /');
    }
  }
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>研修|SignUp</title>
  </head>
  <body>
    <a href="/">戻る</a>
    <h1>SignUp</h1>
    <form action="" method="post">
      <label for="name">name</label>
      <input type="text" name="name">
      <label for="email">email</label>
      <input type="email" name="email">
      <label for="password">password</label>
      <input type="password" name="password">
      <button type="submit" name="sign_up">SignUp</button>
    </form>
    <?php if( !empty($err) ): ?>
      <ul>
        <?php foreach( $err as $value ): ?>
          <li><?php echo $value; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </body>
</html>