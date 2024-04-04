<?php
require_once 'Database.php';
require_once 'SubleaseLogic.php'; // Adjust the path as necessary

// Mocking $uri, $get, and $post for demonstration. You'll need to adapt this part.
$uri = '/login';
$get = $_GET;
$post = $_POST;

// Instantiating and running your application logic
$application = new SubleaseLogic($uri, $get, $post);
$application->run();
?>
<!--  reference https://stackoverflow.com/questions/22658141/-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Title</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/main.css">
  <style>
    html {
      min-height: 100%;
      /* fill the screen height to allow vertical alignement */
      display: flex;
      /* display:flex works too since body is the only grid cell */
    }

    body {
      margin: auto;
    }

    form {
      width: 330px;
      padding: 1rem;

    }
  </style>
</head>

<body>


  <div class="container-header" id="home">

    <div class="header">
      <div class="pl-logo" id="pl-logo">
        <a href="index.html">
          <img src="pl_logo.jpg">
        </a>
      </div>
    </div>
  </div>

  <main class="form-signin w-100 m-auto">
<<<<<<< HEAD

    <form action="/login" method="POST">
=======
    <form action="map.php" method="POST">
>>>>>>> parent of cb6424b (url navigations)
      <h1 class="h3 mb-3 fw-normal">Welcome!</h1>


        



        <form action="login.php" method="POST">
          <div class="form-floating">
            <!-- Change 'type' to 'text' and add 'name' attribute for server-side processing -->
            <input type="text" class="form-control" id="floatingInput" name="phonenumber" placeholder="Phone Number">
            <label for="floatingInput">Phone Number</label>
          </div>
          <div class="form-floating">
            <!-- Add 'name' attribute for server-side processing -->
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
            <label for="floatingPassword">Password</label>
          </div>

          <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
            <label class="form-check">
              Remember me </label>
              <button type="submit" class="btn btn-primary py-2" style="width: 48%;">LOG in</button>
              <a href="signup.php" class="btn btn-outline-primary py-2" style="width: 48%;">Sign up</a>
              <p class="mt-5 mb-3 text-body-secondary">© 2017–2024</p>

      </form>
<!-- 
      
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script>
    document.getElementById('signupBtn').addEventListener('click', function () {
      window.location.href = 'signup.php';
    });
  </script>
</body>

</html>