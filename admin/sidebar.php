<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../assets/style/style.css" />
  <title>غالب</title>
  <script src="../lib/ck/build/ckeditor.js"></script>
  <script>
    CKEDITOR.replace('body');
  </script>
</head>

<body>
  <input type="text" id="menu-toggle" />

  <!-- start appbar -->
  <div class="appBar">
    <header>
      <div class="hamber">
        <i class="fas fa-bars"></i>
      </div>
    </header>
    appbar
  </div>
  <!-- end sidebar -->

  <!-- start sidebar -->
  <div class="sidebar">
    <div class="sidebar-section">
      <div class="brand-name">دانشگاه غالب</div>
      <div class="avatar">
        <div class="info-avatar">
          <div class="text-avatar">
            <div>مدیر: <?= $_SESSION['user-name'] ?></div>
          </div>
        </div>
        <div class="img-avatar">
          <img src="../assets/img/profile.png" alt="" />
        </div>
      </div>
      <div class="sidebar-item">
        <ul>
          <li>
            <a href="index.php" class="active">
              <i class="fas fa-tachometer-alt"></i>
              <span>صفحه اصلی</span>
            </a>
          </li>
          <li>
            <a href="add-plan.php">
              <i class="fas fa-tachometer-alt"></i>
              <span> ایجاد پلن جدید</span>
            </a>
          </li>
          <li>
            <a href="plans.php">
              <i class="fas fa-tachometer-alt"></i>
              <span>پلن ها</span>
            </a>
          </li>
          <li>
            <a href="employees.php">
              <i class="fas fa-tachometer-alt"></i>
              <span> کارمندان</span>
            </a>
          </li>
          <li>
            <a href="add-employee.php">
              <i class="fas fa-tachometer-alt"></i>
              <span>ثبت کارمند</span>
            </a>
          </li>
          <li>
            <a href="sections.php">
              <i class="fas fa-tachometer-alt"></i>
              <span>بخش ها</span>
            </a>
          </li>
          <li>
            <a href="add-section.php">
              <i class="fas fa-tachometer-alt"></i>
              <span>ثبت بخش جدید</span>
            </a>
          </li>
          <li>
            <a href="../logout.php">
              <i class="fas fa-tachometer-alt"></i>
              <span>خروج</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- end sidebar -->