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
                <form method="POST" action="/users">
                    @csrf
                    <div>
                        <label>Username</label>
                        <input type="text" name="name" id="name" placeholder="Please enter your desired username..." value={{old('name')}}>

                        @error('name')
                            <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" id="email" placeholder="Please enter your desired email..." value={{old('email')}}>

                        @error('email')
                            <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <div>
                        <label>Password</label>
                        <input type="password" name="password" id="password" placeholder="Please enter your desired password..." value={{old('password')}}>

                        @error('password')
                            <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <div>
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Please repeat your password..." value={{old('password_confirmation')}}>

                        @error('password_confirmation')
                            <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <input class="submit" type="submit" value="Register">
                </form>
            </div>
        </div>
        <hr class="bottom">
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