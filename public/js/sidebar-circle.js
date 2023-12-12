let circularProgress = document.querySelector(".secondary-area .circular-progress"),
    progressValue = document.querySelector(".secondary-area .progress-value"),
    progressBar = document.querySelector(".secondary-area .progress-bar");

// Big Circle
let progressStartValueBig = 0,
    speedBig = 20;

    fetch('/api/taskPercentage')
    .then(response => response.json())
    .then(data => {
        progressEndValueBig = data.taskPercentage;

        if (progressEndValueBig < 5) {
            progressValue.textContent = `${progressEndValueBig}%`;
            progressBar.style.background = `conic-gradient(#5194AD ${progressEndValueBig * 3.6}deg, #cacaca 0deg)`;
        } else {
            let progressBig = setInterval(() => {
                progressStartValueBig = progressStartValueBig + 5;

                progressValue.textContent = `${progressStartValueBig}%`;
                progressBar.style.background = `conic-gradient(#5194AD ${progressStartValueBig * 3.6}deg, #cacaca 0deg)`;

                if (progressStartValueBig >= progressEndValueBig) {
                    clearInterval(progressBig);
                }
            }, speedBig);
        }
    })
    .catch(error => console.error('Error fetching task percentage:', error));
    
// Function to update the progress value
let lastHoveredTaskId = null;
let isProgressBigRunning = false;
let isProgressSmallRunning = false;
let speed = 20;

function updateProgressValue(taskId) {
    // Check if the current task is the same as the last hovered task
    if (taskId === lastHoveredTaskId) {
        return;
    }

    // Update the last hovered task ID
    lastHoveredTaskId = taskId;
    //Update Secondary Area
    updateSecondaryArea(taskId);

    fetch('/api/taskPercentage/')
        .then(response => response.json())
        .then(data => {
            // Assuming data.subtaskPercentage is an array with taskid as index
            const subtaskPercentage = data.subtaskPercentage[taskId];
            let progressStartValue = 0;
            progressEndValue = subtaskPercentage;
            

            // Update the small circle progress
            let progress = setInterval(() => {
                if (progressEndValue < 5){
                    circularProgress.style.background = `conic-gradient(#5194AD ${progressEndValue * 3.6}deg, #cacaca 0deg)`;
                    return;
                }
                progressStartValue = progressStartValue + 1;
                circularProgress.style.background = `conic-gradient(#5194AD ${progressStartValue * 3.6}deg, #cacaca 0deg)`;

                if (progressStartValue >= progressEndValue) {
                    clearInterval(progress);
                }
            }, speed);
        })
        .catch(error => {
            console.error('Error fetching subtask percentage:', error);
            isProgressSmallRunning = false; // Reset the flag in case of an error
        });
}
//Update Secondary Area
function updateSecondaryArea(taskId) {
    fetch('/api/task/' + taskId)
        .then(response => response.json())
        .then(data => {
            const taskTitle = document.querySelector('.recent_project .listing .title h2');
            const dueDate = document.querySelector('.recent_project .listing .title h4');
            const description = document.querySelector('.recent_project .listing .title p');
            const mainSubtasks = document.querySelector('.recent_project .listing .main-subtask');
            const completionInfo = document.createElement('div');
            completionInfo.classList.add('subs-completed');

            taskTitle.textContent = data.name;

            // Format the due date to "y/m/d" or display "No Due-Date" if it's null
            dueDate.textContent = data['due-date'] ? formatDateString(data['due-date']) : 'No Due-Date';

            description.textContent = data.description;

            mainSubtasks.innerHTML = '';

            // Count the completed subtasks
            const completedSubtasks = data.subtask.filter(subtask => subtask.status === 1).length;
            const totalSubtasks = data.subtask.length;

            // Append new subtasks
            data.subtask.forEach(subtask => {
                const subtaskElement = document.createElement('div');
                subtaskElement.classList.add('subtasks');

                // Check if the status is 1, and set the checkbox accordingly
                const isChecked = subtask.status === 1;
                const disabledAttribute = 'disabled';

                subtaskElement.innerHTML = `
                    <h4>${subtask['name']}</h4>
                    <input type="checkbox" ${isChecked ? 'checked' : ''} ${disabledAttribute}>
                `;
                mainSubtasks.appendChild(subtaskElement);
            });

            // Set the completion info text
            completionInfo.innerHTML = `
                <h3>${completedSubtasks} out of ${totalSubtasks}</h3>
                <p>Completed</p>
            `;
            mainSubtasks.appendChild(completionInfo);
        })
        .catch(error => console.error('Error fetching task percentage:', error));
}


// Function to format date string to "y/m/d"
function formatDateString(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Adding 1 because months are zero-based
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}/${month}/${day}`;
}

// Add event listeners to task cards
document.querySelectorAll('.task-card').forEach(taskCard => {
    taskCard.addEventListener('mouseover', () => {
        // Get the task ID from the task card's ID or other attribute
        const taskId = taskCard.id;

        // Update the progress value when a different task card is hovered
        updateProgressValue(taskId);
    });
});