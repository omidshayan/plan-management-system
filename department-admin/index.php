<?php
session_start();
if (!isset($_SESSION['department-admin'])) {
  header('location: ../index.php');
}
include_once 'sidebar.php';
?>

<!-- content -->
<div class="content">
  <main>
    <iframe name="content-frame" src="dashboard.php" class="frame" frameborder="0"></iframe>
  </main>
</div>
<!-- end content -->

<div class="loading-overlay">
  <div class="enter-body">
    <div class="loader-circle-9">
      <img src="../assets/img/logo.png" class="logo-loading" alt="">
      <span></span>
    </div>
    <span class="title-loading">لطفا صبر کنید</span>
  </div>

</div>

<script>
  $(document).ready(function() {
    $('.siedbar-click').click(function() {
      disableScroll();
      $('.loading-overlay').show();
      if ($(window).width() <= 1000) {
        $('.sidebar').removeClass('active');
        $('#menu-toggle').removeClass('active');
      }
    });

    $('iframe[name="content-frame"]').on('load', function() {
      $(this).contents().find('a').on('click', function() {
        window.parent.postMessage('closeSidebar', '*');
      });
    });

    window.addEventListener('message', function(event) {
      if (event.data === 'closeSidebar') {
        $('.appBar').removeClass('active');
      }
    });

    // Hide loading spinner after content iframe loaded
    $('iframe[name="content-frame"]').on('load', function() {
      $('.loading-overlay').hide();
    });
  });

  $('.sidebar-item a').click(function() {
    $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  });

  function disableScroll() {
    window.addEventListener('mousewheel', preventDefault, {
      passive: false
    });
    window.addEventListener('touchmove', preventDefault, {
      passive: false
    });
  }

  function preventDefault(e) {
    e.preventDefault();
  }

  function enableScroll() {
    window.removeEventListener('mousewheel', preventDefault);
    window.removeEventListener('touchmove', preventDefault);
  }
</script>


<?php
include_once 'footer.php';
?>