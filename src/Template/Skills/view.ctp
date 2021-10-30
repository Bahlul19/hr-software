<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Skill $skill
 */
?>
<br>
<div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Skills details</h4>
            </div>
            <div class="card-body">
            <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <?= __('Skill Name :') ?>
                                            <?= h($skill->skill_name) ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                            <div class="form-group">
                            <?= __('Skill Category :') ?>
                                            <?= h($skill['skill_category']['name']) ?>
                                    </div>
                                </div>
                            <div class="col-md-12">
                            <div class="form-group">
                            <?= __('Skill Level :') ?>
                                        <?php
                                           $lvl=array();
                                           $arr=explode(",",$skill->skill_level_ids);
                                           foreach ($arr as $ky => $ar){
                                                 $lvl[]=$levels[$ar];
                                           }
                                            echo implode(",",$lvl);
                                        ?>
                                    </div>
                                </div>
                            <div class="col-md-6">
                            <div class="form-group">
                            <?= __('Version :') ?>
                                  <?= h($skill->version) ?>
                                     </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <?= __('Created :') ?>
                                 <?= h($skill->created) ?>
                                     </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">

                            <?= __('Image :')  ?><br><br>
                            <?php if(!empty($skill->image) && $skill->image!=""){  $imagePath=str_replace("\\","/",$skill->image);?>
                            <?= $this->Html->image($imagePath) ?>
                                     </div>
                           <?php }else{
                                ?>
                             <p>No image available</p>
                            <?php
                           } ?>
                        </div>
                </div>
            </div>
        </div>
    </div>


