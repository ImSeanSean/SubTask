<div class="modal fade text-left" id="ModalTaskView{{$task['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog custom-width-modal" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-taskview">
                    <button class="close" data-dismiss="modal" aria-label="Close">X</button>
                    <div class="left">
                        <div class="header">
                            <div class="title">
                                <h1 class="font-weight-bold">{{ $task['name'] }}</h1>
                                <h2>@if (!empty($task['due-date'])){{ $task['due-date']}}@else No Due Date @endif</h2>
                            </div>
                            <div class="percentage">
                                <div class="circle-percentage">
                                    <span class="progress-value">0%</span>
                                </div>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="description">
                                <p>{{ $task['description']}}</p>
                            </div>
                            <div class="list-of-task">
                                @foreach ($task->subtasks as $subtask)
                                <div class="subtask">
                                    <h3 class="font-weight-bold">{{$subtask->name}}</h3>
                                </div>
                                @endforeach
                                @for ($i = 0; $i < max(0, 5 - count($task->subtasks)); $i++)
                                    <div class="subtask">
                                        <h3 class="text-muted">...</h3>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="right">
                        <div class="summary-report">
                            <h3 class="font-weight-bold text-center">Summary Report</h3>
                        </div>
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
                            <button class ="trash" href="/dashboard/tasks/{{$task->id}}/delete" onclick="confirmation(event)"><i class='bx bxs-trash' style='color:#c6d24f' ></i></button>
                            <button class="update" onclick="edit({{ $task->id}})"><i class='bx bxs-edit-alt' style='color:#c6d24f' ></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-width-modal {
      max-width: 90%; /* Adjust the percentage as needed */
    }

    .modal-content {
    background-color: rgba(255, 255, 255, 0); /* Adjust the last value (alpha) for transparency */
    border: none; /* Optional: Remove the modal border */
  }
</style>

<script>
    function edit(taskId) {
        // Define the URL you want to open
        var linkUrl = '/dashboard/' + taskId + '/edit';

        // Open the link in the current window
        window.location.href = linkUrl;
    }

    function confirmation(ev) {
        ev.preventDefault();
        var urlToRedirect = ev.currentTarget.getAttribute('href');  
        console.log(urlToRedirect); 
        swal({
            title: "Are you sure?",
            text: "This action is irreversible.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willCancel) => {
            if (willCancel) {


                 
                window.location.href = urlToRedirect;
               
            }  


        });

        
    }
</script>