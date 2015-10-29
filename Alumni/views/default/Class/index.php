<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php', true);
 ?>

<div class="col-mb-12 col-8" id="main" role="main">
	<?php while($this->next()): ?>
   
        <article class="post">
			<h2 class="post-title" itemprop="name headline"><a itemtype="url" href="<?php echo $this->url('alumni_class_view', array('deptid' => $this->row['id'])); ?>"><?php echo $this->row['name']; ?></a></h2>
			
            
        </article>
	<?php endwhile; ?>

    <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
</div><!-- end #main-->

<?php $this->need('sidebar.php', true); ?>
<?php $this->need('footer.php', true); ?>