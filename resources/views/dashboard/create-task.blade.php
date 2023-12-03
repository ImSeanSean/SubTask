<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('/css/create-task.css')}}">
    <link rel="icon" href="/images/logoSMNT.ico" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="layout">
        <div class="sidebar"><!--Sidebar-->
            <div class="top">
                <div class="logo">
                    <img src="{{ asset('images/logoSM.png') }}" alt="logo" class="logoIcon">
                </div>
            </div>
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
        <div class="main-content">
            <div class="heading">
                <h1>Create Task</h1>
                <hr>
            </div>
            <div class="task-form">
                <form class="form-grid">
                    <div class="upper-form">
                        <div class="task-name">
                            <label>Task Name</label>
                            <input type="text" name="task-name" placeholder="Enter the task name...">
                        </div>
                        <div>
                            <label>Date</label>
                            <input type="date" name="due-date" placeholder="Enter the date...">
                        </div>
                        <div>
                            <label>Color</label>
                            <div class="color-radio">
                                <div class="red">
                                    <input class="radio-input" type="radio" value="red" name="color" id="red">
                                    <label class="radio-label" for="red">Red</label>
                                </div>
                                <div class="blue">
                                    <input class="radio-input" type="radio" value="blue" name="color" id="blue">
                                    <label class="radio-label" for="blue">Blue</label>
                                </div>
                                <div class="green">
                                    <input class="radio-input" type="radio" value="green" name="color" id="green">
                                    <label class="radio-label" for="green">Green</label>
                                </div>
                                <div class="yellow">
                                    <input class="radio-input" type="radio" value="yellow" name="color" id="yellow">
                                    <label class="radio-label" for="yellow">Yellow</label>
                                </div>
                                <div class="orange">
                                    <input class="radio-input" type="radio" value="orange" name="color" id="orange">
                                    <label class="radio-label" for="orange">Orange</label>
                                </div>
                                <div class="purple">
                                    <input class="radio-input" type="radio" value="purple" name="color" id="purple">
                                    <label class="radio-label" for="purple">Purple</label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label>Time</label>
                                <input type="time">
                        </div>
                    </div>
                    <hr>
                    <div class="description">
                        <label>Description</label>
                        <textarea name="description" placeholder="Enter description" rows=""></textarea>
                    </div>
                    <hr>
                    <div class="bottom-part">
                        <div class="left">
                            <div class="subtasks">
                                <label>Add SubTasks</label>
                                <input type="text" name="subtask-1" placeholder="SubTask 1">
                                <input type="text" name="subtask-2" placeholder="SubTask 2">
                                <input type="text" name="subtask-3" placeholder="SubTask 3">
                                <input type="text" name="subtask-4" placeholder="SubTask 4">
                                <input type="text" name="subtask-5" placeholder="SubTask 5">
                            </div>
                            <div class="button">
                            <input type="submit" name="task-name" value="Create Task">
                            </div>
                        </div>
                        <div class="right">
                            <div>
                                <label>Preview</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>   
    </div>
</body>
</html>