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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                <h1>Edit Task</h1>
                <hr>
            </div>
            <div class="task-form">
                <form class="form-grid" method="POST" action="/dashboard/tasks/{{$task->id}}">
                    @csrf
                    @method('PUT')
                    <div class="upper-form">
                        <div class="task-name">
                            <label>Task Name</label>
                            <input type="text" name="name" placeholder="Enter the task name..." value={{$task['name']}}>
                            @error('name')
                            <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                        <div>
                            <label>Due Date</label>
                            <input type="datetime-local" name="due-date" placeholder="Enter the date..." value="{{ $task['due-date'] ? \Carbon\Carbon::parse($task['due-date'])->format('Y-m-d\TH:i') : '' }}">
                            @error('due-date')
                            <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                        <div>
                            <label>Color</label>
                            <div class="color-radio">
                                <div class="red">
                                    <input class="radio-input" type="radio" value="red" name="color" id="red" {{ $task['color'] == 'red' ? 'checked' : '' }}>
                                    <label class="radio-label" for="red">Red</label>
                                </div>
                                <div class="blue">
                                    <input class="radio-input" type="radio" value="blue" name="color" id="blue" {{ $task['color'] == 'blue' ? 'checked' : '' }}>
                                    <label class="radio-label" for="blue">Blue</label>
                                </div>
                                <div class="green">
                                    <input class="radio-input" type="radio" value="green" name="color" id="green" {{ $task['color'] == 'green' ? 'checked' : '' }}>
                                    <label class="radio-label" for="green">Green</label>
                                </div>
                                <div class="yellow">
                                    <input class="radio-input" type="radio" value="yellow" name="color" id="yellow" {{ $task['color'] == 'yellow' ? 'checked' : '' }}>
                                    <label class="radio-label" for="yellow">Yellow</label>
                                </div>
                                <div class="orange">
                                    <input class="radio-input" type="radio" value="orange" name="color" id="orange" {{ $task['color'] == 'orange' ? 'checked' : '' }}>
                                    <label class="radio-label" for="orange">Orange</label>
                                </div>
                                <div class="purple">
                                    <input class="radio-input" type="radio" value="purple" name="color" id="purple" {{ $task['color'] == 'purple' ? 'checked' : '' }}>
                                    <label class="radio-label" for="purple">Purple</label>
                                </div>
                            </div>                            
                            @error('color')
                            <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                        {{-- <div>
                            <label>Time</label>
                                <input type="time">
                                @error('time')
                                <span class="error">{{$message}}</span>
                                @enderror
                        </div> --}}
                    </div>
                    <hr>
                    <div class="description">
                        <label>Description</label>
                        <textarea name="description" placeholder="Enter description" rows="">{{$task['description']}}</textarea>
                        @error('description')
                            <span class="error">{{$message}}</span>
                        @enderror
                    </div>
                    <hr>
                    <div class="bottom-part">
                        <div class="left">
                            <div class="subtasks">
                                <label>Edit SubTasks</label>
                                @for ($i = 0; $i < 5; $i++)
                                    @if (isset($task->subtasks[$i]))    
                                        <input type="text" name="subtask-{{ $i+1 }}" placeholder="SubTask {{ $i+1 }}" value="{{ $task->subtasks[$i]->name }}">
                                        @error('subtask-' . ($i+1))
                                            <span class="error">Must not be greater than 15 characters.</span>
                                        @enderror
                                    @else
                                        <input type="text" name="subtask-{{ $i+1 }}" placeholder="SubTask {{ $i+1 }}">
                                        @error('subtask-' . ($i+1))
                                            <span class="error">Must not be greater than 15 characters.</span>
                                        @enderror
                                    @endif
                                @endfor
                            </div>
                            <div class="button">
                                <div class="input-submit">
                                    <input type="submit" name="task-name" value="Update Task">
                                </div>
                                <div class="form">
                                    <form method="POST">
                                        <a href="/dashboard/tasks/{{$task->id}}/delete" class="edit" onclick="confirmation(event)"><i class='bx bx-trash' style='color:#0a0a0a'  ></i></a>
                                    </form>
                                </div>
                            </div>
                        </div>  
                    </div>
                </form>
            </div>
        </div>   
    </div>
    <script>
        function confirmation(ev){
            ev.preventDefault();
            var urlToRedirect=ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);

            swal({
                title:"Are you sure?",
                text:"This action is irreversible.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })

            .then((willCancel)=>{
                if(willCancel){
                    window.location.href=urlToRedirect;

                }
            });
        }
    </script>
</body>
</html>