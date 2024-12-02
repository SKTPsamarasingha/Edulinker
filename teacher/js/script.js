function signUp() {
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var email = document.getElementById("email");
  var mobile = document.getElementById("mobile");
  var password = document.getElementById("password");
  var qulification = document.getElementById("qulification");
  var image = document.getElementById("profileimg");

  var form = new FormData();
  form.append("fname", fname.value);
  form.append("lname", lname.value);
  form.append("email", email.value);
  form.append("mobile", mobile.value);
  form.append("password", password.value);
  form.append("qulification", qulification.value);

  if (image.files.length == 0) {
    alert("You have not selected any image");
  } else {
    form.append("image", image.files[0]);
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

function addCladdForTeacher() {
  var grade = document.getElementById("grade");
  var subject = document.getElementById("subject");

  var form = new FormData();
  form.append("grade", grade.value);
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

  r.open("POST", "addCladdForTeacherProcess.php", true);
  r.send(form);
}

function removeTeacherClass(id) {
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

  r.open("POST", "removeTeacherClassProcess.php", true);
  r.send(form);
}

function updateProfile() {
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var mobile = document.getElementById("mobile");
  var qulification = document.getElementById("qulification");
  var image = document.getElementById("profileimg");

  var form = new FormData();
  form.append("fname", fname.value);
  form.append("lname", lname.value);
  form.append("mobile", mobile.value);
  form.append("qulification", qulification.value);

  if (image.files.length == 0) {
} else {
    form.append("image", image.files[0]);
}

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

  r.open("POST", "updateProfileProcess.php", true);
  r.send(form);
}

function appeoveSession(id) {
  var sPath = document.getElementById("sPath" + id);
  var sNote = document.getElementById("sNote" + id);

  var form = new FormData();
  form.append("id", id);
  form.append("sPath", sPath.value);
  form.append("sNote", sNote.value);

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

  r.open("POST", "appeoveSessionProcess.php", true);
  r.send(form);
}

function rejectSession(id) {
  var sNote = document.getElementById("sNote" + id);

  var form = new FormData();
  form.append("id", id);
  form.append("sNote", sNote.value);

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

  r.open("POST", "rejectSessionProcess.php", true);
  r.send(form);
}

function CompleteSession(id) {
  var sNote = document.getElementById("sNote" + id);

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

  r.open("POST", "CompleteSessionProcess.php", true);
  r.send(form);
}

function searchSession() {
  var sstatus = document.getElementById("sstatus");
  var sgrade = document.getElementById("sgrade");
  var ssubject = document.getElementById("ssubject");

  var form = new FormData();
  form.append("sstatus", sstatus.value);
  form.append("sgrade", sgrade.value);
  form.append("ssubject", ssubject.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "login") {
        window.location = "login.php";
      } else {
        document.getElementById("sSessionBody").innerHTML = t;
      }
    }
  };

  r.open("POST", "searchSessionProcess.php", true);
  r.send(form);
}

function changeImage() {
  var view = document.getElementById("viewimg"); //image tag
  var file = document.getElementById("profileimg"); //file chooser

  file.onchange = function () {
    var file1 = this.files[0];
    var url1 = window.URL.createObjectURL(file1);
    view.src = url1;
  };
}
