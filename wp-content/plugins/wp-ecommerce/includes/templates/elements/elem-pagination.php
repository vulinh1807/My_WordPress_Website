<?php
$paged = isset($_REQUEST['paged']) ? $_REQUEST['paged']:1;
?>
<div class="tablenav-pages">
  <span class="displaying-num"><?php $total_items; ?> Mục</span>
  <span class="pagination-links">
    <?php if((int)$paged > 1): ?>
    <a 
    class="prev-page button" 
    href="admin.php?page=wp-orders&paged=<?php (int)$paged - 1; ?>">
      <span aria-hidden="true"> ‹-- </span>
    </a>
    <?php endif; ?>
    <span class="screen-reader-text">Trang hiện tại</span>
    <span id="table-paging" class="paging-input">
      <span class="tablenav-paging-text"><?php $paged; ?> trên
        <span class="total-pages"><?php $total_pages ?></span>
      </span>
    </span>
    <?php if((int)$paged > ((int)$total_pages)): ?>
    <a 
    class="next-page button" 
    href="admin.php?page=wp-orders&paged=<?php (int)$paged + 1; ?>">
      <span aria-hidden="true"> --› </span>
    </a>
    <?php endif; ?>
  </span>
</div>