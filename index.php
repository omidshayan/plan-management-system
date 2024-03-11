<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/style/style.css" />
    <title>غالب</title>
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
              <div>مدیر</div>
            </div>
          </div>
          <div class="img-avatar">
            <img src="assets/img/profile.png" alt="" />
          </div>
        </div>
        <div class="sidebar-item">
          <ul>
            <li>
              <a href="index.html" class="active">
                <i class="fas fa-tachometer-alt"></i>
                <span>صفحه اصلی</span>
              </a>
            </li>
            <li>
              <a href="input-insert.html">
                <i class="fas fa-tachometer-alt"></i>
                <span>مدیریت کارمندان</span>
              </a>
            </li>
            <li>
              <a href="table.html">
                <i class="fas fa-tachometer-alt"></i>
                <span>table</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- end sidebar -->

    <!-- content -->
    <div class="content">
      <main>
        <div class="report">
          <div class="report-item">
            <div class="report-icon">
              <i class="fas fa-eye"></i>
            </div>
            <div class="report-text">
              <span>تعداد بازدید</span>
            </div>
          </div>

          <div class="report-item">
            <div class="report-icon">
              <i class="fas fa-eye"></i>
            </div>
            <div class="report-text">
              <span>تعداد بازدید</span>
            </div>
          </div>
          <div class="report-item">
            <div class="report-icon">
              <i class="fas fa-eye"></i>
            </div>
            <div class="report-text">
              <span>تعداد بازدید</span>
            </div>
          </div>
        </div>
      </main>
    </div>
    <!-- end content -->

    <script src="assets/js/FontAwesomeAll.min.js"></script>
    <script src="assets/js/script.js"></script>
  </body>
</html>
