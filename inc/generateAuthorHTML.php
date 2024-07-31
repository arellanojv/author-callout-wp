<?php

function generateAuthorHTML($id)
{
  $authorInfo = get_userdata($id);
  $authorPost = new WP_User_Query(array(
    'search_columns' => array(
      'ID' => $id
    )
  ));

  if (!empty($authorInfo)) {

?>
    <div class="author-callout">
      <div class="author-callout__photo" style="background-position: initial; background-image: url(<?php echo get_avatar_url($id, array("size" => 300)); ?>);"></div>
      <div class="author-callout__text">
        <h5><?php echo $authorInfo->display_name; ?></h5>
        <p><?php echo wp_trim_words($authorInfo->description, 30); ?></p>

        <p><strong><a href="<?php echo $authorInfo->user_url; ?>">Learn more about Dr. <?php echo $authorInfo->last_name; ?> &raquo;</a></strong></p>

      </div>
    </div>
<?php
  }
}
