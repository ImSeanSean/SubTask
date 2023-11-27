<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SubTask | Login</title>
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
</head>
<body>
    <div class="all">
        <div class="left">
            <hr>
            <img class="logo" src="{{ asset('images/subTaskLogo.png') }}">
            <div class="text">
                <p>Finish tasks</p>
                <p >by completing</p>
                <p class="first-line">one </p>
                <p class="second-line">Sub</p><p class="third-line">Task</p>
                <p>at a time</p>
            </div>
            <hr>
        </div>
        <div class="right">
            <hr>
            <div class="welcome">
                <h1>Welcome!</h1>
                <p>Let's get those tasks going.</p>
            </div>
            <form>
                <label>E-mail</label>
                <input type=email name="email" id="email" placeholder="Please type your email">
                <label>Password</label>
                <input type=password name="password" id="password" placeholder="Please type your password">
                <input type="submit" value="Log-in">
            </form>
            <a href="/registration">Don't have an account?</a>
            <hr>
        </div>
    </div>
</body>
</html>