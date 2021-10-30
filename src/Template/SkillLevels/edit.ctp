<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SkillLevel $skillLevel
 */
?>
<br>
<div class="row">
    <div class="col-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?php echo "Add Skill Level"; ?></h4>
            </div>
            <div class="card-body wizard-content">
            <?= $this->Form->create($skillLevel) ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php  echo $this->Form->control('level_name',['type'=>'text','class'=>'form-control','pattern'=>"([A-Za-z]+[,]*)+",'placeholder'=>'add skill levels ,to add multiple seperate each one by comma e.g a,b,c ']);
                            ?>
                        </div>
                </div>
            </div>
            <?= $this->Form->button(__('Submit'),['class' => 'btn btn-info']) ?>
                <?= $this->Form->end() ?>
        </div>
    </div>
</div>

