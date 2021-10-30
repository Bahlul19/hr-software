<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProcessDocumentation[]|\Cake\Collection\CollectionInterface $processDocumentations
 */
?>
<div class="processDocumentations index large-9 medium-8 columns content">
<div class="row leave-request">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Process Documentations Review</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover"> 
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('office') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('roles') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('Last Updated By') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('Last Updated') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($processDocumentations as $processDocumentation):  ?>
                        <tr>
                            <td><?= $this->Number->format($processDocumentation->id) ?></td>
                            <td><?= h($processDocumentation->title) ?></td>
                            <td><?php
                                  $result=[];
                                  $updatedStr = trim($processDocumentation->office,",");
                                  $officeArray=explode(',',$updatedStr);
                                  foreach($officeArray as $ar){
                                      $result[]=$Locations[$ar];    
                                  }

                                 echo implode(',<br>',$result);
                             ?></td>
                            <td><?php 
                                    $result=[];
                                    $updatedStr = trim($processDocumentation->roles,",");
                                    $rolesArray=explode(',',$updatedStr);
                                    foreach($rolesArray as $ar){
                                        $result[]=$allDepartment[$ar];    
                                    }     
                                   echo implode(',<br>',$result);
                                 ?></td>
                            <td ><?php 
                                        if(!empty($processDocumentation->employee)){
                                           echo $processDocumentation->employee->first_name." ".$processDocumentation->employee->last_name ;
                                            }
                                ?></td>
                                <td><?= h($processDocumentation->modified) ?></td>

                            <td><?= h($processDocumentation->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $processDocumentation->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $processDocumentation->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $processDocumentation->id], ['confirm' => __('Are you sure you want to delete this process ?', $processDocumentation->id)]) ?>
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
