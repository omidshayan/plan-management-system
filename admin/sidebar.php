<?php include_once 'header.php' ?>

<input type="text" id="menu-toggle" />

<!-- start appbar -->
<div class="appBar">
  <header>
    <div class="hamber">
      <i class="fas fa-bars"></i>
    </div>
  </header>
  <div class="appbar-items">
    <div class="notif">
      <div class="notif-number">22</div>
      <i class="fas fa-bell"></i>
      <div class="notif-show-items">
        <div class="title-notif">آخرین رویدادها</div>
        <a href="" class="notif-item"><div>item 1</div></a>
        <a href="" class="notif-item"><div>item 1</div></a>
        <hr class="hr">
        <a href="notifications.php" target="content-frame" class="notif-showAll"><div>نمایش همه</div></a>
      </div>
    </div>
  </div>
</div>
<br>
<!-- end sidebar -->

<!-- submenu sidebar -->
<script>
  $(document).ready(function() {
    $('.has-submenu').click(function() {
      var submenu = $(this).find('.submenu');
      if (submenu.is(':visible')) {
        submenu.slideUp();
      } else {
        $('.submenu').slideUp();
        submenu.slideDown();
      }
    });
  });
</script>

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
        <img src="admin/<?= $_SESSION['user-image'] ?>" alt="profile" />
      </div>
    </div>
    <div class="sidebar-item">
      <ul>
        <li>
          <a href="dashboard.php" class="siedbar-click" target="content-frame">
            <i class="fas fa-tachometer-alt"></i>
            <span>صفحه اصلی</span>
          </a>
        </li>


        <li class="has-submenu">
          <i class="fas fa-sort-down submenu-icon"></i>
          <a href="#">
            <i class="fas fa-tasks"></i>
            <span>پلان ها</span>
          </a>
          <ul class="submenu" style="display: none;">
            <li><a href="add-plan.php" class="siedbar-click" target="content-frame">ثبت پلان جدید</a></li>
            <li><a href="plans.php" class="siedbar-click" target="content-frame">نمایش پلان ها</a></li>
          </ul>
        </li>

        <li class="has-submenu">
          <i class="fas fa-sort-down submenu-icon"></i>
          <a href="#">
            <i class="fas fa-users"></i>
            <span>مدیریت کارمندان</span>
          </a>
          <ul class="submenu" style="display: none;">
            <li><a href="employees.php" class="siedbar-click" target="content-frame">کارمندان</a></li>
            <li><a href="add-employee.php" class="siedbar-click" target="content-frame">ثبت کارمند</a></li>
          </ul>
        </li>

        <li class="has-submenu">
          <i class="fas fa-sort-down submenu-icon"></i>
          <a href="#">
            <i class="fas fa-puzzle-piece"></i>
            <span>بخش ها</span>
          </a>
          <ul class="submenu" style="display: none;">
            <li><a href="add-section.php" class="siedbar-click" target="content-frame">ثبت بخش جدید</a></li>
            <li><a href="sections.php" class="siedbar-click" target="content-frame">نمایش بخش ها</a></li>
          </ul>
        </li>

        <li>
          <a href="profile.php" class="siedbar-click" target="content-frame">
            <i class="fas fa-user-circle"></i>
            <span>تنظیمات پروفایل</span>
          </a>
        </li>
        <li>
          <a href="../logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>خروج</span>
          </a>
        </li>
      </ul>
      <span class="soft-house">Ghalib Software House</span>
    </div>
  </div>
</div>
<!-- end sidebar -->