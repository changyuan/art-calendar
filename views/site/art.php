<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = '管理演出';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="art-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="art-search">

    <?php $form = ActiveForm::begin([
        'action' => ['art'],
        'method' => 'post',
        'options'  =>['class'=>'form-inline']
    ]); ?>
    <div class="form-group">
        <label for="">名称</label>
        <input type="text" class="form-control" name="name" value="<?=$name;?>" placeholder="请输入演出名称">
    </div>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<div class="cal-container">
<?php if (!empty($art_infos)): ?>
    <?php foreach ($art_infos as $key => $value): ?>
        <div class="row">
          <div class="col-xs-12 col-md-4"><?=$value['name'];?></div>
          <div class="col-xs-12 col-md-4">
                <img src="<?=$value['member']['avatar'];?>" width="40px" height="40px"/> <span><?=$value['member']['nickname'];?></span>
          </div>
          <div class="col-xs-12 col-md-4">
            <?= Html::a('删除', 'javascript:void(0);',['class'=>"btn btn-warning",'onclick'=>"del($value[id])"]) ?>
          </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
</div>
    
</div>

<?php $this->beginBlock("js-block") ?>
    function del(id) {
        $.post('/site/opt',{id:id,type:2},function(data){
            alert(data.msg);
            if(data.code == 1) {
                window.location.reload();
            }
        },'json');
    }
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks["js-block"], \yii\web\View::POS_HEAD); ?>
