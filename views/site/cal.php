<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = '管理日历';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="art-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="art-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
        'options'  =>['class'=>'form-inline']
    ]); ?>
    <div class="form-group">
        <label for="">名称</label>
        <input type="text" class="form-control" name="name" value="<?=$name;?>" placeholder="请输入日历名称">
    </div>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<div class="cal-container">
<?php if (!empty($cal_infos)): ?>
    <?php foreach ($cal_infos as $key => $value): ?>
        <div class="row">
          <div class="col-xs-12 col-md-4"><?=$value['name'];?></div>
          <div class="col-xs-12 col-md-4">
            <?php if (empty($value['relation_userinfo'])): ?>
                <img src="<?=$value['member']['avatar'];?>" width="40px" height="40px"/> <span><?=$value['member']['nickname'];?></span>
            <?php else: ?>
                <img src="<?=$value['relation_userinfo']['relation_avatar'];?>" /> <span><?=$value['relation_userinfo']['relation_nickname'];?></span>
            <?php endif ?>
              
          </div>
          <div class="col-xs-12 col-md-4">
            <?= Html::a('-', 'javascript:void(0);',['class'=>"btn btn-default",'onclick'=>"minute($key,$value[id])"]) ?>
            <?= Html::input('number', 'view_count', $value['view_count'],['class' => 'btn btn-number','id'=>"view_count_$key",'onchange'=>"change($key,$value[id])"]);?>
            <?= Html::a('+', 'javascript:void(0);',['class'=>"btn btn-default",'onclick'=>"add($key,$value[id])"]) ?>
            <?= Html::a('删除', 'javascript:void(0);',['class'=>"btn btn-warning",'onclick'=>"del($value[id])"]) ?>
          </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
</div>
    
</div>

<?php $this->beginBlock("js-block") ?>
    function minute(key,id) {
        var view_count = parseInt($("#view_count_" + key).val());
        if(view_count <= 0) {
            view_count = 0;
        } else {
            view_count = view_count - 1;
        }
        $("#view_count_" + key).val(view_count);
        changeViewCount(key,id);
    }
    function add(key,id){
        var view_count = parseInt($("#view_count_" + key).val());
        view_count = view_count + 1;
        $("#view_count_" + key).val(view_count);
        changeViewCount(key,id);
    }
    function change(key,id){
        var view_count = $("#view_count_" + key).val();
        if(view_count == "") {
            view_count = 0;
        }   
        $("#view_count_" + key).val(view_count);
        changeViewCount(key,id);
    }
    function del(id) {
        $.post('/site/opt',{id:id,type:1},function(data){
            alert(data.msg);
            if(data.code == 1) {
                window.location.reload();
            }
        },'json');
    }
    function changeViewCount(key,id)
    {
        var view_count = parseInt($("#view_count_" + key).val());
        if(view_count != "" && view_count != 0) {
            $.post('/site/upd-view-count',{id:id,view_count:view_count},function(data){
            },'json');
        } 
    }
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks["js-block"], \yii\web\View::POS_HEAD); ?>
