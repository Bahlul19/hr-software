<!--<div class="row department">-->
<!--    <div class="col-lg-12 search remove-padding">-->
<!--       --><?php //echo $this->Form->create(false, ['type' => 'GET']); ?>
<!--         <div class="input-group">-->
<!--            <div class="input-group-addon">-->
<!--                <i class="ti-search"></i>-->
<!--            </div>-->
<!--            --><?php
//                echo $this->Form->control(
//                    'search', [
//                        'templates' => [
//                            'inputContainer' => '{{content}}'
//                        ],
//                        'required' => true,
//                        'value' => !empty($keyword) ? $keyword : '',
//                        'class' => 'form-control',
//                        'id'    =>  'search',
//                        'label' =>  ''
//                    ]
//                );
//            ?>
<!--             <span class="input-group-btn">-->
<!--                --><?php
//                    echo $this->Form->button(
//                        'Search', [
//                            'type' => 'submit',
//                            'class' => 'btn btn-info',
//                            'templates' => [
//                                'inputContainer' => '{{content}}'
//                            ],
//                            'data-toggle' => 'tooltip',
//                            'data-original-title' => 'Search'
//                        ]
//                    );
//
//                    if (!empty($keyword)) {
//                        echo $this->Html->Link(
//                            __(
//                               'Clear'
//                            ),
//                            ['action' => 'index'],
//                            [
//                                'class' => 'btn btn-warning',
//                                'escape' => false,
//                                'data-toggle' => 'tooltip',
//                                'data-original-title' => 'Clear'
//                            ]
//                        );
//                    }
//                ?>
<!--                </span>-->
<!--         </div>-->
<!--         --><?php //echo $this->Form->end(); ?>
<!--    </div>-->
<!--</div>-->

<div class="row department">
   <div class="col-lg-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Department</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('name') ?></th>
                                    <th><?php echo $this->Paginator->sort('lead') ?></th>
<!--                                    <th>--><?php //echo $this->Paginator->sort('no_of_employees') ?><!--</th>-->
                                    <th><?php echo $this->Paginator->sort('status') ?></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($departments as $department): ?>
                                <tr>
                                   <td><?php echo h($department->name) ?></td>
                                   <td><?php echo h($department->lead) ?></td>
<!--                                   <td>--><?php //echo h($department->no_of_employees) ?><!--</td>-->
                                   <td><?php echo (h($department->status)==1 ? 'active' : 'inactive') ?></td>
                                   <td class="actions">
                                        <?php
                                            echo $this->Html->link(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10 dept-icon'))
                                                ),
                                                ['action' => 'view', $department->id],
                                                [
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'View'
                                                ]
                                            );

                                            echo $this->Html->link(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10 dept-icon'))
                                                ),
                                                ['action' => 'edit', $department->id],
                                                [
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'Edit'
                                                ]
                                            );

                                            echo $this->Form->postLink(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-trash text-inverse m-r-10 dept-icon'))
                                                ),
                                                ['action' => 'delete', $department->id],
                                                [
                                                    'confirm' => __('Are you sure you want to delete {0}?', $department->name),
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'Delete'
                                                ]
                                            );
                                        ?>
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
