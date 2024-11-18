<?php


include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');

include('includes/header.inc.php');

if(!isset($_SESSION['id']))
{
    header('Location: dashboard.php');
    die();
}

if (isset($_POST['email'])) 
{
  if ($stm = $connect->prepare('SELECT * FROM user WHERE email = ? AND password = ? AND active = 1'))
  {
      $hashed = SHA1($_POST['password']);
      $stm->bind_param('ss', $_POST['email'], $hashed);
      $stm->execute();

      $result = $stm->get_result();
      $user = $result->fetch_assoc();

      if ($user)
      {
          $_SESSION['id'] = $user['id'];
          $_SESSION['email'] = $user['email'];
          $_SESSION['username'] = $user['username'];

          set_message("You are logged in " . $_SESSION['username']);
          header('Location: dashboard.php');
          die();
      }
      $stm->close();

  } 
  else 
  {
      echo 'Could not prepare statement!';
  }
}

?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form method="post">
        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
          <input type="email" id="email" name="email" class="form-control" />
          <label class="form-label" for="email">Email address</label>
        </div>

        <!-- Password input -->
        <div data-mdb-input-init class="form-outline mb-4">
          <input type="password" id="password" name="password" class="form-control" />
          <label class="form-label" for="password">Password</label>
        </div>

        <!-- Submit button -->
        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Sign in</button>
      </form>
    </div>
  </div>
</div>

<?php
include('includes/footer.inc.php');
?>