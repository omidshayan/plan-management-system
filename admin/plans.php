<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once 'sidebar.php';
?>
<!-- content -->
<div class="content">
    <div class="title">
        <div class="title-text">نمایش پلن ها</div>
    </div>
    <br>
    <div class="content-container">
       Plans List
  
        </div>
    </div>
</div>
<!-- end content -->

<?php
include_once 'footer.php';
?>