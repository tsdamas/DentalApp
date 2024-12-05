<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Recovery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        h3 {
            font-size: 1.5rem;
        }
        .form-control {
            max-width: 300px; 
        }
        button {
            font-size: 0.875rem; 
        }
        .container.text-center {
            margin-top: 100px; 
        }
        .error-message {
            color: red;
            font-size: 0.875rem; 
        }
    </style>
</head>
<body class="bg-body-tertiary">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fs-6" href="#">
                <img src="./images/dental_logo.png" alt="Logo" width="55" height="55" class="align-text-middle">
                DentalHash
            </a>
        </div>
    </nav>

    <div class="container text-center">
        <h3 id="title">Enter your email below</h3>
        <form method="post" action="" id="password-recovery-form">
            <input type="email" name="email" class="form-control mx-auto my-3" placeholder="Enter your email" required>
            <button type="submit" class="btn btn-primary" id="email-submit">Submit</button>
        </form>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent default form submission
            // Check if we're in the email input stage or code verification stage
            const title = document.getElementById('title');
            if (title.textContent.includes("Enter your email below")) {
                title.innerHTML =
                    "Please check your email for a verification code <br> and enter it below. This may take some time.";
                this.innerHTML = `
                    <input type="text" name="code" class="form-control mx-auto my-3" placeholder="Enter verification code" required>
                    <button type="submit" class="btn btn-primary">Submit</button>
                `;
            } else {
                //incorrect verification code case
                const codeField = this.querySelector('input[name="code"]');
                const errorMsg = this.querySelector('.error-message');
                // Replacement for legitimate validation upon fuctionality
                if (codeField.value.trim() !== "1234") {
                    if (!errorMsg) {
                        const errorDiv = document.createElement('div');
                        errorDiv.classList.add('error-message');
                        errorDiv.textContent = "Incorrect verification code. Please try again.";
                        this.insertBefore(errorDiv, this.lastElementChild); // Add message above the submit button
                    }
                }
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>