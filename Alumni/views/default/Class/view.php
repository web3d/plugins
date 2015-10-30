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
<script type="text/tecblock" id="class-create-form-script">
    <div class="col-mb-12 col-8">
    <form method="post" action="<?php echo $this->url('alumni_class_create');?>" id="class-create-form">
        <p id="class-create-error-tips">
        
        </p>
        <p>
        <label for="form-field-name">班级名称:<input id="form-field-name" name="name" type="text" /></label>
        </p>
        <p>
        <label for="form-field-enyear">入学年份:<input id="form-field-enyear" name="enyear" type="text" /></label>
        </p>
        <p>
        <label for="form-field-dept">院系:<input id="form-field-dept" name="deptid" type="text" /></label>
        </p>
        <p>
        <input type="submit" value="提交" />
        <input type="reset" value="重置" />
        </p>
        
    </form>
	
</div>
</script>

<script type="text/javascript" src="<?php echo Typecho_Common::url('Alumni/views/' . $this->themeDir . '/static/js/jquery-1.8.3.min.js' , $this->options->pluginUrl); ?>"></script>
<link rel="stylesheet" href="<?php echo Typecho_Common::url('Alumni/views/' . $this->themeDir . '/static/css/ui-dialog.css' , $this->options->pluginUrl); ?>" />
<script type="text/javascript" src="<?php echo Typecho_Common::url('Alumni/views/' . $this->themeDir . '/static/js/dialog-min.js' , $this->options->pluginUrl); ?>"></script>
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
        
        window.dialog = dialog;
        
        
        $('#create-class-btn').click(function() {
            var d = dialog({
                id: 'create-class-dialog',
                title: '创建班级',
                content:$('#class-create-form-script').html()
             });
            d.show();
            
            return false;
        });
        
        $('#class-create-form').live('submit', function() {
            $.ajax({
                "url": $(this).attr('action'), 
                "data": $(this).serialize(),
                "dataType": "json",
                "beforeSend": function() {
                    $(this).find('input[type=submit]').attr("disabled","disabled");
                },
                "success": function(data){
                     if(data.ret == 1) {
                         $('#class-create-error-tips').html(data.data);
                         dialog.get('create-class-dialog').close().remove();
                     } else {
                         $('#class-create-error-tips').html(data.msg);
                         $(this).find('input[type=submit]').attr("enable","enable");
                     }
                     return false;
                 }
            });
            return false;
        });
    });
</script>
<?php $this->need('footer.php', true); ?>