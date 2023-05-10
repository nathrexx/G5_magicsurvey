<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="/js/validation.js" defer></script>
</head>
<body>
    
    <h1>Signup</h1>
    
    <form action="process-signup.php" method="post" id="signup" novalidate>
        <div>
            <label for="first_name">First Name</label>
            <input type="text" id="firstName" name="first_name">
        </div>
        
        <div>
            <label for="last_name">Last Name</label>
            <input type="text" id="lastName" name="last_name">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="text" id="Email" name="email">
        </div>

        <div>
            <label for="phone_number">Phone Number</label>
            <input type="text" id="phoneNumber" name="phone_number">
        </div>
        
        <div>
            <label for="password">Password</label>
            <input type="text" id="Password" name="password">
        </div>
        
        <button>Sign up</button>
    </form>

    <form action="login.php">
        <button type="submit">Login</button>
    </form>

    <form action="homepage.html">
        <button type="submit">Continue Anonymously</button>
    </form>
    
</body>
</html>
