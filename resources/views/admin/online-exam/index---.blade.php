<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Online Exam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
   body {
      background: #f9f9f9;
      font-family: 'Segoe UI', sans-serif;
    }

    .card {
      border-radius: 16px;
    }

    #instructions-section, #exam-section {
      display: none;
    }

    .question-box {
      min-height: 200px;
    }

    .timer {
      font-size: 1.4rem;
      font-weight: bold;
      background-color: #ffffff;
      padding: 8px 16px;
      border-radius: 8px;
      color: #dc3545;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .watermark {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      opacity: 0.07;
      z-index: 0;
      pointer-events: none;
    }

    .watermark img {
      width: 120px;
      height: auto;
      margin: 0 auto;
    }

    .watermark-text {
      font-size: 24px;
      font-weight: bold;
      margin-top: 6px;
      color: #000;
    }

    .header {
      padding: 20px;
      text-align: center;
      background-color: #343a40;
      color: white;
      border-radius: 0 0 10px 10px;
      margin-bottom: 30px;
    }

    .btn-primary, .btn-success {
      border-radius: 8px;
      padding: 10px 24px;
    }

    .form-check-input:checked {
      background-color: #198754;
      border-color: #198754;
    }

    .form-check-label {
      font-size: 1rem;
    }

    footer {
      margin-top: 50px;
      text-align: center;
      color: #aaa;
      font-size: 0.9rem;
    }


    #backBtn {
    min-width: 100px;
    }

    #nextBtn {
    min-width: 100px;
    }

  </style>
</head>
<body class="">

<div class="watermark">
  <img src="https://bookmyfresh.com/b1test/public/assets/img/logo.png" alt="Watermark Logo" />
  <!-- <div class="watermark-text">B1 Test</div> -->
</div>

<div class="container">
  <div class="header shadow-sm">
    <h2 class="mb-0"> B1-Test Exam Portal</h2>
    <small class="">Please follow instructions and manage your time wisely</small>
  </div>

  <!-- Login Section -->
   <h4 class="mb-3 text-primary">🔐 Center Id</h4>
    <input type="text" id="examid" class="form-control mb-3" value="9"  placeholder="Unique center ID"readonly />
  <div id="login-section" class="card shadow-sm p-4">
    <h4 class="mb-3 text-primary">🔐 Enter Your Exam ID</h4>
    <input type="text" id="uniqueId" class="form-control mb-3" value="810303274"  placeholder="Unique Exam ID" />
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
      <li class="list-group-item">✅  Your exam will be submitted automatically if you exit the screen or press any other key.</li>
	   <li class="list-group-item">⏳ Start your Exam within one minute, after reading the instructions carefully</li>   
    </ul>
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="confirmCheckbox"/>
      <label class="form-check-label" for="confirmCheckbox">
        I have read and understood the instructions.
      </label>
    </div>
    <button id="startExamBtn" class="btn btn-success" onclick="handleClick()" >Start Exam</button>
  </div>

  <!-- Exam Section -->
  <div id="exam-section" class="card shadow-sm mt-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0">📝 Online Exam</h5>
      <div class="timer" id="timer">Time Left: 180:00 Min</div>
    </div>
    <!-- <div class="card-body">
      <div id="question-box" class="question-box mb-4"></div>
      <button id="nextBtn" class="btn btn-primary">Next</button>
    </div> -->

    <div class="card-body">
        <div id="question-box" class="question-box mb-4"></div>
        <div class="d-flex justify-content-between">
            <button id="backBtn" class="btn btn-outline-secondary">Back</button>
            <button id="nextBtn" class="btn btn-primary">Next</button>
        </div>
    </div>
  </div>
 <script>
        let buttonClicked = false;

        function handleClick() {
            buttonClicked = true;
            alert("Button clicked!");
            // You can trigger a form submission or any other action here
        }

        window.onload = function () {
            // Set timer to auto-click after 60 seconds
            setTimeout(function () {
                if (!buttonClicked) {
                    document.getElementById("startExamBtn").click();   
                }
            }, 60000); // 60,000 ms = 60 seconds
        };   
    </script>
	
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script>
    function incTimer() {
        var currentMinutes = Math.floor(totalSecs / 60);
        var currentSeconds = totalSecs % 60;
        if(currentSeconds <= 9) currentSeconds = "0" + currentSeconds;
        if(currentMinutes <= 9) currentMinutes = "0" + currentMinutes;
        totalSecs++;
        $("#instructiontimer").text(currentMinutes + ":" + currentSeconds);
        console.log("beforeincTimer");
        setTimeout('incTimer()', 1000);
        console.log("afterincTimer");
    }

    totalSecs = 0;

    $(document).ready(function() {
        $("#validateBtn").click(function() {  
          console.log("validateBtnvalidateBtn");
          
            incTimer();
        });
    });  
	
