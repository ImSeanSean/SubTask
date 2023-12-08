document.addEventListener('DOMContentLoaded', function() {
    let circularProgress = document.querySelector(".circle-percentage"),
        progressValue = document.querySelector(".progress-value");

    let progressStartValue = 0,
        progressEndValue = 88,
        speed = 1;

    let progress = setInterval(() => {
        progressStartValue = progressStartValue+5;
        
        progressValue.textContent = `${progressStartValue}%`;
        circularProgress.style.background = `conic-gradient(#5194ad ${progressStartValue * 3.6}deg, #ededed 0deg)`

        if(progressStartValue >= progressEndValue){
            clearInterval(progress);
            progressValue.textContent = `${progressEndValue}%`;
            circularProgress.style.background = `conic-gradient(#5194ad ${progressEndValue * 3.6}deg, #ededed 0deg)`
        }

    }, speed);
});
