<?php
// session_start(); // Ensure session starts at the very beginning
require_once 'Database.php';
require_once 'SubleaseLogic.php'; // Adjust the path as necessary

// Mocking $uri, $get, and $post for demonstration. You'll need to adapt this part.
$uri = '/signup';
$get = $_GET;
$post = $_POST;

// Instantiating and running your application logic
$application = new SubleaseLogic($uri, $get, $post);
$application->run();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <!-- Sign up section -->
  <section>
    <div class="logo">
      <h1>Sign up</h1>
    </div>
  </section>
  <section>
    <!-- Inside your HTML body where the signup form is defined -->
   
    <?php if (!empty($_SESSION['errorMessages'])): ?>

      <div class="alert alert-danger" role="alert">
          <?php foreach ($_SESSION['errorMessages'] as $message): ?>
              <?= htmlspecialchars($message) ?><br>
          <?php endforeach; ?>
          <?php unset($_SESSION['errorMessages']); // Clear messages after displaying ?>
      </div>
    <?php endif; ?>

        <form action="signup.php" method="POST">
            <!-- Form fields... -->
            <input type="text" name="first_name" placeholder="First name" required>
            <input type="text" name="last_name" placeholder="Last name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Sign Up</button>
        </form>

        
        <div class="col-md-3 mb-3">
          

          <div class="invalid-feedback">
            Password matches: {YES OR NO}
          </div>
        </div>



      </div>
      <!-- <div class="form-group">
        <div class="form-check">
          <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck3" required>
          <label class="form-check-label" for="invalidCheck3">
            Agree to terms and conditions
          </label>
          <div class="invalid-feedback">
            You must agree before submitting.
          </div>
        </div>
      </div> -->

      
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>