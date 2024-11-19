<!DOCTYPE html>
<html>
    <head>
        <title>User Login Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col">
                <div class="login-container">
                    <form method="post" action="dashboard.php">
                        <h3> Login Form </h3>
                        <br>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">@</span>
                            <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="mb-3">
                            <label for="password-label" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <button type="submit" name="submit" value="login" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </body>
</html>

