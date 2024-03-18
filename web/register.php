<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Register</h2>
            <form id="registerForm" action="registerFunc.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="nickname">Nickname:</label>
                    <input type="text" class="form-control" id="nickname" name="nickname" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="form-group">
                    <label for="profile_picture">Profile Picture:</label>
                    <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
                <a href="login.php" class="btn btn-secondary btn-block">Back to Login</a>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Client-side validation using JavaScript
    document.getElementById("registerForm").addEventListener("submit", function(event) {
        var password = document.getElementById("password").value;
        var confirm_password = document.getElementById("confirm_password").value;
        if (password !== confirm_password) {
            alert("Password and confirm password do not match!");
            event.preventDefault();
        }
    });
</script>

</body>
</html>
