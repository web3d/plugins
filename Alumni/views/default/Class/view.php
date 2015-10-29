<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php', true);
 ?>

<div class="col-mb-12 col-8" id="main" role="main">
	<h2 class="post-title"><?php echo $class['name'] ?></h2>
        
        <?php foreach ($class as $key => $value): ?>
        <p><?php echo $key;?>:<?php echo $value;?></p>
        <?php endforeach;?>

	
</div><!-- end #main-->

<?php $this->need('sidebar.php', true); ?>
<?php $this->need('footer.php', true); ?>