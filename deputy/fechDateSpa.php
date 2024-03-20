<?php include_once 'header.php';
include_once '../connect.php';
$userId = $_SESSION['user-id'];
$notifications = "SELECT * FROM plans WHERE implementation = ? AND `status` = 1 ORDER BY id DESC";
$result = $connect->prepare($notifications);
$result->bindValue(1, $userId);
$result->execute();
$rowCount = $result->rowCount();
$notifications = $result->fetchAll(PDO::FETCH_ASSOC);
?>
<script>
 var lastRequestCount = 0;

setInterval(function() {
    $.ajax({
        url: 'back/fetch_notifications.php',
        method: 'GET',
        data: {
            userId: <?= $userId ?>
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                var notifications = response.notifications;
                if (notifications.length > 0) {
                    lastId = notifications[0].id;
                }
                var newRequestCount = notifications.length;
                if (newRequestCount !== lastRequestCount) {
                    lastRequestCount = newRequestCount;
                    $('#requestCount').text(lastRequestCount);
                }
            } else {
                console.error('مشکلی در دریافت اطلاعات وجود دارد.');
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}, 1000);

</script>

<input type="text" id="menu-toggle" />
<a href="back/fetch_notifications?userId=<?= $userId ?>">link</a>
<!-- start appbar -->
<div class="appBar">
  <header>
    <div class="hamber">
      <i class="fas fa-bars"></i>
    </div>
  </header>
  <div class="appbar-items">
    <div class="notif">
      <div class="notif-number" id="requestCount"></div>
      <i class="fas fa-bell"></i>
      <div class="notif-show-items">
        <div class="title-notif">آخرین رویدادها</div>
        <?php
        if (!$notifications) { ?>
          <br>
          <div class="noNotif"> رویداد ناخوانده ای <br> وجود ندارد </div>
          <br>
        <?php }
        ?>
        <!-- <a href="unRead.php"  target="content-frame" class="notif-item">
            <div id="notificationList"></div>
          </a>
         -->

        <hr class="hr">
        <a href="unRead.php" target="content-frame" class="notif-showAll">
          <div>نـــــــــمایـــش </div>
        </a>
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
            <li><a href="my-plans.php" class="siedbar-click" target="content-frame">پلان های من</a></li>
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