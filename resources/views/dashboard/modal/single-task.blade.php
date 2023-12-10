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
                            @php
                                $totalSubtasksCount = $task->subtasks->count();
                                $progressEndValue = ($totalSubtasksCount > 0 ? ($task->completed_subtasks_count / $totalSubtasksCount) : 0) * 100;
                            @endphp
                            <div class="percentage">
                                <div class="circle-percentage" data-progress-end-value="{{$progressEndValue}}">
                                    <span class="progress-value">20%</span>
                                </div>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="description">
                                <p>{{ $task['description']}}</p>
                            </div>
                            <form class="subtask-form" id="subtask-form" method="POST" action="/dashboard/tasks/{{$task['id']}}/subtasks/change">
                            <div class="list-of-task">
                                    @csrf
                                    @foreach ($task->subtasks as $index => $subtask)
                                    <div class="subtask">
                                        <h3 class="font-weight-bold">{{$subtask->name}}</h3>
                                        <input type="checkbox" name="subtask_statuses[{{$subtask->id}}]" {{ $subtask->status ? 'checked' : '' }}>
                                    </div>
                                    @endforeach
                                    @for ($i = count($task->subtasks) + 1; $i <= 5; $i++)
                                        <div class="subtask">
                                            <h3 class="text-muted">...</h3>
                                        </div>
                                    @endfor
                            </div>
                        </form>
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
                            <button class ="check" onclick="saveConfirmation(event)"><i class='bx bx-check-double' style='color:#c6d24f' ></i></button>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Select all modal elements with the specified ID
        const modals = document.querySelectorAll('[id^="ModalTaskView"]');

        modals.forEach(modal => {
            let circularProgress = modal.querySelector(".circle-percentage"),
                progressValue = modal.querySelector(".progress-value");

            let progressStartValue = 0,
                progressEndValue = parseFloat(circularProgress.dataset.progressEndValue) || 0,
                speed = 10;
            let progressInterval;

            // Function to start the circular progress animation
            function startProgress() {
                progressInterval = setInterval(() => {
                    progressStartValue = progressStartValue + 1;

                    progressValue.textContent = `${progressStartValue}%`;
                    circularProgress.style.background = `conic-gradient(#5194ad ${progressStartValue * 3.6}deg, #ededed 0deg)`

                    if (progressStartValue >= progressEndValue) {
                        clearInterval(progressInterval);
                        progressValue.textContent = `${progressEndValue}%`;
                        circularProgress.style.background = `conic-gradient(#5194ad ${progressEndValue * 3.6}deg, #ededed 0deg)`
                    }
                }, speed);
            }

            // Attach event listener to shown.bs.modal event
            $(modal).on('shown.bs.modal', startProgress);

            // Function to stop the circular progress animation and reset values
            function stopProgress() {
                clearInterval(progressInterval);

                // Reset progress values
                progressStartValue = 0;
                progressValue.textContent = `${progressStartValue}%`;
                circularProgress.style.background = `conic-gradient(#5194ad ${progressStartValue * 3.6}deg, #ededed 0deg)`
            }

            // Attach event listener to hidden.bs.modal event
            $(modal).on('hidden.bs.modal', stopProgress);
        });
    });

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

    function saveConfirmation(ev) {
    ev.preventDefault();
    swal({
        title: "Save changes?",
        text: "Your subtasks will be updated.",
        icon: "info",
        buttons: true,
        dangerMode: true,
    })
    .then((willCancel) => {
        if (willCancel) {
            // Use the event to get the form dynamically
            const form = ev.target.closest('.modal-taskview').querySelector('form');
            console.log(ev.target); 
            // Check if the form is found
            if (form) {
                form.submit();
            } else {
                console.error("Form not found");
            }
        }
    });
}   
</script>