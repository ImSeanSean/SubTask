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
    <div class="sidebar"><!--Sidebar-->
        <div class="top">
            <div class="logo">
                <img src="{{ asset('images/subtaskLogo.png') }}" alt="logo" class="logoIcon">
            </div>
        </div>
        <i class="bx bx-menu bx-md" id="btn"></i>
        <div class="user">
            <img src="{{ asset('images/user-img.png') }}" alt="me" class="user-img">
        </div>
        <p class="bold">{{'Sean'}}</p>
        <ul>
            <li>
                <a href="/dashboard/main">
                    <i class='bx bx-grid-alt bx-sm'></i>
                    <span class="nav-item">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-notification bx-sm'></i>
                    <span class="nav-item">Notifications</span>
                </a>
                <span class="tooltip">Notifications</span>
            </li>
            <li>
                <a href="/dashboard/tasks">
                    <i class='bx bx-task bx-sm'></i>
                    <span class="nav-item">Tasks</span>
                </a>
                <span class="tooltip">Tasks</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-analyse bx-sm'></i>
                    <span class="nav-item">Analytics</span>
                </a>
                <span class="tooltip">Analytics</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-collapse-alt bx-sm'></i>
                    <span class="nav-item">SubSpaces</span>
                </a>
                <span class="tooltip">SubSpaces</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-cog bx-sm'></i>
                    <span class="nav-item">Settings</span>
                </a>
                <span class="tooltip">Settings</span>
            </li>
            <hr class="solid">
            <li>
                <a href="/logout">
                    @csrf
                    <i class='bx bx-log-out-circle bx-sm'></i>
                    <span class="nav-item">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
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
                    </form>
                </div>
                <div class="notification">
                    <i class='bx bxs-bell bx-md' style='color:#415a77'  ></i>
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
                                <option value="completion">Completion</option>
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
            <p> Task Completion</p>
        </div>
    </div>
    <x-add-task />
    <x-flash-message />

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
<script>
    let btn = document.querySelector("#btn")

    btn.onclick = function() {
        sidebar.classList.toggle('active')
    };

    function submitForm() {
            document.getElementById('sortForm').submit();
        }
</script>

</html>