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
    <label for="validationServer01">First name</label>
    <input type="text" class="form-control is-valid" id="validationServer01" placeholder="First name" value="Yoon"
      required>
    <div class="valid-feedback">
      Looks good!
    </div>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationServer02">Last name</label>
      <input type="text" class="form-control is-valid" id="validationServer02" placeholder="Last name" value="Lee"
        required>
      <div class="valid-feedback">
        Looks good!
      </div>
      <div class="col-md-3 mb-3">
        <label for="validationServer05">Email</label>
        <input type="text" class="form-control <?= isset($errorMessages['email']) ? 'is-invalid' : '' ?>" name="email"
          id="validationServer05" placeholder="Email" required>
        <div class="invalid-feedback">
          <?php echo $errorMessages['email'] ?? "Please provide an Email address."; ?>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationServerUsername">Phone Number (User_ID)</label>
        <input type="text" class="form-control <?= isset($errorMessages['phone']) ? 'is-invalid' : '' ?>" name="phone"
          id="validationServerUsername" placeholder="Phone Number" required>
        <div class="invalid-feedback">
          <?php echo $errorMessages['phone'] ?? "Please enter a valid phone number. It will be used as your user ID for login."; ?>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label for="validationServer03">Password</label>
          <input type="text" class="form-control is-invalid" id="validationServer03" placeholder="Password" required>
          <div class="invalid-feedback">
            Please provide a password
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <label for="validationServer04">Confirm password</label>
          <input type="text" class="form-control is-invalid" id="validationServer04" placeholder="Confirm Password"
            required>
          <div class="invalid-feedback">
            Password matches: {YES OR NO}
          </div>
        </div>
        <a href="login.html" class="btn btn-primary" type="submit" id="submitBtn">Submit form</a>
        </form>
        

      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck3" required>
          <label class="form-check-label" for="invalidCheck3">
            Agree to terms and conditions
          </label>
          <div class="invalid-feedback">
            You must agree before submitting.
          </div>
        </div>
      </div>

      <!-- <a href="login.html" class="btn btn-primary" type="submit">Submit form</a> -->
      </form>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>