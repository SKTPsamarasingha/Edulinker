<?php
require "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduLinker</title>
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link
    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
    rel="stylesheet" />
  <link rel="stylesheet" href="css/styles.css" />

  <style>
            .star {
                font-size: 2rem;
                color: gray;
                cursor: pointer;
            }

            .star.selected {
                color: gold;
            }
            </style>
</head>

<body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">EduLinker</a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item mx-1">
          <a class="nav-link" href="#home">Home</a>
        </li>
        <li class="nav-item mx-1">
          <a class="nav-link" href="#about">About</a>
        </li>
        <li class="nav-item mx-1">
          <a class="nav-link" href="#services">Services</a>
        </li>
        <li class="nav-item mx-1">
          <a class="nav-link" href="#contact">Contact</a>
        </li>
        <li class="nav-item mx-1">
          <a
            class="nav-link btn btn-outline-primary text-white-hover"
            href="student/dashboard.php">
            Login Student <i class="bx bx-log-in-circle"></i>
          </a>
        </li>
        <li class="nav-item mx-1">
          <a
            class="nav-link btn btn-outline-primary text-white-hover"
            href="teacher/dashboard.php">
            Login Teacher <i class="bx bx-log-in-circle"></i>
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Landing Page -->
  <div class="landing-page container-fluid">
    <div class="container-one row align-items-center">
      <div class="container-one-img-container col-lg-4 text-center">
        <img
          class="container-one-img"
          src="public/assets/images/sapiens-nobg.png"
          alt="" />
      </div>
      <div class="container-one-text-container col-lg-8">
        <p class="heading-text">Unleash your inner learner.</p>
        <p class="sub-heading-text">
          Find the perfect tutor for any subject, anywhere in Sri Lanka.
        </p>
        <button class="btn btn-primary mt-3">Get Started</button>
      </div>
    </div>

    <!-- Additional Sections -->
    <div
      class="container-two row mt-5 justify-content-center align-items-center">
      <div class="col-lg-6 ps-4">
        <p class="sub-heading-text">Why Choose EduLinker?</p>
        <p class="paragraph-text">
          EduLinker connects students with verified tutors across Sri Lanka,
          making learning accessible and convenient. Our platform ensures that
          you find the best tutors for your educational needs, whether it's
          online or in-person.
        </p>
      </div>
      <div class="col-lg-6 text-center">
        <img
          src="public/assets/images/learning.jpg"
          class="img-fluid"
          alt="Learning Illustration" />
      </div>
    </div>

    <div class="container-three row mt-5 text-center">
      <div class="col-lg-4">
        <p class="sub-heading-text">Verified Tutors</p>
        <p class="paragraph-text">
          We verify the credentials of every tutor to ensure quality education
          for students.
        </p>
      </div>
      <div class="col-lg-4">
        <p class="sub-heading-text">Flexible Learning</p>
        <p class="paragraph-text">
          Choose from a variety of teaching methods, including online and
          in-person sessions.
        </p>
      </div>
      <div class="col-lg-4">
        <p class="sub-heading-text">Student Reviews</p>
        <p class="paragraph-text">
          Read reviews from other students to find the best tutor for you.
        </p>
      </div>
    </div>
  </div>

  <div class="col-12 p-5 ">
    <div class="row d-flex justify-content-center gap-4">

      <?php

      $teacher_rs = Database::search("SELECT * FROM `teacher`");
      $teacher_num = $teacher_rs->num_rows;

      for ($i = 0; $i < $teacher_num; $i++) {
        $teacher_data = $teacher_rs->fetch_assoc();
      ?>
        <div class="card shadow " style="width: 18rem;">
          <div class="overflow-hidden">
            <img src="<?php echo $teacher_data['profile']; ?>" class="card-img-top teacher-card-image" alt="...">

          </div>
          <div class="card-body">
            <h5 class="card-title"><?php echo $teacher_data['fname'] . " " . $teacher_data['lname']; ?></h5>
            <div class="col-12">
              <div class="row">

                <?php
                $review_rs = Database::search("SELECT COUNT(`review`.`id`) AS `revireCount`,SUM(`review`.`rate`) AS `reviewRate`  FROM `review` INNER JOIN `session` ON `review`.`session_id`=`session`.`id` INNER JOIN `teacher_has_grade_has_subject` ON `session`.`teacher_grade_subject_id` = `teacher_has_grade_has_subject`.`id` WHERE `teacher_has_grade_has_subject`.`teacher_id`=?", [$teacher_data['id']], "s");

                $rate = 0;
                $review_data = $review_rs->fetch_assoc();
                $revireCount = $review_data["revireCount"];
                $reviewRate = $review_data["reviewRate"];

                if($revireCount>0){
                  $rate = $reviewRate / $revireCount;
                }
                ?>
                <div class="col-12">
                  <div class="row">
                    <div id="star-rating" class="d-flex">
                      <span class="star <?php echo $rate >= 1 ? 'selected' : ''; ?>" data-value="1">&#9733;</span>
                      <span class="star <?php echo $rate >= 2 ? 'selected' : ''; ?>" data-value="2">&#9733;</span>
                      <span class="star <?php echo $rate >= 3 ? 'selected' : ''; ?>" data-value="3">&#9733;</span>
                      <span class="star <?php echo $rate >= 4 ? 'selected' : ''; ?>" data-value="4">&#9733;</span>
                      <span class="star <?php echo $rate >= 5 ? 'selected' : ''; ?>" data-value="5">&#9733;</span>
                    </div>
                  </div>
                </div>

                <?php
                ?>

              </div>
            </div>
            <ul>
              <?php
              $tgs_rs = Database::search("SELECT `teacher_has_grade_has_subject`.`id` AS `id`,`grade`.`name` AS `grade`,`subject`.`name` AS `subject` FROM `teacher_has_grade_has_subject` INNER JOIN `grade` ON `teacher_has_grade_has_subject`.`grade_id`=`grade`.`id` INNER JOIN `subject` ON `teacher_has_grade_has_subject`.`subject_id`=`subject`.`id` WHERE `teacher_id`=?", [$teacher_data['id']], "s");
              $tgs_num = $tgs_rs->num_rows;
              for ($j = 0; $j < $tgs_num; $j++) {
                $tgs_data = $tgs_rs->fetch_assoc();
              ?>
                <li><?php echo $tgs_data['grade'] . " - " . $tgs_data['subject'] ?></li>
              <?php
              }
              ?>
            </ul>
            <p class="card-text"><?php echo $teacher_data['qulification']; ?></p>
            <a href="student/search-teacher.php" class="btn btn-primary">Schedule Session</a>
          </div>
        </div>
      <?php
      }
      ?>

    </div>
  </div>

  <!-- Footer -->
  <footer
    class="container-fluid bg-dark text-white py-3 border-top bottom-0 container-sizing"
    style="margin-top: 85px">
    <div class="row">
      <div class="col text-center">
        <p>
          <img
            src="public/assets/images/logo.png"
            height="75"
            alt="EduLinker Logo" />
        </p>
      </div>
    </div>

    <div class="row text-center py-2">
      <div class="col">
        <ul class="list-unstyled d-flex justify-content-center">
          <li><a href="#" class="me-3">Home</a></li>
          <li><a href="#" class="me-3">About</a></li>
          <li><a href="#" class="me-3">Services</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
    </div>

    <div class="row text-center py-2">
      <div class="col">
        <ul class="list-unstyled d-flex justify-content-center">
          <li>
            <a href="#" class="me-3"><i class="bi bi-facebook"></i></a>
          </li>
          <li>
            <a href="#" class="me-3"><i class="bi bi-instagram"></i></a>
          </li>
          <li>
            <a href="#" class="me-3"><i class="bi bi-youtube"></i></a>
          </li>
          <li>
            <a href="#" class="me-3"><i class="bi bi-twitter"></i></a>
          </li>
        </ul>
      </div>
    </div>

    <div class="row flex-lg-nowrap flex-md-wrap flex-wrap">
      <div class="col-md-3 separator">
        <h5>EduLinker</h5>
        <p>
          EduLinker is a web application that connects students in Sri Lanka
          with professional tutors. The platform provides access to teachers
          for the Sri Lankan government school syllabus from grade 6 up to
          A/L, ensuring effective online or in-person instruction.
        </p>
      </div>

      <div class="col-md-3 separator">
        <h5>Contact</h5>
        <ul class="list-unstyled">
          <li><a href="#">Hotline : 011rest</a></li>
          <li><a href="#">Email : contact&#64;edulink.lk</a></li>
          <li><a href="#">Whatsapp : 076rest</a></li>
          <li><a href="#">#58, That Street, Galle</a></li>
        </ul>
      </div>

      <div class="col-md-3 separator">
        <h5>Resources</h5>
        <ul class="list-unstyled">
          <li><a href="#">FAQs</a></li>
          <li><a href="#">Terms & Conditions</a></li>
        </ul>
      </div>

      <div class="col-md-2 separator">
        <h5>Other Services</h5>
        <ul class="list-unstyled">
          <li><a href="#">Can remove if not needed</a></li>
          <li><a href="#">Can remove if not needed</a></li>
          <li><a href="#">Can remove if not needed</a></li>
        </ul>
      </div>
    </div>

    <div class="row text-center py-2">
      <div class="col d-flex justify-content-center">
        <a href="#" class="me-3"><i class="bi bi-android2"></i></a>
        <a href="#"><i class="bi bi-apple"></i></a>
      </div>
    </div>

    <div class="text-center pb-5">
      <p>&copy; 2024 EduLinker. All Rights Reserved.</p>
    </div>
  </footer>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script src="js/mainScript.js"></script>

</body>

</html>