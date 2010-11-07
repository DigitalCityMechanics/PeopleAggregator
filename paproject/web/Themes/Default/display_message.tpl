<div id="display_message2">
  <ul>
    <?php 
      if (is_array($message)) {
        foreach ($message as $msg) {
    ?>
          <li><?php echo $msg?></li>
    <?php
        }
      } else {
    ?>
        <li><?php echo $message?> </li>
    <?php
      }
    ?>
  </ul>
</div>
<br /><?php /* we need some HTML element here, or the iframe above will cause a rendering error */ ?>