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

    .card { border-radius: 16px; }

    #instructions-section, #exam-section { display: none; }

    .question-box { min-height: 200px; }

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
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      opacity: 0.07; z-index: 0; pointer-events: none;
    }

    .watermark img { width: 120px; height: auto; margin: 0 auto; }

    .header {
      padding: 20px; text-align: center;
      background-color: #343a40; color: white;
      border-radius: 0 0 10px 10px; margin-bottom: 30px;
    }

    .btn-primary, .btn-success { border-radius: 8px; padding: 10px 24px; }

    .form-check-input:checked { background-color: #198754; border-color: #198754; }
    .form-check-label { font-size: 1rem; }

    footer { margin-top: 50px; text-align: center; color: #aaa; font-size: 0.9rem; }

    #backBtn, #nextBtn { min-width: 100px; }

    .grid-box {
      width: 40px; height: 40px; text-align: center; line-height: 40px;
      border-radius: 6px; cursor: pointer; border: 1px solid #ccc; font-weight: bold;
    }
    .grid-answered { background-color: #198754; color: white; }
    .grid-unanswered { background-color: #ffc107; }
    .grid-skipped { background-color: #dc3545; color: white; }
    .grid-current { border: 2px solid #000; }
  </style>
</head>
<body>

<div class="watermark">
  <img src="https://bookmyfresh.com/b1test/public/assets/img/logo.png" alt="Watermark Logo" />
</div>

<div class="container">
  <div class="header shadow-sm">
    <h2 class="mb-0"> B1-Test Exam Portal</h2>
    <small class="">Please follow instructions and manage your time wisely</small>
  </div>

  <!-- Center/Exam ID -->
  <h4 class="mb-3 text-primary">🔐 Center Id</h4>
  <input type="text" id="examid" class="form-control mb-3" value="" placeholder="Enter Center ID" />

  <!-- Login Section -->
  <div id="login-section" class="card shadow-sm p-4">
    <h4 class="mb-3 text-primary">🔐 Enter Your Exam ID</h4>
   <input type="text" id="uniqueId" class="form-control mb-1" value="" placeholder="Unique Exam ID" />
<div id="windowNote" class="text-danger small mb-2" style="display:none;"></div>
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
      <li class="list-group-item">✅ Your exam will be submitted automatically if you exit the screen or press any other key.</li>
      <li class="list-group-item">⏳ Start your Exam within one minute, after reading the instructions carefully</li>
    </ul>
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="confirmCheckbox"/>
      <label class="form-check-label" for="confirmCheckbox">
        I have read and understood the instructions.
      </label>
    </div>
    <button id="startExamBtn" class="btn btn-success" onclick="handleClick()">Start Exam</button>
  </div>

  <!-- Exam Section -->
  <div id="exam-section" class="card shadow-sm mt-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0">📝 Online Exam</h5>
      <div class="timer" id="timer">Time Left: 180:00 Min</div>
    </div>

    <div class="card-body">
      <div id="question-grid" class="mb-4 d-flex flex-wrap gap-2"></div>
      <div id="question-box" class="question-box mb-4"></div>
      <div class="d-flex justify-content-between">
        <button id="backBtn" class="btn btn-outline-secondary">Back</button>
        <button id="skipBtn" class="btn btn-outline-warning">Skip</button>
        <button id="nextBtn" class="btn btn-primary">Next</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

<!-- Fullscreen guard -->
<script>
  var exam_id = '{{$id}}';
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

<!-- Input & visibility protections -->
<script>
  document.addEventListener('keydown', function(e) {
    const activeElement = document.activeElement;

    if (activeElement && (activeElement.id === "uniqueId" || activeElement.id === "examid")) {
      const allowedKeys = ["Backspace", "ArrowLeft", "ArrowRight", "Delete", "Tab"];
      if ((e.key >= "0" && e.key <= "9") || allowedKeys.includes(e.key)) { return; }
      e.preventDefault(); return;
    }
    e.preventDefault();
  });

  document.addEventListener("visibilitychange", function () {
    if (document.hidden) {
      window.location.reload();
    }
  });

  document.addEventListener('contextmenu', event => event.preventDefault());
  ['copy', 'cut', 'paste'].forEach(evt =>
    document.addEventListener(evt, event => event.preventDefault())
  );
  document.onkeydown = function(e) {
    if (e.key === "F12" ||
        (e.ctrlKey && e.shiftKey && (e.key === "I" || e.key === "J" || e.key === "C")) ||
        (e.ctrlKey && e.key === "U")) {
      return false;
    }
  };
</script>

<!-- Timers + Exam Logic -->
<script>
  // ===== Instruction timer state =====
  let instructionSecs = 60;                 // 1 minute instruction time
  let instructionTimerInterval = null;
  let buttonClicked = false;

  // ===== Exam timer state =====
  let totalTime = 180 * 60;                 // 180 minutes in seconds
  let remainingTime = totalTime;
  let timer = null;                         // exam timer interval

  // ===== Exam/session state (kept same names) =====
  let uniqueId = '';
  let shuffledQuestions = [];
  let currentQuestionIndex = 0;
  let selectedAnswers = {};
  let attemptedQuestions = new Set();
  let answeredQuestions = new Set();
  let questions = [];

  // Start instruction countdown (single source of truth)
  function incTimer() {
    clearInterval(instructionTimerInterval); // avoid duplicates
    updateInstructionTimerText(instructionSecs);
    instructionTimerInterval = setInterval(() => {
      instructionSecs--;
      updateInstructionTimerText(instructionSecs);

      if (instructionSecs <= 0) {
        clearInterval(instructionTimerInterval);
        // Ensure the Start button isn't disabled before programmatic click
        const btn = document.getElementById("startExamBtn");
        btn.disabled = false;
        if (!buttonClicked) {
          btn.click();  // auto-start exam
        }
      }
    }, 1000);
  }

  function updateInstructionTimerText(sec) {
    const m = Math.floor(sec / 60);
    const s = sec % 60;
    const mm = m <= 9 ? "0" + m : m;
    const ss = s <= 9 ? "0" + s : s;
    $("#instructiontimer").text(`Time Left: ${mm}:${ss} Min`);
  }

  // Exam timer (single interval, no duplicates)
  function startTimer() {
    clearInterval(timer);
    timer = setInterval(() => {
      const minutes = Math.floor(remainingTime / 60);
      const seconds = remainingTime % 60;
      document.getElementById("timer").textContent =
        `Time Left: ${minutes}:${seconds < 10 ? "0" + seconds : seconds} Min`;

      if (remainingTime <= 0) {
        clearInterval(timer);
        submitExam();
        return;
      }
      remainingTime--;
    }, 1000);
  }

  // Manual start clicked
  function handleClick() {
    buttonClicked = true;
  }

  // Validate -> show instructions + start instruction timer
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
      uniqueId = inputId;
      if (data.valid === true) {
        launchFullScreen();
        document.getElementById("login-section").style.display = "none";
        document.getElementById("instructions-section").style.display = "block";
        instructionSecs = 60;            // reset if user re-validated
        incTimer();                      // start instruction countdown
      } else {
        if (data.is_attempt == 1) {
          document.getElementById("loginError").innerText = "Already Attempted.";
        }else if (data.is_accessible == 0) {
          document.getElementById("loginError").innerText = "Exam will be accessible only between 10:00 AM and 1:00 PM.";
        } else {
          document.getElementById("loginError").innerText = "Invalid ID. Try again.";
        }
        document.getElementById("loginError").style.display = "block";
      }
    })
    .catch(() => {});
  };

  // Instruction checkbox (optional: disable/enable Start btn for manual start)
  document.getElementById("confirmCheckbox").onchange = (e) => {
    document.getElementById("startExamBtn").disabled = !e.target.checked;
  };

  // Start Exam (manual OR auto)
  document.getElementById("startExamBtn").onclick = () => {
    // Stop instruction timer (if still running)
    clearInterval(instructionTimerInterval);

    // Move to exam UI
    document.getElementById("instructions-section").style.display = "none";
    document.getElementById("exam-section").style.display = "block";

    // Load questions from backend and THEN start exam timer (avoid double start)
    shuffledQuestions = [];  // reset
    loadQuestions();         // startTimer() is called inside loadQuestions() AFTER data arrives
  };

  // Fetch questions + prior attempts
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
      questions = data.questions || [];
      selectedAnswers = data.selected_answers || {};
      remainingTime = (typeof data.time_remaining === 'number' && data.time_remaining >= 0)
        ? data.time_remaining : totalTime;

      attemptedQuestions = new Set();
      answeredQuestions = new Set();

      questions.forEach(q => {
        if (selectedAnswers[q.id] !== undefined) {
          attemptedQuestions.add(q.id);
          if (selectedAnswers[q.id]) answeredQuestions.add(q.id);
        }
      });

      shuffledQuestions = [...questions];  // keep order unless you want random
      const firstUnattemptedIdx = questions.findIndex(q => !attemptedQuestions.has(q.id));
      currentQuestionIndex = firstUnattemptedIdx !== -1 ? firstUnattemptedIdx : 0;

      showQuestion();
      startTimer();  // start only once here
    });
  }

  // Grid
  function renderGrid() {
    const gridContainer = document.getElementById("question-grid");
    gridContainer.innerHTML = "";
    shuffledQuestions.forEach((q, index) => {
      let className = "grid-box";
      if (answeredQuestions.has(q.id)) className += " grid-answered";
      else if (attemptedQuestions.has(q.id)) className += " grid-skipped";
      else className += " grid-unanswered";

      if (index === currentQuestionIndex) className += " grid-current";

      const btn = document.createElement("div");
      btn.className = className;
      btn.innerText = index + 1;
      btn.onclick = () => {
        // Save current selection before switching
        const currentQ = shuffledQuestions[currentQuestionIndex];
        const selected = document.querySelector('input[name="option"]:checked');
        const selectedOption = selected ? selected.value : null;
        if (selectedOption) answeredQuestions.add(currentQ.id);
        if (selectedOption || selectedAnswers[currentQ.id] !== undefined)
          attemptedQuestions.add(currentQ.id);
        selectedAnswers[currentQ.id] = selectedOption;

        currentQuestionIndex = index;
        showQuestion(currentQuestionIndex);
      };
      gridContainer.appendChild(btn);
    });
  }

  // Show question
  function showQuestion(index = currentQuestionIndex) {
    currentQuestionIndex = index;
    document.getElementById("backBtn").style.display =
      currentQuestionIndex === 0 ? "none" : "inline-block";
    document.getElementById("nextBtn").textContent =
      currentQuestionIndex === shuffledQuestions.length - 1 ? "Submit" : "Next";
    document.getElementById("skipBtn").style.display =
      currentQuestionIndex === shuffledQuestions.length - 1 ? "none" : "inline-block";

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
    renderGrid();
  }

  // Skip
  document.getElementById("skipBtn").onclick = () => {
    const q = shuffledQuestions[currentQuestionIndex];
    attemptedQuestions.add(q.id);
    selectedAnswers[q.id] = null;

    let gettimeTaken = totalTime - remainingTime;
    let timeTaken = gettimeTaken % 60;

    saveAttempt(q.id, null, remainingTime, timeTaken);

    currentQuestionIndex++;
    if (currentQuestionIndex < shuffledQuestions.length) {
      showQuestion();
    } else {
      submitExam();
    }
  };

  // Next / Submit
  document.getElementById("nextBtn").onclick = () => {
    const q = shuffledQuestions[currentQuestionIndex];
    const selected = document.querySelector('input[name="option"]:checked');
    const selectedOption = selected ? selected.value : null;

    attemptedQuestions.add(q.id);
    if (selectedOption) answeredQuestions.add(q.id);
    selectedAnswers[q.id] = selectedOption;

    let gettimeTaken = totalTime - remainingTime;
    let timeTaken = gettimeTaken % 60;

    saveAttempt(q.id, selectedOption, remainingTime, timeTaken);

    currentQuestionIndex++;
    if (currentQuestionIndex < shuffledQuestions.length) {
      showQuestion();
    } else {
      submitExam();
    }
  };

  // Back
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

  function saveAttempt(qid, selectedOption, timeLeft, timeTaken) {
    fetch("{{url('save-each-attempt')}}", {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: JSON.stringify({
        exam_id: exam_id,
        unique_id: uniqueId,
        question_id: qid,
        selected_option: selectedOption,
        time_remaining: timeLeft,
        time_taken: timeTaken,
      })
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
        <p><strong>Time Taken: ${minutes} minutes ${seconds} seconds</strong></p>
        <p>${data.message}</p>`;
    });
  }


  // ===== Exam Window Note Display =====
document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('uniqueId');
  const btn   = document.getElementById('validateBtn');
  const note  = document.getElementById('windowNote');

  async function checkWindow() {
    const unique_id = input.value.trim();
    if (!unique_id) return;

    try {
      const res = await fetch("{{ url('validate-candidate') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": '{{ csrf_token() }}'
        },
        body: JSON.stringify({ unique_id })
      });

      const data = await res.json();

      if (data.window) {
        note.style.display = "block";
        note.textContent = `Exam window: ${data.window.start_display} to ${data.window.end_display}`;
      }

      if (!data.valid && data.message) {
        // Show returned reason (e.g. before/after slot, invalid ID)
        document.getElementById("loginError").innerText = data.message;
        document.getElementById("loginError").style.display = "block";
      }
    } catch (err) {
      console.error(err);
    }
  }

  // Show note when they leave the input field
  input.addEventListener('blur', checkWindow);

  // Or when they click validate
  btn.addEventListener('click', function (e) {
    e.preventDefault();
    checkWindow();
  });
});

</script>

</body>
</html>

