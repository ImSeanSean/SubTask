<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SubTask | Dashboard</title>
    <link rel="icon" href="/images/logoSMNT.ico" type="image/x-icon">
    {{-- <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ asset('/css/main-dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/single-task.css') }}" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="sidebar" id="sidebar"><!--Sidebar-->
        <div class="top">
            <div class="logo">
                <a href="/">
                <img src="{{ asset('images/subtaskLogo.png') }}" alt="logo" class="logoIcon">
                </a>
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
                <a href="/dashboard/analytics">
                    <i class='bx bx-analyse bx-sm'></i>
                    <span class="nav-item">Analytics</span>
                </a>
                {{-- <span class="tooltip">Analytics</span> --}}
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
        <div class="taskboard">
            <div class="upper-container"> <!--Upper Container-->
                <div class="search"> <!--Search-->
                    <form>
                        <button type="submit" class="border-0"><i class='bx bx-search-alt-2 bx-md' style='color:#415a77'></i></button>
                        <input type="text" id="search" name="search" placeholder="Search here...">
                        <select name="color">
                            <option class="select-definition" value="">Filter by Color</option>
                            <option class="select-options" style="color: #F6828C" value="red">Red</option>
                            <option class="select-options" style="color: #52bfff" value="blue">Blue</option>
                            <option class="select-options" style="color: #37ce57" value="green">Green</option>
                            <option class="select-options" style="color: #cdcf2b" value="yellow">Yellow</option>
                            <option class="select-options" style="color: #F6B382" value="orange">Orange</option>
                            <option class="select-options" style="color: #D882F6" value="purple">Purple</option>
                        </select> 
                        <select name="due_date">
                            <option class="select-definition" value="">Filter by Due-Date</option>
                            <option class="select-options" value="3"> 3 Days</option>
                            <option class="select-options" value="2">2 Days</option>
                            <option class="select-options" value="1">1 Day</option>
                            <option class="select-options" value="0">Today</option>
                        </select>
                    </form>
                </div>
                <div class="notification">
                    <i class='bx bxs-bell bx-md' style='color:#415a77'  onclick="toggleNotif()"><span>-{{$notifications->count()}}-</span></i>
                </div>
                <div class="notification-box" id="box">
                    <h2>Notification<span>{{$notifications->count()}}</span></h2> 
                    @foreach ($notifications as $notification)
                    <div class="notification-item">
                        <div class="text">
                            <p>{{ $notification->message }}</p>
                        </div>
                    </div>
                    @endforeach
                    <a href="/tasks/clear-notifications" style="padding: 20px;">clear all notifications</a>
                </div>
            </div>

            <hr><!--Line Break-->

            <div class="taskboard-center"><!--List of Tasks-->
                <div class="upper-taskboard">
                    <div class="my-tasks">
                        <p>My Tasks</p>
                    </div>
                    <div class="sorting">
                        <form id="sortForm" action="/dashboard/main" method="get">
                            <label for="sortBy">Sort by:</label>
                            <select id="sortBy" name="sort" onchange="submitForm()">
                                <option></option>
                                <option value="due-date">Due Date</option>
                                <option value="completed_subtasks_count">Completion</option>
                                <option value="updated_at">Recently Changed</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="task-list">
                    <x-task-component :tasks="$tasks"/>
                </div>
            </div>
        </div>

        <div class="secondary-area"><!--Secondary Area-->
            <div class="top">
                <div class="progress-bar">
                    <div class="circular-progress">
                        <div class="progress-value">

                        </div>                        
                    </div>
                </div>
                <div class="complete">
                    <h3>{{$completedTasksCount}} Completed</h3>
                    <p>from {{$tasks->count()}} projects</p>
                </div>
            </div>
            <div class="bottom">
                <div class="recent_project"><!-- Recent Project -->
                    <div class="listing">
                            <div class="title">
                                <h2>Subtask</h2>
                                <h4>Due date</h4>
                                <p>Description</p>
                            </div>
                            <div class="main-subtask">
                                <div class="subtasks">
                                    <h4>Subtask</h4>
                                    <input type="checkbox" disabled>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    <x-add-task />
    <x-flash-message />

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{asset('/js/sidebar-circle.js')}}"> </script>
</body>
<script>
    let btn = document.querySelector("#btn")
    let sidebar = document.getElementById("sidebar");

    btn.onclick = function() {
        sidebar.classList.toggle('active')
    };

    function submitForm() {
            document.getElementById('sortForm').submit();
        }

    var box = document.getElementById('box');
    var down = false;

    function toggleNotif() {
    if (down) {
        box.style.height = '0px';
        box.style.opacity = '0px';
        box.style.display = 'none'; // hide the box
        down = false;
    } else {
        box.style.height = '510px';
        box.style.opacity = '1';
        box.style.display = 'block'; // show the box
        down = true;
    }

    
}
</script>


</html>