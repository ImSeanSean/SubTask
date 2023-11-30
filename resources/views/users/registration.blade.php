<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SubTask | Registration</title>
    <link rel="icon" href="/images/logoSMNT.ico" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ asset('/css/registration.css') }}" rel="stylesheet">
    <title>SubTask</title>
</head>
<body>
    <div class="left">
        <hr class="top">
        <img src="{{ asset('/images/subtaskLogo.png')}}">
        <div class="registration-form">
            <div class="header">
                <h1>Productivity Awaits</h1>
                <p>Enter the required registration details</p>
            </div>
            <div class="form-body">
                <form method="POST" actions="/users">
                    <div>
                        <label>Username</label>
                        <input type="text" name="username" id="username" placeholder="Please enter your desired username...">
                    </div>
                    <label>Email</label>
                    <input type="email" name="email" id="email" placeholder="Please enter your desired email...">
                    <label>Password</label>
                    <input type="password" name="password" id="password" placeholder="Please enter your desired password...">
                    <label>Confirm Password</label>
                    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Please repeat your password...">
                    <input class="submit" type="submit" value="Register">
                </form>
            </div>
        </div>
        <hr class="bottom   ">
    </div>
    <div class="right">
        <hr class="top">
        <div class="whole-text">
            <div class="text-1">
                <p>Efficient.</p>
                <p>Detailed.</p>
                <p>Easy.</p>
            </div>
            <div class="text-2">
                <p>One</p>
                <p class="sub">Sub</p><p class="task">Task</p>
                <p>at a</p>
                <p>Time</p>
            </div>
        </div>
        <hr class="bottom">
    </div>
</body>
</html>