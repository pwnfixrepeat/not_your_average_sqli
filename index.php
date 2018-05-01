<?php
  require_once 'secure_db.php';
  $db = new definitely_not_vulnerable('site.db');
?>
<html>
  <head><title>H4X0R P4r4d1s3</title></head>
  <body>
    Search article:
    <form action="">
        <input type="text" name="search" />
        <input type="hidden" name="limit" value="10" />
        <button type="submit">Search</button>
    </form><br />
  <?php if( isset($_GET['news_id']) && $res = $db->query($db->enhanced_prepare('SELECT title, content FROM news WHERE id=%d', $_GET['news_id']))->fetchArray() ):?>
    <h1><?=htmlentities($res[0])?></h1>
    <p><?=htmlentities($res[1])?></p>

  <?php elseif( isset($_GET['search']) && is_string($_GET['search']) ):
    $search = '%%'.$_GET['search'].'%%';
    $where = $db->enhanced_prepare('WHERE title LIKE %s OR content LIKE %s', $search, $search);
    $prepared_stmt = $db->enhanced_prepare("SELECT * FROM news $where LIMIT %d", isset($_GET['limit'])?$_GET['limit']:10);
    $res = $db->query($prepared_stmt);
    while( $post = $res->fetchArray() ): ?>
        <a href="/?news_id=<?=intval($post[0])?>"><?=htmlentities($post[1])?></a><?php
    endwhile;?>

  <?php else:?>
    <h1>Latest news:</h1>
    <?php $res = $db->query('SELECT * FROM news'); ?>
    <?php while( $post = $res->fetchArray() ): ?>
      <a href="/?news_id=<?=intval($post[0])?>"><?=htmlentities($post[1])?></a>
    <?php endwhile; ?>
  <?php endif;?>
  </body>
</html>
