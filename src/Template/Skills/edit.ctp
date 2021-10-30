<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Skill $skill
 */
?>
<br>
<div class="row">
    <div class="col-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?php echo "Add skils"; ?></h4>
            </div>
            <div class="card-body wizard-content">
            <?= $this->Form->create($skill,['type'=>'file','id'=>'skils']) ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo $this->Form->control('skill_name',['class'=>'form-control','label'=>'Skill Name*','placeholder'=>'skill name','pattern'=>"([a-zA-Z0-9 ])*$"]);
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
                            <?php  echo $this->Form->control('skill_level_ids',['class'=>'form-control','value'=>explode(",",$skill->skill_level_ids),'id'=>'skill-level-id','label'=>'Skill Levels Applicable*','multiple'=>"multiple",'options'=>$levels]);
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

                            <?php //echo $this->Form->control('image',['type'=>'file','class'=>'form-control','label'=>'choose an image for this skill']);
                            ?>
                            <input type="hidden" value="<?php // $skill->image?>" name="imagepath"/>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $this->Form->button(__('Submit'),['class' => 'btn btn-info']) ?>
                        <?= $this->Form->end() ?>
                    </div>
                    <div class="col-md-6">
                     <?php if(!empty($skill->image) && $skill->image!=""){  
                                    $imagePath=str_replace("\\","/",$skill->image);?>
                                <?= $this->Html->image($imagePath,['id'=>'image-path','style'=>'width:400px;height:200px;']) ?>
                   
                            <?php }else{ ?>
                                <img src="" id='image-path'/> 
                            <?php } ?>   
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

