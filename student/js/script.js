function signUp() {
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var email = document.getElementById("email");
  var password = document.getElementById("password");

  var form = new FormData();
  form.append("fname", fname.value);
  form.append("lname", lname.value);
  form.append("email", email.value);
  form.append("password", password.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "Success") {
        window.location = "login.php";
      } else {
        document.getElementById("msg").innerHTML = t;
      }
    }
  };

  r.open("POST", "signUpProcess.php", true);
  r.send(form);
}

function signIn() {
  var email = document.getElementById("email");
  var password = document.getElementById("password");

  var form = new FormData();
  form.append("email", email.value);
  form.append("password", password.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "Success") {
        window.location = "dashboard.php";
      } else {
        document.getElementById("msg").innerHTML = t;
      }
    }
  };

  r.open("POST", "signInProcess.php", true);
  r.send(form);
}

function logOut() {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "Success") {
        window.location = "login.php";
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "logOutProcess.php", true);
  r.send();
}

function searchTeacher() {
  var sname = document.getElementById("sname");
  var sgrade = document.getElementById("sgrade");
  var ssubject = document.getElementById("ssubject");

  var form = new FormData();
  form.append("sname", sname.value);
  form.append("sgrade", sgrade.value);
  form.append("ssubject", ssubject.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "login") {
        window.location = "login.php";
      }
      document.getElementById("sTeacherBody").innerHTML = t;
    }
  };

  r.open("POST", "searchTeacherProcess.php", true);
  r.send(form);
}

function calToalFee(id) {
  var hour = document.getElementById("hours" + id).value;

  var total = hour * 1500;

  document.getElementById("total" + id).innerHTML = total;
}

function scheduleSession(teacherId) {
  var classId = document.getElementById("classId" + teacherId);
  var date = document.getElementById("date" + teacherId);
  var startTime = document.getElementById("startTime" + teacherId);
  var hours = document.getElementById("hours" + teacherId);
  var sessionType = document.getElementById("sessionType" + teacherId);

  var form = new FormData();
  form.append("teacherId", teacherId);
  form.append("classId", classId.value);
  form.append("date", date.value);
  form.append("startTime", startTime.value);
  form.append("hours", hours.value);
  form.append("sessionType", sessionType.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      alert(t);
      if (t == "Success") {
        window.location.reload();
      }
    }
  };

  r.open("POST", "scheduleSessionProcess.php", true);
  r.send(form);
}

function searchSession() {
  var sname = document.getElementById("sname");
  var sstatus = document.getElementById("sstatus");
  var sgrade = document.getElementById("sgrade");
  var ssubject = document.getElementById("ssubject");

  var form = new FormData();
  form.append("sname", sname.value);
  form.append("sstatus", sstatus.value);
  form.append("sgrade", sgrade.value);
  form.append("ssubject", ssubject.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "login") {
        window.location = "login.php";
      }
      document.getElementById("sSessionBody").innerHTML = t;
    }
  };

  r.open("POST", "searchSessionProcess.php", true);
  r.send(form);
}

function sessionPay(id) {
  var cardNo = document.getElementById("cardNo");
  var cardCvv = document.getElementById("cardCvv");
  var cardExDate = document.getElementById("cardExDate");

  var form = new FormData();
  form.append("id", id);
  form.append("cardNo", cardNo.value);
  form.append("cardCvv", cardCvv.value);
  form.append("cardExDate", cardExDate.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      alert(t);
      if (t == "Success") {
        window.location.reload();
      }
    }
  };

  r.open("POST", "sessionPayProcess.php", true);
  r.send(form);
}

function sendFeedback(sessionId) {
  var stars = document.querySelectorAll(
    "#star-rating-" + sessionId + " .star.selected"
  );
  var rating = stars.length > 0 ? stars.length : 0;
  // alert("The rating for " + sessionId + " is: " + rating);

  var feetbackTxt = document.getElementById("feetbackTxt"+sessionId);

  var form = new FormData();
  form.append("sessionId", sessionId);
  form.append("rating", rating);
  form.append("feetbackTxt", feetbackTxt.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      alert(t);
      if (t == "Updated Feedback"||t == "Send Feedback") {
        window.location.reload();
      }
    }
  };

  r.open("POST", "sendFeedbackProcess.php", true);
  r.send(form);
}
