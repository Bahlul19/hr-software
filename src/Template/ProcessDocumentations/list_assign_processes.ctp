<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProcessDocumentation[]|\Cake\Collection\CollectionInterface $processDocumentations
 */
?>
<div class="AssignProcesses index large-9 medium-8 columns content">
<br>
        <?php echo $this->Form->create(false, ['type' => 'GET']); ?> 
           <div class="row"> 
           <?php if($roleId<4){ ?>
                <div class="col-md-12 search">
                    <div class="input-group">
                    <div class="input-group-addon">
                        <i class="ti-search"></i>
                    </div>  
                        <?php 
                            echo $this->Form->select('employee',$allEmployees,['class'=>'form-control','id'=>'search','empty'=>'Select employee']); 
                        ?> 
                      
                    </div>
                </div> 
             <?php }?>
        <div class="col-md-6 search">
                    <div class="input-group">
                    <div class="input-group-addon">
                        <i class="ti-search"></i>
                    </div>
                        <?php 
                            echo $this->Form->select('search',$allsearch,['class'=>'form-control','id'=>'employee','empty'=>'Search assigned tasks']); 
                        ?>
                          &nbsp;&nbsp;&nbsp;
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
            </div>
            <div class="col-md-6 search">
                <?php 
                    if($roleId<4){ ?>
                            <input type='submit' name='my_processes' value='Show My Processes'  class='btn btn-primary'/>
                            <input type='submit' name='others_processes' value='Show Assigned Processes' class='btn btn-success' />        
                <?php 
                     }
                echo $this->Form->end(); ?>
            </div>
    </div>
<div class="row leave-request">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Processes Assigned To Employees</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover"> 
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id','id') ?></th>
                            <th scope="col"><?= ('Employee') ?></th>
                            <th scope="col"><?= ('office') ?></th>
                            <th scope="col"><?= ('Department') ?></th>
                            <th scope="col"><?= ('Process Name') ?></th>
                            <th scope="col"><?= ('Status') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('created','created') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $pageNo=(int)$this->request->getQuery('page'); 
                            if($pageNo==null){
                                $pageNo=1;
                            }
                            $currentPage=20*($pageNo-1); 
                        ?>
                        <?php foreach ($AssignProcesses as $key => $AssignProcesse):?>
                        <tr>
                            <td><?= $currentPage+($key+1)  ?></td>
                            <td><?= $AssignProcesse->employee->first_name."  ".$AssignProcesse->employee->last_name?></td>
                            <td><?= $allLocations[$AssignProcesse->employee->office_location]?></td>
                            <td><?= $allDepartment[$AssignProcesse->employee->department_id] ?></td>
                            <td><?= $AssignProcesse->process_documentation->title ?></td>
                            <td><?php 
                                        if($AssignProcesse->status == 1){
                                            echo 'Assigned';
                                        }else if($AssignProcesse->status == 2){
                                            echo "Ongoing";
                                        }else{
                                            echo 'Completed';
                                        } 
                                ?></td>
                            <td><?php echo $AssignProcesse->created ?></td>
                            <td class="actions">
                            <?php if($AssignProcesse->status !== 3):?>
                                    <?= $this->Html->link(__('View'), ['action' => 'view_assigned_process', $AssignProcesse->id]) ?>
                                <?php if($roleId<4) : ?>
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete_assigned_process', $AssignProcesse->id], ['confirm' => __('Are you sure you want to delete this assigned task ?', $AssignProcesse->id)]) ?>
                                <?php endif; ?>
                            <?php endif; ?>
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