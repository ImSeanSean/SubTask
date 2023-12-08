<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="{{asset('/css/landing-page.css')}}"> 
    <title>SubTask</title> 
</head> 
<body> 
    <div class="main"> 
        <div id="Contai1"> 
        </div> 
        <hr>
        <div id="Contai2"> 
            <div id="text"> 
                <span class="sub-text">S</span>
                <span class="sub-text">U</span>
                <span class="sub-text">B</span>
                <br>
                <span class="task-text">T</span>
                <span class="task-text">A</span>
                <span class="task-text">S</span>
                <span class="task-text">K</span>
            </div> 
        </div> 
        <div id="Contai3"> 
            <div id="container"> 
                <div id="logo"> 
                    <a href="#">
                        <img src="{{asset('/images/subtaskLogo.png')}}">
                    </a>
                </div> 
                <div id="menu"> 
                    <ul> 
                        <a href="#">
                            <li>Features</li>
                        </a>
                        <a href="#">
                            <li>About us</li>  
                        </a>
                        <a href="/registration">
                            <li>Registration</li>
                        </a>
                        <a href="/login">
                            <li>Log-in</li>
                        </a>
                    </ul> 
                </div> 
            </div> 
        </div> 
    </div> 
</body>
</html>