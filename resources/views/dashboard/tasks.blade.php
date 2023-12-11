<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SubTask | Dashboard</title>
    <link rel="icon" href="/images/logoSMNT.ico" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ asset('/css/main-dashboard.css') }}" rel="stylesheet">
</head>

<body>
    <div class="sidebar" id="sidebar"><!--Sidebar-->
        <div class="top">
            <div class="logo">
                <img src="{{ asset('images/subtaskLogo.png') }}" alt="logo" class="logoIcon">
            </div>
            <i class="bx bx-menu bx-md" id="btn"></i>
        </div>
        <div class="user">
            <img src="{{ asset('images/user-img.png') }}" alt="me" class="user-img">
        </div>
        <p class="bold">{{auth()->user()->name}}</p>
        <ul>
            <li>
                <a href="/dashboard/main">
                    <i class='bx bx-grid-alt bx-sm'></i>
                    <span class="nav-item">Dashboard</span>
                </a>
                {{-- <span class="tooltip">Dashboard</span> --}}
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-notification bx-sm'></i>
                    <span class="nav-item">Notifications</span>
                </a>
                {{-- <span class="tooltip">Notifications</span> --}}
            </li>
            <li>
                <a href="/dashboard/tasks">
                    <i class='bx bx-task bx-sm'></i>
                    <span class="nav-item">Tasks</span>
                </a>
                {{-- <span class="tooltip">Tasks</span> --}}
            </li>
            <li>
                <a href="/dashboard/analytics">
                    <i class='bx bx-analyse bx-sm'></i>
                    <span class="nav-item">Analytics</span>
                </a>
                {{-- <span class="tooltip">Analytics</span> --}}
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-collapse-alt bx-sm'></i>
                    <span class="nav-item">SubSpaces</span>
                </a>
                {{-- <span class="tooltip">SubSpaces</span> --}}
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-cog bx-sm'></i>
                    <span class="nav-item">Settings</span>
                </a>
                {{-- <span class="tooltip">Settings</span> --}}
            </li>
            <hr class="solid">
            <li>
                <a href="/logout">
                    @csrf
                    <i class='bx bx-log-out-circle bx-sm'></i>
                    <span class="nav-item">Log-out</span>
                </a>
                {{-- <span class="tooltip">Logout</span> --}}
                {{-- <form>
                    @csrf
                    <button style="background: none; border: none; padding: 0; cursor: pointer; margin-left: 10px; padding-top: 5px">
                        <i class='bx bx-log-out-circle bx-sm' style='color:#334152'></i>
                        <span class="nav-item" style="color:#334152; font-size:16px; padding-left: 5px; padding-bottom: 20px;">Logout</span>
                    </button>
                </form> --}}
                <span class="tooltip">Logout</span>
            </li>
        </ul>
    </div>

    <div class="main-content"><!--Dashboard-->
        @unless(count($tasks) == 0)
            @foreach($tasks as $task)
                <h2>{{$task['name']}}</h2>
                <p>{{$task['description']}}</p>
            @endforeach

            @else
            <p>No tasks found</p>
        @endunless
    </div>
</body>

<script>
    let btn = document.querySelector("#btn")
    let sidebar = document.querySelector(".sidebar")


    btn.onclick = function() {
        sidebar.classList.toggle('active')
    };
</script>

</html>