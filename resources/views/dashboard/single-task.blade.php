<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/css/single-task.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="{{ asset('/js/circular.js')}}"></script>
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
        <div class="modal-taskview">
            <button class="close">X</button>
            <div class="left">
                <div class="header">
                    <div class="title">
                        <h1>Task Title</h1>
                        <h2>Due-Date</h2>
                    </div>
                    <div class="percentage">
                        <div class="circle-percentage">
                            <span class="progress-value">0%</span>
                        </div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="description">
                        <p>This is my web development</p>
                    </div>
                    <div class="list-of-task">
                        <div class="subtask">
                            <h3>SubTask 1</h3>
                        </div>
                        <div class="subtask">
                            <h3>SubTask 2</h3>
                        </div>
                        <div class="subtask">
                            <h3>SubTask 3</h3>
                        </div>
                        <div class="subtask">
                            <h3>SubTask 4</h3>
                        </div>
                        <div class="subtask">
                            <h3>SubTask 5</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="summary-report">
                    <h3>Summary Report</h3>
                </div>
                <hr>
                <div class="summary-list">
                    <ul>
                        <li>Subtask1</li>
                        <li>Subtask1</li>
                        <li>Subtask1</li>
                        <li>Subtask1</li>
                        <li>Subtask1</li>
                    </ul>
                </div>
                <div class="buttons">
                    <button class ="check"><i class='bx bx-check-double' style='color:#c6d24f' ></i></button>
                    <button class ="trash"><i class='bx bxs-trash' style='color:#c6d24f' ></i></button>
                    <button class="update"><i class='bx bxs-edit-alt' style='color:#c6d24f' ></i></button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>