
<div class="hubstuffHours index large-9 medium-8 columns content">
    <div id="loader" style="display:none;width: 75vw;height: 20vw;position: absolute;z-index: 100;text-align: center;line-height: 18px;">     
        <img src="/img/spinner.gif" style="width: 100px;height: 100px;margin-top: 70px;" alt="">
    </div>
<?php echo $this->Form->create('searchEmployee',['id'=>'searchEmployee','type'=>'get']); ?>
        <div class="row employees" style="padding: 20px;background-color: white;">
        <?php if($roleid<4) { ?>
            <div class="col-md-6">
                <div class="form-group">
                        <label for="emploee">Select Office</label>
                        <select name="office_location" id="office_location" class="form-control" >
                            <option value="">Select Office</option>
                            <option value="NYC">NYC</option>
                            <option value="SYL">SYL</option>
                            <option value="GOA">GOA</option>
                            <option value="DHK">DHK</option>
                            <option value="UKR">UKR</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="emploees">Employee</label>
                        <select name="emploees" id="emploees" class="form-control">
                        </select>
                    </div>
                </div>
            <?php } ?>
            <?php
                echo $this->Form->button(
                'Search', [
                    'type' => 'submit',
                    'class' => 'btn btn-info right-align',
                    'id'=>'attendenceSearch',
                    'templates' => [
                        'inputContainer' => '{{content}}'
                    ],
                    'data-toggle' => 'tooltip',
                    'data-original-title' => 'Search'
                ]
            ); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    <div class="row contacts">
    <div class="col-lg-12 remove-padding">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">HubStuff Hours</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="emp-list-table">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('Employee Name') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('Employee Hubstaff Name') ?></th>
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
                                <?php foreach ($employees as $key => $employee):?>
                                    <tr>
                                        <td><?= $currentPage+($key+1)  ?></td>
                                        <td><?= h($employee->first_name." ".$employee->last_name) ?></td>
                                        <td><?= h($employee->hubstaff_name) ?></td>
                                        <td class="actions">
                                         <?php if($roleid<4) : ?>
                                            <?= $this->Html->link(__('Edit'), ['action' => 'edit_hubstaff_name', $employee->id]) ?>
                                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete_hubstaff_name', $employee->id], ['confirm' => __('Are you sure you want to delete this record?', $employee->id)]) ?>
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