<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeAttendance[]|\Cake\Collection\CollectionInterface $employeeAttendance
 */
?>
<?php if($optionAvail) { ?>
<div class="row employees">

    <div class="col-lg-6 search">
        <?php  echo $this->Form->create(false, ['type' => 'GET']); ?>
            <div class="input-group">
            <div class="input-group-addon">
                <i class="ti-search"></i>
            </div>
            <?php
                echo $this->Form->control(
                    'search', [
                        'templates' => [
                            'inputContainer' => '{{content}}'
                        ],
                        'required' => true,
                        'value' => !empty($keyword) ? $keyword : '',
                        'class' => 'form-control',
                        'id'    =>  'attendance-search',
                        'label' =>  ''
                    ]
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

                        if (!empty($keyword)) {
                            echo $this->Html->Link(
                                __(
                                    'Clear'
                                ),
                                ['action' => 'index'],
                                [
                                    'class' => 'btn btn-warning',
                                    'escape' => false,
                                    'data-toggle' => 'tooltip',
                                    'data-original-title' => 'Clear'
                                ]
                            );
                        }
                        ?>
                    </span>
                </div>
            <?php echo $this->Form->end(); ?>
        </div>
        <div class="col-lg-6 search">
            <div class="form-group">
                <select name="office_location" class="form-control office-location" id="office-location-emp-list" aria-required="true">
                    <option value="">Select Office</option>
                    <option value="NYC">NYC</option>
                    <option value="SYL">SYL</option>
                    <option value="GOA">GOA</option>
                    <option value="DHK">DHK</option>
                    <option value="UKR">UKR</option>
                </select>
            </div>
        </div>
    </div>
<?php } ?>

<div class="row employees">
   <div class="col-lg-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Weekly Attendance</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="emp-list-table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Day</th>
                                <th scope="col">Date</th>
                                <th scope="col"><?= $this->Paginator->sort('shift') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('checkin') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('checkout') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('ot_hours') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('hours_worked ') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                             $weekEnd = 1;
                             foreach ($weeklyData as $key => $weeklyDetail): ?>
                            <tr>
                            <?php  if(isset($weeklyDetail['data'])){ ?>
                                <td><?= h($weeklyDetail['day']) ?></td>
                                <td><?= h($weeklyDetail['data']->date) ?></td>
                                <td><?= h($weeklyDetail['data']->shift) ?></td>
                                <td><?php echo date('H:i:s a',strtotime($weeklyDetail['data']->checkin)); ?></td>
                                <td><?php echo date('H:i:s a',strtotime($weeklyDetail['data']->checkout)); ?></td>
                                <td><?= h($weeklyDetail['data']->extra_hours) ?></td>
                                <td><?= h($weeklyDetail['data']->hours_worked) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['action' => 'view', $weeklyDetail['data']->id]) ?>
                                    <?php if ($optionAvail == true) { ?>
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $weeklyDetail['data']->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $weeklyDetail['data']->id], ['confirm' => __('Are you sure you want to delete # {0}?', $weeklyDetail['data']->id)]) ?>
                                    <?php } ?>
                                </td>
                            <?php }else{ ?>
                                <td><?= h($weeklyDetail['day']) ?></td>
                                <td><?= h($key) ?></td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                            <?php } ?>
                            </tr>
                            <?php if($weeklyDetail['day'] == 'Sunday'){ ?>
                                <tr>
                                    <td colspan="6">Weekly Hours</td>
                                    <?php
                                        if(isset($weeklyTotalHours[$weekEnd])){ ?>
                                        <td class="<?php echo $weeklyTotalHours[$weekEnd]['color']; ?>">
                                           <?php echo $weeklyTotalHours[$weekEnd]['hours']; ?>
                                        </td>
                                        <?php }else{ ?>
                                            <td>---</td>
                                        <?php } ?>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="8"><hr></td>
                                </tr>
                            <?php
                            $weekEnd++;
                            } ?>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="6">Total Hours</td>
                                <td><?php echo $total_time; ?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
