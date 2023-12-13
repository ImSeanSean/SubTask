@props(['tasks'])

<div class="task-card-group">
    @unless(count($tasks) == 0)
        @foreach($tasks as $task)
            {{-- <a href="/dashboard/tasks/{{$task['id']}}" class="task-card" id="taskButton"> --}}
                <a href="#" data-toggle="modal" data-target="#ModalTaskView{{$task['id']}}" class="task-card" id="{{$task->id}}">
                <div class="task-card-div">
                    <div class="bar">
                        <div class="side-bar"></div>
                        <div class="percentage" style="height: {{ $task->subtasks->count() > 0 ? $task->completed_subtasks_count / $task->subtasks->count() * 100 : 0 }}%; 
                            @if($task->subtasks->count() > 0 && $task->completed_subtasks_count === $task->subtasks->count()) border-top-left-radius: 30px; @endif"></div>
                    </div>
                    <div class="text-part">
                        <h1 class="font-weight-bold">{{ $task['name'] }}</h1>
                        <ul>
                            @foreach ($task->subtasks as $subtask)
                                <li>{{ $subtask->name }}</li>
                            @endforeach
                            @for ($i = 0; $i < max(0, 5 - count($task->subtasks)); $i++)
                                <li class="text-muted">...</li>
                            @endfor
                        </ul>
                    </div>
                </div>
            </a>
            @include('dashboard.modal.single-task')
        @endforeach

    @else
        <h2 class="col-12 text-center">No tasks found :(</h2>
    @endunless
</div>

<div class="mt-6 p-4">
    {{$tasks->links()}}
</div>
