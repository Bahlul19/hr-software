<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Skill[]|\Cake\Collection\CollectionInterface $skills
 */
?>
<br>
<div class="skills index large-9 medium-8 columns content">
  <div class="row contacts">
    <div class="col-lg-12 remove-padding">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Search Skills </h4>
                </div>
                <div class="card-body">
                   <?= $this->Form->create('search_skills',['method'=>'GET']) ?>
                    <div class="row">
                         <div class="col-md-6">
                            <div class="form-group">
                            <?= $this->Form->control('selected_skill',['type'=>"text",'class'=>'form-control','label'=>'Skills','placeholder'=>'select a skill to search','value'=>$selectedSkill]) ?>
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="form-group">
                            <?= $this->Form->control('levels',['options'=>$levels,'empty'=>'select skill level','class'=>'form-control','title'=>'Skills Levels','value'=>$selectedLevels]) ?>
                            </div>
                         </div>
                    </div>
                    <?= $this->Form->button(__('Search'),['class' => 'btn btn-info']) ?>
                    <?= $this->Form->button(__('Show All'),['name'=>'showall','value'=>'all','class' => 'btn btn-info']) ?>
                   <?= $this->Form->end() ?>
                </div>
                <div class="card-body">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Skills</h4>
                    </div>
                    <div class="table-responsive" id="emp-list-table">
                        <table class="table table-hover datatable">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col" >Skill name</th>
                                    <th scope="col">skill category</th>
                                    <th scope="col">version</th>
                                    <!-- <th scope="col">Skill levels</th>
                                    <th scope="col">image</th> -->
                                    <th scope="col">created</th>
                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $pageNo=(int)$this->request->getQuery('page');
                                    if($pageNo==null){
                                        $pageNo=1;
                                    }
                                    $currentPage=20*($pageNo-1);
                                ?>
                                <?php foreach ($skills as $key => $skill):?>
                                <tr>
                                    <td><?= $currentPage+($key+1) ?></td>
                                    <?php $title=str_replace("\"","'",$skill->skill_name); ?>
                                    <td title="<?= $title ?>" ><?= strlen($skill->skill_name) >15 ? substr($skill->skill_name, 0, 15)."..." :$skill->skill_name ?></td>
                                    <td><?= h($skill['skill_category']['name'])  ?></td>
                                    <td><?= h($skill->version) ?></td>
                                    <!-- <td><?php
                                        //    $lvl=array();
                                        //    $arr=explode(",",$skill->skill_level_ids);
                                        //    foreach ($arr as $ky => $ar){
                                        //          $lvl[]=ucfirst($levels[$ar]);
                                        //    }
                                        //     echo implode(", ",$lvl);
                                        ?></td>

                                    <td><?php //$skill->image==""?(""):('<a href="'.$skill->image.'" target="_blank">View Image</a>'); ?></td> -->
                                    <td><?= h($skill->created) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $skill->id],['class'=>'view']) ?>
                                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $skill->id],['class'=>'edit']) ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['action' => 'delete', $skill->id], ['confirm' => __('Are you sure you want to delete # {0}?', $skill->id),'class'=>'delete','escape'=>false]) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php echo $this->element('pagination'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
