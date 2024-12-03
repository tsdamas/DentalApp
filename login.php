<!DOCTYPE html>
<html>
<head>
        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User Login Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="./stylesheet.css">
    </head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body class="bg-body-tertiary">  
        <div class="container-fluid vh-100 d-flex">
            <div class="row w-100 align-items-center">
                <div class="col-6 p-0 video-container">
                    <video class="video object-fit-cover" width= "900" height="780" autoplay>
                            <source src="./images/login-video.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="col-6 col-xs-12 justify-content-center">
                    <div class="row">
                    <nav class="navbar">
                        <div class="container-fluid">
                            <a class="navbar-brand fs-6" href="#">
                                <img src="./images/dental_logo.png" alt="Logo" width="55" height="55" class="align-text-middle">
                                DentalHash
                            </a>
                        </div>
                    </nav>
                    </div>
                    <div class="row d-flex" id="login-row">
                    <div class="login-container">                     
                    <form method="post" action="dashboard.php">
                        <h3> Login </h3>
                        <br>
                            <label for="validationCustomUsername" class="form-label username-label">Username</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                <input type="text" name="username" pattern="/^[a-zA-Z ]{3,15}$/" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                         </div>
                        <div class="mb-3">
                            <label for="password-label" class="form-label">Password</label>
                            <input type="password" name="password" pattern="/^[a-zA-Z0-9]{4,8}$/" class="form-control" id="password-login-field" required >
                        </div>
                        <button type="submit" name="submit" value="login" class="btn btn-primary">Submit</button>
                    </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
         <script>
             (() => {
                 'use strict';
                 // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    const forms = document.querySelectorAll('.needs-validation');
                 // Loop over them and prevent submission
  
                Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
                });
            })();
             </script>
             
</body>
</html>

