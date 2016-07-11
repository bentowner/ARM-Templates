<div class="tile">
  <div class="tile-heading"><?php echo $heading_title; ?> <span class="pull-right">
    <?php if ($percentage > 0) { ?>
    <i class="fa fa-caret-up"></i>
    <?php } elseif ($percentage < 0) { ?>
    <i class="fa fa-caret-down"></i>
    <?php } ?>
    <?php echo $percentage; ?>%</span></div>
  <div class="tile-body"><i class="fa fa-flag-o"></i>
    <h2 class="pull-right"><?php echo $daily; ?></h2>
  </div>
  <div class="tile-footer"><a ><?php echo $text_view; ?></a>

  </div>
</div>
