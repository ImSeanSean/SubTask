@props(['tasks'])

<div class="task-card-group">
    @unless(count($tasks) == 0)
        @foreach($tasks->take(6) as $task)
            <a href="/dashboard/tasks/{{$task['id']}}" class="task-card" id="taskButton">
                <div class="task-card-div">
                    <div class="bar">
                        <div class="side-bar"></div>
                        <div class="percentage"></div>
                    </div>
                    <div class="text-part">
                        <h1>{{ $task['name'] }}</h1>
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
        @endforeach

    @else
        <p>No tasks found</p>
    @endunless
</div>
