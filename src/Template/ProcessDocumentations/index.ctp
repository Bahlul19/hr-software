<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProcessDocumentation[]|\Cake\Collection\CollectionInterface $processDocumentations
 */
?>
<div class="processDocumentations index large-9 medium-8 columns content">
<br>
    <h3><?= __('Process Documentations') ?></h3>
    <div class="col-lg-6 search">
        <?php echo $this->Form->create(false, ['type' => 'GET']); ?>
            <div class="input-group">
            <div class="input-group-addon">
                <i class="ti-search"></i>
            </div>
               <?php        
                   echo $this->Form->select(
                        'searchTags',$allTags,['class'=>'form-control','id'=>'searchTags','empty'=>'Search by tag']
                    ); 
                ?>
                <span class="input-group-btn">
                    <?php
                        echo $this->Form->button(
                            'Search', [
                                'type' => 'submit',
                                'class' => 'btn btn-info',
                                'templates' => [
                                    'inputContainer' => '{{content}}'
                                ],
                                'data-toggle' => 'tooltip',
                                'data-original-title' => 'Search'
                            ]
                        );
                        ?>
                </span>
            </div>
        <?php echo $this->Form->end(); ?>
    </div>
<div class="row leave-request">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Process Documentations</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover"> 
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('office') ?></th>
                           <?php if($roleId<4) :?>
                            <th scope="col"><?= $this->Paginator->sort('roles') ?></th>
                           <?php endif; ?>
                           <?php if($roleId<4) :?>
                            <th scope="col"><?= ('Last Updated By') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('modified','Last Updated') ?></th>
                           <?php endif; ?>
                            <th scope="col"><?= $this->Paginator->sort('created','Created') ?></th>
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
                        <?php foreach ($processDocumentations as $key=> $processDocumentation):  ?>
                        <tr>
                            <td><?= $currentPage+($key+1)  ?></td>
                            <td><?= h($processDocumentation->title) ?></td>
                            <td><?php
                                  $result=[];
                                  $updatedStr = trim($processDocumentation->office,",");
                                  $officeArray=explode(',',$updatedStr);
                                  foreach($officeArray as $key => $ar){
                                    if(!empty($Locations[$ar]))      
                                        $result[]=$Locations[$ar];    
                                  
                                }

                                 echo implode(',<br>',$result);
                             ?></td>
                            <?php if($roleId<4) :?>
                            <td style="height:100px;overflow-y:auto;"><?php 
                                    $result=[];
                                    $updatedStr = trim($processDocumentation->roles,",");
                                    $rolesArray=explode(',',$updatedStr);
                                    foreach($rolesArray as $ar){
                                        $result[]=$allDepartment[$ar];    
                                    }     
                                   echo implode(',<br>',$result);
                                endif;
                                 ?></td>
                            <?php if($roleId<4) :?>
                            <td ><?php 
                                        if(!empty($processDocumentation->employee)){
                                           echo $processDocumentation->employee->first_name." ".$processDocumentation->employee->last_name ;
                                            }
                                ?></td>
                                <td><?= h($processDocumentation->modified) ?></td>
                           <?php endif; ?>

                            <td><?= h($processDocumentation->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $processDocumentation->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $processDocumentation->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete/'.$processDocumentation->id],['confirm' => __('Are you sure you want to delete this Process?', $processDocumentation->id)]) ?>
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
