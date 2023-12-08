<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="task-card-2">
        <div class="main-task">
            <div class="sidebar"></div>
            <div class="left">
                <h3>Task Activity BlaBla</h3>
                <label>06/27/90</label>
            </div>
            <div class="circular-progress">
                    <span class="progress-value">0</span>
            </div>
            <div class="button">
                <i class='bx bx-chevron-down bx-sm'></i>
            </div>
        </div>
        <div class="subtask">
            <div class="arrow">
                <i class='bx bx-subdirectory-right bx-lg' ></i>
            </div>  
            <div class="subtask-details">
                <div class="sidebar"></div>
                <div class="left">
                    <h3>OOP</h3>
                    <label>02/14/2023</label>
                </div>
                <div class="percent">
                    <label>100%</label>
                </div>
                <div class="button">
                    <i class='bx bx-chevron-down bx-sm'></i>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
