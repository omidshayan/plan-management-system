<?php include_once 'header.php';
include_once '../connect.php';
$userId = $_SESSION['user-id'];
// $notifications = "SELECT *, (SELECT `name` FROM `plans` WHERE plans.id = notifications.plan_id) AS `name` FROM `notifications` WHERE `user_id` = ?";
$notifications = "SELECT * FROM plans WHERE implementation = ? AND `status` = 1 ORDER BY id DESC"; 
$result = $connect->prepare($notifications);
$result->bindValue(1, $userId);
$result->execute(); 
$rowCount = $result->rowCount();
$notifications = $result->fetchAll(PDO::FETCH_ASSOC);
?>

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
      <div class="notif-number"><?=$rowCount?></div>
      <i class="fas fa-bell"></i>
      <div class="notif-show-items">
        <div class="title-notif">آخرین رویدادها</div>
        <?php 
        if(!$notifications){ ?>
        <br>
        <div class="noNotif"> رویداد ناخوانده ای <br> وجود ندارد </div>
        <br>
      <?php }
          foreach($notifications as $notification){ ?> 
          <a href="unRead.php" target="content-frame" class="notif-item"><div><?=substr($notification['name'], 0, 34)?>...</div></a>
        <?php }
        ?>
        <hr class="hr">
        <a href="unRead.php" target="content-frame" class="notif-showAll"><div>نمایش همه</div></a>
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
          <div> استاد: <?= $_SESSION['user-name'] ?></div>
        </div>
      </div>
      <div class="img-avatar">
        <img src="admin/<?= $_SESSION['user-image'] ?>" alt="" />
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
            <li><a href="my-plans.php" class="siedbar-click" target="content-frame">پلان های من</a></li>
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