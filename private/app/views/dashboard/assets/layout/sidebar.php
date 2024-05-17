<?php
$user = new User();
?>
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <?php
    $role = $user->access('แอดมิน');
    if ($role) {
    ?>
      <li class="nav-item">
        <a class="nav-link <?php if (!isset($_GET['page'])) {
                              echo "";
                            } else {
                              echo "collapsed";
                            } ?>" href="dashboard">
          <i class="bi bi-grid"></i>
          <span>แดชบอร์ด</span>
        </a>
      </li>
    <?php } ?>
    <!-- End Dashboard Nav -->

    <!-- News Management -->
    <?php
    $role = $user->access('นักสื่อสารองค์กร');
    if ($role) {
    ?>
      <li class="nav-item">
        <a class="nav-link <?php if (isset($_GET['page'])) {
                              $p = $_GET['page'];
                              if ($p != "draft-list") {
                                echo "collapsed";
                              } else {
                                echo "";
                              }
                            } else {
                              echo "collapsed";
                            } ?>" href="?page=draft-list">
          <i class="fa-solid fa-pen-ruler"></i>
          <span>ร่างข่าว</span>
        </a>
      </li>
    <?php } ?>
    <!-- End News Management -->

    <!-- News Management -->
    <?php
    $role = $user->access('นักสื่อสารองค์กร');
    if ($role) {
    ?>
      <li class="nav-item">
        <a class="nav-link <?php if (isset($_GET['page'])) {
                              $p = $_GET['page'];
                              if ($p != "public-list") {
                                echo "collapsed";
                              } else {
                                echo "";
                              }
                            } else {
                              echo "collapsed";
                            } ?>" href="?page=public-list">
          <i class="bi bi-globe"></i>
          <span>ข่าวเผยแพร่</span>
        </a>
      </li>
    <?php } ?>
    <!-- End News Management -->

    <!-- News Management -->
    <?php
    $role = $user->access('ประชาสัมพันธ์');
    if ($role) {
    ?>
      <li class="nav-item">
        <a class="nav-link <?php if (isset($_GET['page'])) {
                              $p = $_GET['page'];
                              if ($p != "news-list") {
                                echo "collapsed";
                              } else {
                                echo "";
                              }
                            } else {
                              echo "collapsed";
                            } ?>" href="?page=news-list">
          <i class="bi bi-newspaper"></i>
          <span>จัดการข่าว</span>
        </a>
      </li>
    <?php } ?>
    <!-- End News Management -->

    <!-- News Management -->
    <?php $role = $user->access('ประชาสัมพันธ์');
    if ($role) { ?>
      <li class="nav-item">
        <a class="nav-link <?php if (isset($_GET['page'])) {
                              $p = $_GET['page'];
                              if ($p != "category-list") {
                                echo "collapsed";
                              } else {
                                echo "";
                              }
                            } else {
                              echo "collapsed";
                            } ?>" href="?page=category-list">
          <i class="bi bi-tags-fill"></i>
          <span>จัดการหมวดหมู่</span>
        </a>
      </li>
    <?php } ?>
    <!-- End News Management -->

    <!-- News Management -->
    <?php $role = $user->access('บรรณาธิการ');
    if ($role) { ?>
      <li class="nav-item">
        <a class="nav-link <?php if (isset($_GET['page'])) {
                              $p = $_GET['page'];
                              if ($p != "newsletter-list") {
                                echo "collapsed";
                              } else {
                                echo "";
                              }
                            } else {
                              echo "collapsed";
                            } ?>" href="?page=newsletter-list">
          <i class="bi bi-calendar-date-fill"></i>
          <span>เรียบเรียงจดหมายข่าว</span>
        </a>
      </li>
    <?php } ?>
    <!-- End News Management -->

    <!-- News Management -->
    <?php $role = $user->access('แอดมิน');
    if ($role) { ?>
      <li class="nav-item">
        <a class="nav-link <?php if (isset($_GET['page'])) {
                              $p = $_GET['page'];
                              if ($p != "member-list") {
                                echo "collapsed";
                              } else {
                                echo "";
                              }
                            } else {
                              echo "collapsed";
                            } ?>" href="?page=member-list">
          <i class="bi bi-people-fill"></i>
          <span>จัดการผู้ใช้งาน</span>
        </a>
      </li>
    <?php } ?>
    <!-- End News Management -->

    <!-- News Management -->
    <?php $role = $user->access('ประชาสัมพันธ์');
    if ($role) { ?>
      <li class="nav-item">
        <a class="nav-link <?php if (isset($_GET['page'])) {
                              $p = $_GET['page'];
                              if ($p != "banner-list") {
                                echo "collapsed";
                              } else {
                                echo "";
                              }
                            } else {
                              echo "collapsed";
                            } ?>" href="?page=banner-list">
          <i class="bi bi-card-image"></i>
          <span>จัดการแบนเนอร์</span>
        </a>
      </li>
    <?php } ?>
    <!-- End News Management -->

  </ul>

</aside>