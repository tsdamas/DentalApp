<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User Login Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
        <div class="container-fluid vh-100 d-flex">
            <div class="row w-100 align-items-center">
                <div class="col-6">
<!--                    <video width="320" height="240" controls>
                        <source src="./images/login-video.mp4" type="video/mp4">
                    </video>-->
<!--<div class="embed-responsive embed-responsive-1by1">-->
<!--                    <video class="h-100" autoplay>
                            <source src="./images/login-video.mp4" type="video/mp4">
                    </video>-->
                    <!--</div>-->
                </div>
                <div class="col-6 col-xs-12 d-flex justify-content-center">
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
                            <input type="password" name="password" class="form-control" id="password-login-field">
                        </div>
                        <button type="submit" name="submit" value="login" class="btn btn-primary">Submit</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>

