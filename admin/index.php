<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
  header('location: ../index.php');
}
include_once 'sidebar.php';
?>

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


<?php
include_once 'footer.php';
?>