function clickButton() {
 document.getElementById('startExamBtn').click();      
}
  
</script>       
  <script>

  var exam_id = '{{$id}}';
  console.log("exam_id",exam_id);
  
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
</script>


  <script>
    
document.addEventListener('keydown', function(e) {
    const activeElement = document.activeElement;

    if (activeElement && activeElement.id === "uniqueId") {
        const allowedKeys = ["Backspace", "ArrowLeft", "ArrowRight", "Delete", "Tab"];

        if (
            (e.key >= "0" && e.key <= "9") || 
            allowedKeys.includes(e.key)
        ) {
            return; 
        }

        e.preventDefault();
        return;
    }

    e.preventDefault();
});

</script>

<script>
    document.addEventListener("visibilitychange", function () {
        if (document.hidden) {
            alert("Tab switch detected! You will be exited.");
            window.location.reload(); 
        }
    });
</script>
<script>
    document.addEventListener('contextmenu', event => event.preventDefault());

    ['copy', 'cut', 'paste'].forEach(evt =>
        document.addEventListener(evt, event => event.preventDefault())
    );

    document.onkeydown = function(e) {
        if (
            e.key === "F12" ||
            (e.ctrlKey && e.shiftKey && (e.key === "I" || e.key === "J" || e.key === "C")) ||
            (e.ctrlKey && e.key === "U")
        ) {
            return false;
        }
    };
</script>



