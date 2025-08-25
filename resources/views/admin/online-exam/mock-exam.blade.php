<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Online Exam</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<style>
body { background: #f9f9f9; font-family: 'Segoe UI', sans-serif; }
.card { border-radius: 16px; }
#instructions-section, #exam-section { display: none; }
.question-box { min-height: 200px; }
.timer { font-size: 1.4rem; font-weight: bold; background-color: #ffffff; padding: 8px 16px; border-radius: 8px; color: #dc3545; box-shadow: 0 0 5px rgba(0,0,0,0.1);}
.watermark { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; opacity: 0.07; z-index: 0; pointer-events: none; }
.watermark img { width: 120px; height: auto; margin: 0 auto; }
.header { padding: 20px; text-align: center; background-color: #343a40; color: white; border-radius: 0 0 10px 10px; margin-bottom: 30px; }
.btn-primary, .btn-success { border-radius: 8px; padding: 10px 24px; }
.form-check-input:checked { background-color: #198754; border-color: #198754; }
footer { margin-top: 50px; text-align: center; color: #aaa; font-size: 0.9rem; }
#backBtn, #nextBtn { min-width: 100px; }
</style>
</head>
<body>

<div class="watermark">
  <img src="https://bookmyfresh.com/b1test/public/assets/img/logo.png" alt="Watermark Logo" />
</div>

<div class="container">
  <div class="header shadow-sm">
    <h2 class="mb-0">B1-Test Exam Portal</h2>
    <small>Please follow instructions and manage your time wisely</small>
  </div>

  <!-- Login Section -->
  <div id="login-section" class="card shadow-sm p-4">
    <h4 class="mb-3 text-primary">🔐 Enter Your Unique ID</h4>
    <input type="text" id="uniqueId" class="form-control mb-3" placeholder="Unique ID" />
    <div id="loginError" class="text-danger mb-3" style="display:none;"></div>
    <button id="validateBtn" class="btn btn-primary">Validate & Proceed</button>
  </div>

  <!-- Instructions Section -->
  <div id="instructions-section" class="card shadow-sm mt-4 p-4">
    <h4 class="text-success mb-3">📋 Exam Instructions</h4>
    <div class="timer" id="instructiontimer">Time Left: 1:00 Min</div>
    <ul class="list-group list-group-flush mb-3">
      <li class="list-group-item">✅ All questions are mandatory.</li>
      <li class="list-group-item">🔄 Do not refresh the page during the exam.</li>
      <li class="list-group-item">⏳ Timer is visible and auto-submits your answers.</li>
      <li class="list-group-item">✅ Exam will be auto-submitted on exit or refresh.</li>
      <li class="list-group-item">⏳ Start your exam within one minute after reading instructions.</li>   
    </ul>
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="confirmCheckbox"/>
      <label class="form-check-label" for="confirmCheckbox">I have read and understood the instructions.</label>
    </div>
    <button id="startExamBtn" class="btn btn-success" disabled>Start Exam</button>
  </div>

  <!-- Exam Section -->
  <div id="exam-section" class="card shadow-sm mt-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0">📝 Online Exam</h5>
      <div class="timer" id="timer">Time Left: 30:00 Min</div>
    </div>
    <div class="card-body">
        <div id="question-box" class="question-box mb-4"></div>
        <div class="d-flex justify-content-between">
            <button id="backBtn" class="btn btn-outline-secondary">Back</button>
            <button id="nextBtn" class="btn btn-primary">Next</button>
        </div>
    </div>
  </div>

</div>

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script>
let uniqueId = '';
let shuffledQuestions = [];
let currentQuestionIndex = 0;
let selectedAnswers = {};
let attemptedQuestions = new Set();
let answeredQuestions = new Set();
let totalTime = 30 * 60; // seconds
let remainingTime = totalTime;
let timer = null;
let instructionSecs = 60;
let instructionTimer = null;
let buttonClicked = false;
let questions = [];
let exam_id = '{{$id}}';

// Fullscreen
function launchFullScreen() {
   const el = document.documentElement;
   if (el.requestFullscreen) el.requestFullscreen();
   else if (el.webkitRequestFullscreen) el.webkitRequestFullscreen();
   else if (el.msRequestFullscreen) el.msRequestFullscreen();
}

document.addEventListener('fullscreenchange', () => {
    if (!document.fullscreenElement) {
        alert("You exited fullscreen! You will be exited.");
        launchFullScreen(); 
        window.location.reload(); 
    }
});

// Instruction Timer
function incInstructionTimer() {
    const mins = Math.floor(instructionSecs/60);
    const secs = instructionSecs % 60;
    document.getElementById("instructiontimer").textContent = `Time Left: ${mins}:${secs<10?"0"+secs:secs} Min`;
    if(instructionSecs <= 0){
        clearInterval(instructionTimer);
        document.getElementById("startExamBtn").click();
    }
    instructionSecs--;
}

// Start Exam Timer
function startTimer() {
    if(timer) clearInterval(timer);
    timer = setInterval(() => {
        const mins = Math.floor(remainingTime/60);
        const secs = remainingTime % 60;
        document.getElementById("timer").textContent = `Time Left: ${mins}:${secs<10?"0"+secs:secs} Min`;
        if(remainingTime <=0){
            clearInterval(timer);
            submitExam();
            return;
        }
        remainingTime--;
    }, 1000);
}

// Validate Candidate
document.getElementById("validateBtn").onclick = () => {
    const inputId = document.getElementById("uniqueId").value.trim();
    fetch("{{url('mock-validate-candidate')}}",{
        method:"POST",
        headers:{"Content-Type":"application/json","X-CSRF-TOKEN":'{{ csrf_token() }}'},
        body: JSON.stringify({unique_id:inputId})
    }).then(res=>res.json()).then(data=>{
        uniqueId = inputId;
        if(data.valid){
            launchFullScreen();
            document.getElementById("login-section").style.display = "none";
            document.getElementById("instructions-section").style.display = "block";

            // Start instruction timer
            instructionSecs = 60;
            clearInterval(instructionTimer);
            instructionTimer = setInterval(incInstructionTimer,1000);

            // Auto-click start exam after 60s
            setTimeout(()=>{ if(!buttonClicked) document.getElementById("startExamBtn").click(); },60000);
        } else {
            document.getElementById("loginError").innerText = data.is_attempt?"Already Attempted.":"Invalid ID. Try again.";
            document.getElementById("loginError").style.display = "block";
        }
    });
};

// Enable Start Exam button
document.getElementById("confirmCheckbox").onchange = (e)=>{
    document.getElementById("startExamBtn").disabled = !e.target.checked;
}

// Start Exam Button
document.getElementById("startExamBtn").onclick = () => {
    buttonClicked = true;
    clearInterval(instructionTimer);
    document.getElementById("instructions-section").style.display = "none";
    document.getElementById("exam-section").style.display = "block";
    loadQuestions();
}

// Load Questions & Resume Timer
function loadQuestions() {
    fetch("{{ url('fetch-mock-questions') }}",{
        method:"POST",
        headers:{"Content-Type":"application/json","X-CSRF-TOKEN":'{{ csrf_token() }}'},
        body: JSON.stringify({unique_id:uniqueId})
    }).then(res=>res.json()).then(data=>{
        questions = data.questions;
        selectedAnswers = data.selected_answers || {};
        remainingTime = data.time_remaining || totalTime;

        questions.forEach(q=>{
            if(selectedAnswers[q.id]){
                attemptedQuestions.add(q.id);
                answeredQuestions.add(q.id);
            }
        });

        shuffledQuestions = [...questions];
        currentQuestionIndex = questions.findIndex(q=>!attemptedQuestions.has(q.id));
        if(currentQuestionIndex===-1) currentQuestionIndex=0;

        showQuestion();
        startTimer();
    });
}

// Show Question
function showQuestion(){
    document.getElementById("backBtn").style.display = currentQuestionIndex===0?"none":"inline-block";
    document.getElementById("nextBtn").textContent = currentQuestionIndex===shuffledQuestions.length-1?"Submit":"Next";
    const q = shuffledQuestions[currentQuestionIndex];
    let html = `<h5>Q${currentQuestionIndex+1} of ${shuffledQuestions.length}: ${q.question}</h5>`;
    for(const[key,val] of Object.entries(q.options)){
        const isChecked = selectedAnswers[q.id]===key?"checked":"";
        html+=`<div class="form-check">
        <input class="form-check-input" type="radio" name="option" value="${key}" id="opt${key}" ${isChecked}>
        <label class="form-check-label" for="opt${key}">${key}. ${val}</label>
        </div>`;
    }
    document.getElementById("question-box").innerHTML = html;
}

// Save Attempt
function saveAttempt(qid,selectedOption){
    fetch("{{url('save-each-attempt-mock')}}",{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
        body:JSON.stringify({exam_id:exam_id, unique_id:uniqueId, question_id:qid, selected_option:selectedOption, time_remaining:remainingTime})
    });
}

// Next Button
document.getElementById("nextBtn").onclick = () => {
    const q = shuffledQuestions[currentQuestionIndex];
    const selected = document.querySelector('input[name="option"]:checked');
    const selectedOption = selected ? selected.value : null;

    attemptedQuestions.add(q.id);
    if(selectedOption) answeredQuestions.add(q.id);
    selectedAnswers[q.id] = selectedOption;

    saveAttempt(q.id, selectedOption);

    currentQuestionIndex++;
    if(currentQuestionIndex<shuffledQuestions.length){
        showQuestion();
    } else {
        submitExam();
    }
}

// Back Button
document.getElementById("backBtn").onclick = () => {
    if(currentQuestionIndex>0){
        const q = shuffledQuestions[currentQuestionIndex];
        const selected = document.querySelector('input[name="option"]:checked');
        selectedAnswers[q.id] = selected ? selected.value : null;
        currentQuestionIndex--;
        showQuestion();
    }
}

// Submit Exam
function submitExam(){
    clearInterval(timer);
    document.getElementById("nextBtn").style.display = "none";
    document.getElementById("backBtn").style.display = "none";

    const total = shuffledQuestions.length;
    const attempted = attemptedQuestions.size;
    const answered = answeredQuestions.size;
    const unanswered = total - answered;
    let timeTaken = totalTime - remainingTime;
    let mins = Math.floor(timeTaken/60);
    let secs = timeTaken % 60;
    let score = 0;
    shuffledQuestions.forEach(q=>{
        if(selectedAnswers[q.id]===q.correct_option) score++;
    });

    fetch("{{url('submit-mock-exam')}}",{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
        body:JSON.stringify({
            exam_id:exam_id,
            unique_id:uniqueId,
            answers:selectedAnswers,
            time_remaining:remainingTime,
            time_taken:timeTaken,
            stats:{total_questions:total, attempted, answered, unanswered, score}
        })
    }).then(res=>res.json()).then(data=>{
        document.getElementById("question-box").innerHTML = `
        <h5>Exam Submitted!</h5>
        <p>Total Questions: ${total}</p>
        <p>Attempted: ${attempted}</p>
        <p>Answered: ${answered}</p>
        <p>Unanswered: ${unanswered}</p>
        <p><strong>Time Taken: ${mins} minutes ${secs} seconds</strong></p>
        <p>${data.message}</p>`;
    });
}
</script>
</body>
</html>
