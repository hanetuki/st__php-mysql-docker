<?php
  require_once 'const.php';
  require_once 'model/user.php';
  session_start();

  if (isset($_POST['login'])) {
    $err = [];

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!is_string($email)) {
      $err['email'] = "Eメールアドレスの形式が不正です\n";
    }

    $password = filter_input(INPUT_POST, 'password');
    $pass_length = strlen($password);
    if ($pass_length <= MIN_LENGTH_PASSWORD || MAX_LENGTH_PASSWORD <= $pass_length) {
      $err['password'] = "パスワードは8文字以上16文字以内です\n";
    }

    $result = User::login([
      'email' => $email,
      'password' => $password,
    ]);

    if($result){
      $_SESSION['id'] = $result['id'];
      $_SESSION['name'] = $result['name'];
      $_SESSION['email'] = $result['email'];
      header('Location: /');
    } else {
      echo '<a href="/">戻る</a>';
      echo 'ログインに失敗しました。';
      exit;
    }
  }
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>研修|Login</title>
  </head>
  <body>
    <a href="/">戻る</a>
    <h1>Login</h1>
    <form action="" method="post">
      <label for="email">email</label>
      <input type="email" name="email">
      <label for="password">password</label>
      <input type="password" name="password">
      <button type="submit" name="login">Login</button>
    </form>
  </body>
</html>