<script>
  let uniqueId = '';
  let shuffledQuestions = [];
  let currentQuestionIndex = 0;
  let selectedAnswers = {};
  let attemptedQuestions = new Set();
  let answeredQuestions = new Set();
  let totalTime = 180 * 60;
  let remainingTime = totalTime;
  let timer; 

  let questions = [];



  document.getElementById("validateBtn").onclick = () => {
    
    const inputId = document.getElementById("uniqueId").value.trim();
    fetch("{{url('validate-candidate')}}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": '{{ csrf_token() }}'
      },
      body: JSON.stringify({ unique_id: inputId })
    })
    .then(res => res.json())
    .then(data => {
        console.log("data----",data);
        
      uniqueId = inputId;
      if(data.valid === true ){
          launchFullScreen();
          document.getElementById("login-section").style.display = "none";
          document.getElementById("instructions-section").style.display = "block";

      }else{
          if(data.is_attempt == 1){
            document.getElementById("loginError").innerText = "Already Attempted.";
          }else{
            document.getElementById("loginError").innerText = "Invalid ID. Try again.";
          }
          document.getElementById("loginError").style.display = "block";

      }
    })
    .catch(() => {
    });
  };

  
  document.getElementById("confirmCheckbox").onchange = (e) => {
    document.getElementById("startExamBtn").disabled = !e.target.checked;
  };

  document.getElementById("startExamBtn").onclick = () => {
    document.getElementById("instructions-section").style.display = "none";
    document.getElementById("exam-section").style.display = "block";
    shuffledQuestions = [...questions].sort(() => Math.random() - 0.5);
    loadQuestions();
    showQuestion();
    startTimer();
  };

  function loadQuestions() {
    fetch("{{ url('fetch-questions') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": '{{ csrf_token() }}'
      },
      body: JSON.stringify({ unique_id: uniqueId })
    })
    .then(res => res.json())
    .then(data => {
      questions = data.questions;
      selectedAnswers = data.selected_answers || {};
      remainingTime = data.time_remaining || totalTime;

      questions.forEach(q => {
        if(selectedAnswers[q.id]) {
          attemptedQuestions.add(q.id);
          answeredQuestions.add(q.id);
        }
      });

      shuffledQuestions = [...questions];  

      currentQuestionIndex = questions.findIndex(q => !attemptedQuestions.has(q.id));
      if(currentQuestionIndex === -1) currentQuestionIndex = 0; 

      showQuestion();
      startTimer();
    });
  }


  function loadQuestionsWithAttempts() {
    fetch("{{ url('fetch-questions') }}")
      .then(res => res.json())
      .then(questionsData => {
        questions = questionsData;
        shuffledQuestions = [...questions];
        return fetch("{{ url('fetch-previous-attempts') }}?unique_id=" + uniqueId);
      })
      .then(res => res.json())
      .then(attemptsData => {
        selectedAnswers = {};
        attemptsData.forEach(a => {
          selectedAnswers[a.question_id] = a.selected_option;
          attemptedQuestions.add(a.question_id);
          if (a.selected_option) answeredQuestions.add(a.question_id);
          if (a.time_remaining) remainingTime = a.time_remaining; 
        });

        const lastQuestionId = attemptsData.length > 0 ? attemptsData[attemptsData.length - 1].question_id : null;
        const index = shuffledQuestions.findIndex(q => q.id === lastQuestionId);
        currentQuestionIndex = index !== -1 ? index : 0;

        showQuestion();
        startTimer();
      });
  }


  


  

  function startTimer() {
     timer  = setInterval(() => {
       
         const minutes = Math.floor(remainingTime / 60);
         const seconds = remainingTime % 60;
         document.getElementById("timer").textContent = `Time Left: ${minutes}:${seconds < 10 ? "0" + seconds : seconds} Min`;
         if (remainingTime <= 0) {
           clearInterval(timer);
           submitExam();
           return;       
         }
      remainingTime--;
      
    }, 1000);
  }

  function showQuestion() {

    document.getElementById("backBtn").style.display = currentQuestionIndex === 0 ? "none" : "inline-block";
    document.getElementById("nextBtn").textContent =
    currentQuestionIndex === shuffledQuestions.length - 1 ? "Submit" : "Next";
    const q = shuffledQuestions[currentQuestionIndex];
    let html = `<h5>Q${currentQuestionIndex + 1} of ${shuffledQuestions.length} : ${q.question}</h5>`;
    for (const [key, val] of Object.entries(q.options)) {
        const isChecked = selectedAnswers[q.id] === key ? "checked" : "";
      html += `
        <div class="form-check">
          <input class="form-check-input" type="radio" name="option" value="${key}" id="opt${key}" ${isChecked}>
          <label class="form-check-label" for="opt${key}">${key}. ${val}</label>
        </div>`;
    }
    document.getElementById("question-box").innerHTML = html;
   
  }



  document.getElementById("nextBtn").onclick = () => {
    const q = shuffledQuestions[currentQuestionIndex];
    const selected = document.querySelector('input[name="option"]:checked');
    const selectedOption = selected ? selected.value : null;

    attemptedQuestions.add(q.id);
    if (selectedOption) answeredQuestions.add(q.id);
    selectedAnswers[q.id] = selectedOption;

    
    let gettimeTaken = totalTime - remainingTime;
    let timeTaken = gettimeTaken % 60;

    saveAttempt(q.id, selectedOption, remainingTime,timeTaken);

    currentQuestionIndex++;
    if (currentQuestionIndex < shuffledQuestions.length) {
      showQuestion();
    } else {
      submitExam();
    }
  };

  document.getElementById("backBtn").onclick = () => {
    if (currentQuestionIndex > 0) {
        const q = shuffledQuestions[currentQuestionIndex];
        const selected = document.querySelector('input[name="option"]:checked');
        const selectedOption = selected ? selected.value : null;
        selectedAnswers[q.id] = selectedOption;

        currentQuestionIndex--;
        showQuestion();
    }
  };

  function saveAttempt(qid, selectedOption, timeLeft,timeTaken) {
    fetch("{{url('save-each-attempt')}}", {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: JSON.stringify({ exam_id: exam_id,unique_id: uniqueId, question_id: qid, selected_option: selectedOption, time_remaining: timeLeft,time_taken: timeTaken, })
    });
  }

  function submitExam() {
    clearInterval(timer); 
    document.getElementById("nextBtn").style.display = "none";
    document.getElementById("backBtn").style.display = "none"; 
    const total = shuffledQuestions.length;
    const attempted = attemptedQuestions.size;
    const answered = answeredQuestions.size;
    const unanswered = total - answered;


    
    let timeTaken = totalTime - remainingTime;
    let minutes = Math.floor(timeTaken / 60);
    let seconds = timeTaken % 60;
    

    let score = 0;
    shuffledQuestions.forEach(q => {
      if (selectedAnswers[q.id] === q.correct_option) score++;
    });

    fetch("{{url('submit-exam')}}", {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: JSON.stringify({
        exam_id: exam_id,
        unique_id: uniqueId,
        answers: selectedAnswers,
        time_remaining: remainingTime,
        time_taken: timeTaken,
        stats: { total_questions: total, attempted, answered, unanswered, score }
      })
    })
    .then(res => res.json())
    .then(data => {

        
      document.getElementById("question-box").innerHTML = `
        <h5>Exam Submitted!</h5>
        <p>Total Questions: ${total}</p>
        <p>Attempted: ${attempted}</p>
        <p>Answered: ${answered}</p>
        <p>Unanswered: ${unanswered}</p>
        <p><strong>Your Score: ${data.score} / ${total}</strong></p>
        <p><strong>Time Taken: ${minutes} minutes ${seconds} seconds</strong></p>
        <p>${data.message}</p>`;
    });
  }
</script>

</body>
</html>
