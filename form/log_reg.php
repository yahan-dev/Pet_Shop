<?php
session_start();
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role == 'admin') {
        $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    }else {
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['user'] = $username;
        $_SESSION['role'] = $role;

        if ($role == 'admin') {
            header("Location: ../ad_Panel/index.php");
        } else {
            $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '../index.php';
            header("Location: $redirect");
        }
    } else {
        echo '<div class="alert alert-danger mt-3">Invalid username or password.</div>';

    }

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

  
    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '../index.php';
        header("Location: $redirect");

    }else {
        $error = "Invalid username or password";
    }

	$sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: log_reg.php");
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<style>
        .valid-feedback {
            display: none;
        }
        .invalid-feedback {
            display: none;
        }
        .is-valid .valid-feedback {
            display: block;
        }
        .is-valid input {
            border-color: green;
        }
        .is-invalid .invalid-feedback {
            display: block;
        }
        .is-invalid input {
            border-color: red;
        }
    </style>
 
</head>
<body>
	
    <div class="login-reg-panel">
		<div class="login-info-box">
			<h2>Have an account?</h2>
			<p>Lorem ipsum dolor sit amet</p>
			<label id="label-register" for="log-reg-show">Login</label>
			<input type="radio" name="active-log-panel" id="log-reg-show"  checked="checked">
		</div>
							
		<div class="register-info-box">
			<h2>Don't have an account?</h2>
			<p>Lorem ipsum dolor sit amet</p>
			<label id="label-login" for="log-login-show">Register</label>
			<input type="radio" name="active-log-panel" id="log-login-show">
		</div>
							
		<div class="white-panel">
		
			<div class="login-show">
				<h2>LOGIN</h2>
  
				<form method="post" action="log_reg.php<?php echo isset($_GET['redirect']) ? '?redirect=' . $_GET['redirect'] : ''; ?>">
					<div class="form-floating mb-3 position-relative">
						<input type="text" class="form-control" id="first-name" name="username" placeholder="username" required  >
						<label for="first-name">User Name</label>
						<div class="valid-feedback">
							username looks good!
						</div>	
						<div id="first-name-error" class="invalid-feedback">
							username should not contain only numeric characters.
						</div>
					</div>
					
					<div class="form-floating mb-3 position-relative">
						<input type="text" class="form-control" id="first-name" name="password" placeholder="password" required  >
						<label for="first-name">Password</label>
						<div class="valid-feedback">
							First Name looks good!
						</div>	
						<div id="first-name-error" class="invalid-feedback">
							First Name should not contain only numeric characters.
						</div>
					</div>
                    <div class="form-group">
                        <label for="role"></label>
                        <select class="form-control" id="role" name="role">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
					<input type="submit" value="Login">
				</form>
				<?php if(isset($error)) echo "<p>$error</p>"; ?>
			</div>

                <div class="register-show">
                <h2>Register</h2>
                    <form action="" method="post">

                    <div class="form-floating mb-3 position-relative">
                            <input type="text" class="form-control" id="first-name" name="username" placeholder="username" required  >
                            <label for="first-name">User Name</label>
                            <div class="valid-feedback">
                                username looks good!
                            </div>	
                            <div id="first-name-error" class="invalid-feedback">
                                username should not contain only numeric characters.
                            </div>
                        </div>


                        <div class="form-floating mb-3 position-relative">
                            <input type="text" class="form-control" id="first-name" name="password" placeholder="password" required  >
                            <label for="first-name">Password</label>
                            <div class="valid-feedback">
                                Password looks good!
                            </div>	
                            <div id="first-name-error" class="invalid-feedback">
                                First Name should not contain only numeric characters.
                            </div>
                        </div>
                        <input type="submit" value="Register">

                    </form>

                    <?php if(isset($error)) echo "<p>$error</p>"; ?>
                </div>
		     
		</div>
	</div>
    <script src="script.js"></script>



	<script>
    // Function to display error message below the input field
    function displayErrorMessage(inputId, message) {
        var inputField = document.getElementById(inputId);
        inputField.classList.remove('is-valid');
        inputField.classList.add('is-invalid');
        var errorDiv = document.getElementById(inputId + '-error');
        errorDiv.textContent = message;
    }

    // Function to hide error message below the input field
    function hideErrorMessage(inputId) {
        var inputField = document.getElementById(inputId);
        inputField.classList.remove('is-invalid');
        inputField.classList.add('is-valid');
    }

    // Add event listeners to input fields for input event
    document.getElementById('first-name').addEventListener('input', function() {
        var regex = /^[0-9]+$/;
        if (regex.test(this.value)) {
            displayErrorMessage('first-name', 'First Name should not contain only numeric characters.');
            this.value = ''; // Clear the field
        } else {
            hideErrorMessage('first-name');
        }
    });

    document.getElementById('nic').addEventListener('input', function() {
        var regex = /^[0-9]{10}v?$|^[0-9]{1,11}$/;
        if (!regex.test(this.value)) {
            displayErrorMessage('nic', 'NIC Number is invalid. It should contain up to 11 digits with an optional \'v\' at the end.');
            this.value = ''; // Clear the field
        } else {
            hideErrorMessage('nic');
        }
    });

    document.getElementById('personal-info-form').addEventListener('submit', function(event) {
        // Prevent form submission
        event.preventDefault();

        // If validation passes, submit the form
        this.submit();
    });
</script>
</body>
</html>





















