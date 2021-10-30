<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Skill $skill
 */
?>
<br>
<div class="row">
    <div class="col-8 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?php echo "Add skills"; ?></h4>
            </div>
            <div class="card-body wizard-content">
            <?= $this->Form->create($skill,['type'=>'file','id'=>'skils']) ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo $this->Form->control('skill_name',['class'=>'form-control','id'=>'skill-name','label'=>'Skill Name*','placeholder'=>'skill name','pattern'=>"([a-zA-Z0-9 ])*$"]);
                            ?>
                        </div>
                  </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <?php  echo $this->Form->control('skill_category_id',['class'=>'form-control','id'=>'skill-category-id','label'=>'Skill category','options'=>$categories,'empty'=>'select category','required'=>true]);
                            ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                                <div class="form-group">
                                    <?php  echo $this->Form->control('skill_level_ids',['class'=>'form-control','id'=>'skill-level-id','label'=>'Skill levels applicable*','multiple'=>"multiple",'options'=>$levels,'data-placeholder'=>'select levels']);
                                    ?>
                                </div>
                            </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo $this->Form->control('version',['class'=>'form-control','placeholder'=>'version of you skill incase of software, eg: 1.3.1','pattern'=>"([0-9]{0,2}[.]{0,1})*$"]);
                            ?>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <?php //echo $this->Form->control('image',['type'=>'file','class'=>'form-control','label'=>'choose an image for this skill','accept'=>'.jpg,.png']);
                            ?>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $this->Form->button(__('Submit'),['class' => 'btn btn-info','id'=>'skill-submit','disabled'=>true]) ?>
                        <?= $this->Form->button(__('Reset Form'),['type'=>'button','id'=>'reset-form','class' => 'btn btn-info']) ?>
                        <?= $this->Form->end() ?> 
                    </div>
                    <div class="col-md-6">
                       <img src="" id='image-path'/> 
                    </div>
                  </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?php echo "All Added Skills"; ?></h4>
            </div>
            <div class="card-body wizard-content skills-body-main">
                <div id="accordion">
                    <?php

                    foreach($allSkills as $key => $value){ ?>
                        <div class="card skills-card-main">
                            <div class="card-header category-line collapsed" id=<?php echo "heading".$key ?>>
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target=<?php echo "#collapse".$key ?> aria-expanded="true" aria-controls=<?php echo "collapse".$key ?>>
                                <?= h($key) ?>
                                </button>
                            </h5>
                            </div>

                            <div id=<?php echo "collapse".$key ?> class="card-block collapse skills-list" aria-labelledby=<?php echo "heading".$key ?> data-parent="#accordion">
                            <div class="card-body">
                            <ol>
                                <?php
                                 foreach($value as $skill){
                                ?>

                                        <li>
                                            <?= h($skill) ?>
                                        </li>

                                <?php
                                 }
                                ?>
                            </ol>
                            </div>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

