<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('header.php', true);
?>

<div class="col-mb-12 col-8" id="main" role="main">
	<h2 class="post-title"><?php echo $class['name'] ?></h2>
        
        <?php if (!$has_joined): ?>
        <a href="<?php echo $this->url('alumni_class_join');?>" id="join-class-btn" data-classid="<?php echo $class['id'];?>">申请加入</a>
        <?php endif;?>
        
        <a href="<?php echo $this->url('alumni_class_create');?>" id="create-class-btn" data-classid="<?php echo $class['id'];?>">创建新的</a>
        
        <?php foreach ($class as $key => $value): ?>
        <p><?php echo $key;?>:<?php echo $value;?></p>
        <?php endforeach;?>

	
</div><!-- end #main-->

<?php $this->need('sidebar.php', true); ?>
<script type="text/javascript" src="<?php echo Typecho_Common::url('Alumni/views/' . $this->themeDir . '/static/js/jquery-1.8.3.min.js' , $this->options->pluginUrl); ?>"></script>
<script type="text/javascript">
    $(function() {
        $('#join-class-btn').click(function() {
            $.ajax({
                "url": $(this).attr('href'), 
                "data": {id: $(this).attr('data-classid')},
                "dataType": "json",
                "success": function(data){
                     alert(data.ret == 1 ? '申请提交成功,请等待班级管理员审核' : '提交失败,请返回重试');
                 }
            });
            return false;
        });
    });
</script>
<?php $this->need('footer.php', true); ?>