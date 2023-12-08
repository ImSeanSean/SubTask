@props(['tasks'])

<div class="task-card-group">
    @unless(count($tasks) == 0)
        @foreach($tasks as $task)
            {{-- <a href="/dashboard/tasks/{{$task['id']}}" class="task-card" id="taskButton"> --}}
                <a href="#" data-toggle="modal" data-target="#ModalTaskView{{$task['id']}}" class="task-card" id="taskButton">
                <div class="task-card-div">
                    <div class="bar">
                        <div class="side-bar"></div>
                        <div class="percentage"></div>
                    </div>
                    <div class="text-part">
                        <h1 class="font-weight-bold">{{ $task['name'] }}</h1>
                        <ul>
                            {{-- @foreach($task->items as $item)
                                <li>{{ $item }}</li>
                            @endforeach --}}
                            <li>Layout</li>
                            <li>Layout</li>
                            <li>Layout</li>
                            <li>Layout</li>
                            <li>Layout</li>
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
