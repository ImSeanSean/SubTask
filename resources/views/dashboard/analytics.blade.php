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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css" />
    <link href="{{ asset('/css/analytics.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
          var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/api/due-dates'
          });
          calendar.render();
        });
    </script>
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
        <div class="left">
            <div class="top">
                <div class="title">
                    <h1>Report & Analytics</h1>
                </div>
                <div class="body">
                    <div class="heading">
                        <h2>Summary</h2>
                    </div> 
                    <div class="summary">
                        <ul>
                            
                            @foreach($logs->items() as $log)
                            <li>
                                <h4>{{$log->log_type}}</h4>
                                <p>{{$log->description}}</p>
                                <label>{{$log->created_at}}</label>
                            </li>
                            @endforeach
                        </ul>
                        <div class="pagination">
                            {{$logs->links()}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div class="heading">
                    <h2>Graph & Statistics</h2>
                </div>
                <div class="graphs">
                    <div class="line-graph">
                        <h3>Activity in Last 7 Days</h3>
                        <div class="programming-stats">
                            <div class="chart-container">
                                <canvas class="graph"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="pie-graph">
                        <h3>Completion</h3>
                        <div class="programming-stats">
                            <div class="chart-container">
                                <canvas class="chart"></canvas>
                            </div>
                            <div class="details">
                                <ul>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="top">
                <div class="heading">
                    <h2>Tasks Overview</h2>
                </div>
                <div class="calendar" id="calendar">

                </div>
            </div>
            <div class="bottom">
                <div class="heading">
                    <h2>Total Progress</h2>
                </div>
                <div class="progress-bar">
                        <div class="percentage-bar" style="width: {{$percentage}}">
                            <p>{{$percentage}}</p>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <x-flash-message />
</body>
<script>
    let btn = document.querySelector("#btn")
    let sidebar = document.getElementById("sidebar");

    btn.onclick = function() {
        sidebar.classList.toggle('active')
    };
    //Line Graph
    const graph = document.querySelector(".graph");
    fetch('/api/graph-data')
            .then((response) => response.json())
            .then((data) => {
                // Update your chart with the received data
                updateGraph(data);
            }).catch((error) => console.error("Error fetching data:", error));
    
    function updateGraph(data){
        new Chart(graph, {
            type: "line",
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Last 7 Days',
                    data: data.data,
                    tension: 0.1,
            }]
            },
            options: {
                borderWidth:3,
                borderRadius: 2,
                hoverBorderWidth: 0,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        })
    }
    //Pie Chart
    const chart = document.querySelector(".chart");
    const ul= document.querySelector(".programming-stats ul");

    fetch('/api/chart-data')
            .then((response) => response.json())
            .then((data) => {
                // Update your chart with the received data
                updateChart(data);
            }).catch((error) => console.error("Error fetching data:", error));

    function updateChart(data){
            new Chart(chart, {
            type: "doughnut",
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: "Percentage",
                        data: data.dataPercentage,
                        backgroundColor: [
                        'rgba(130, 246, 156, 0.8)', // Completed color
                        'rgba(246, 130, 140, 0.8)', // Pending color
                        'rgba(130, 204, 246, 0.8)'  // In-progress color
                        ]
                    }
                ]
            },
            options: {
                borderWidth:10,
                borderRadius: 2,
                hoverBorderWidth: 0,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const populateUl = () => {
            data.labels.forEach((l, i) => {
                let li = document.createElement("li");
                li.innerHTML = `${l}: <span class='percentage'>${data.data[i]}</span>`;
                ul.appendChild(li);
            });
        }
        populateUl();
    }
</script>

</html>