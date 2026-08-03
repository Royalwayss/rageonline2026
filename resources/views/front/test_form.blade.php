<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    <!-- Include reCAPTCHA v3 Script -->
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}" async defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Login</h2>

        <!-- Login Form -->
        <form id="loginForm">
            @csrf

            <!-- Username Input -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"  placeholder="Enter Username" value="{{ old('username') }}">
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"  placeholder="Enter Password">
            </div>

            <!-- Hidden reCAPTCHA Response Field -->
            <input type="hidden1" name="g-recaptcha-response" id="g-recaptcha-response">

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <!-- Error message -->
        <div id="error-message" class="alert alert-danger mt-3" style="display: none;"></div>
    </div>

    <!-- Include jQuery (for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- reCAPTCHA Logic and AJAX -->
    <script>
        // Add CSRF token to AJAX setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Form Submit Handling
        $('#loginForm').submit(function(event) { alert(1);
        event.preventDefault(); // Prevent the default form submission

        if($('#g-recaptcha-response').val() == ''){

                    // Call reCAPTCHA verification before form submission
                    grecaptcha.ready(function() {
                        grecaptcha.execute("{{  env('RECAPTCHA_SITE_KEY') }}", { action: "login" }).then(function(token) {
                            // Set the token to the hidden input field
                            $('#g-recaptcha-response').val(token);
            
                            // Now submit the form via AJAX
                            submitForm();
                        });
                    });
        }else{
            submitForm();
        }
        
        
        
        
    });

        // Function to submit the form using AJAX
        function submitForm() {
            // Collect form data
            var formData = $('#loginForm').serialize();

            // Perform the AJAX request to the backend
            $.ajax({
                url: "{{ url('t-form') }}",  // Your route for form submission
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // If successful, redirect to dashboard
                        alert('ookkkk');
                    } else {
                        // Show errors
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    $('#error-message').text('An error occurred. Please try again.').show();
                }
            });
        }
    </script>
</body>
</html>
