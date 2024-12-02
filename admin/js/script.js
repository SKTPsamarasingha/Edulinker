function adminSignIn() {
  var email = document.getElementById("email");
  var password = document.getElementById("password");

  var form = new FormData();
  form.append("e", email.value);
  form.append("p", password.value);

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

  r.open("POST", "adminSignInProcess.php", true);
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

function saveSubject() {
  var subject = document.getElementById("subject");

  var form = new FormData();
  form.append("subject", subject.value);

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

  r.open("POST", "saveSubjectProcess.php", true);
  r.send(form);
}

function saveGrade() {
  var grade = document.getElementById("grade");

  var form = new FormData();
  form.append("grade", grade.value);

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

  r.open("POST", "saveGradeProcess.php", true);
  r.send(form);
}

function searchTeacher() {
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
      if(t=="login"){
        window.location="login.php";
      }else{
        document.getElementById("sTeacherBody").innerHTML = t;
      }
    }
  };

  r.open("POST", "searchTeacherProcess.php", true);
  r.send(form);
}

function changeTeacherStatus(id){

  var form = new FormData();
  form.append("id", id);

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

  r.open("POST", "changeTeacherStatusProcess.php", true);
  r.send(form);
}

function changeStudentStatus(id){

  var form = new FormData();
  form.append("id", id);

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

  r.open("POST", "changeStudentStatusProcess.php", true);
  r.send(form);
}

function searchStudent() {
  var sname = document.getElementById("sname");
  var sstatus = document.getElementById("sstatus");

  var form = new FormData();
  form.append("sname", sname.value);
  form.append("sstatus", sstatus.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if(t=="login"){
        window.location="login.php";
      }else{
        document.getElementById("sStudentBody").innerHTML = t;
      }
    }
  };

  r.open("POST", "searchStudentProcess.php", true);
  r.send(form);
}