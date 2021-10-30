<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HubstuffHour[]|\Cake\Collection\CollectionInterface $hubstuffHours
 */
?>
<div class="hubstuffHours index large-9 medium-8 columns content">
<div id="loader" style="display:none;width: 75vw;height: 20vw;position: absolute;z-index: 100;text-align: center;line-height: 18px;">     
        <img src="/img/spinner.gif" style="width: 100px;height: 100px;margin-top: 70px;" alt="">
</div>
<?php echo $this->Form->create('searchAttendence',['id'=>'searchAttendence','type'=>'get']); ?>
        <div class="row employees" style="padding: 20px;background-color: white;">
        <?php if($roleid<4) { ?>
            <div class="col-md-6">
                <div class="form-group">
                        <label for="emploee">Select Office</label>
                        <select name="office_location" id="office_lctn" class="form-control" value="<?= $office_location ?>">
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
                        <select name="emploees" id="emploees"  class="form-control">
                        </select>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="from-date">From Date</label>
                    <input type="date" name="from-date" id="from-date" value="<?= $fromDate ?>"  class="form-control" max=<?= date("Y-m-d") ?> />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="to-date">To Date</label>
                    <input type="date" name="to-date" id="to-date" value="<?= $toDate ?>" class="form-control" max=<?= date("Y-m-d") ?> />
                </div>
            </div>
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
                                    <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('member') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('task_id') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('time') ?></th>
                                    <th scope="col"><?= ('activity') ?></th>
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

                                <?php foreach ($HubstaffHours as $key => $hubstaffHour):?>
                                    <tr>
                                        <?php 
                                            $avgActivity=0;
                                            $activities=$hubstaffHour['concat_activity'];
                                            $activities=explode(",",$activities);
                                            $actvityCount=count($activities); 
                                            if($actvityCount>1){
                                                foreach($activities as $activity){
                                                    $act=explode("%",$activity);
                                                  
                                                    $avgActivity+=(int)$act[0];
                                                }
                                                $avgActivity/=$actvityCount;
                                                $avgActivity.="%";
                                            }else{
                                                $avgActivity=$hubstaffHour['concat_activity'];
                                            }
                                            
                                        ?>
                                        <td><?= $currentPage+($key+1)  ?></td>
                                        <td><?= date("d-m-Y",strtotime($hubstaffHour->date)) ?></td>
                                        <td><?= h($hubstaffHour->member) ?></td>
                                        <td><?= $this->Number->format($hubstaffHour->task_id) ?></td>
                                        <td><?= date('H:i:s',strtotime($hubstaffHour->timeSum)) ?></td>
                                        <td><?= h($avgActivity) ?></td>
                                        <td class="actions">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', date("Y-m-d",strtotime($hubstaffHour->date)),$hubstaffHour->member]) ?>
                                         <?php if($roleid<4) : ?>
                                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $hubstaffHour->id]) ?>
                                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $hubstaffHour->id], ['confirm' => __('Are you sure you want to delete this record?', $hubstaffHour->id)]) ?>
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
