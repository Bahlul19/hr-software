<!--<div class="row" id="policy">-->
<!--    <div class="col-lg-12 search">-->
<!--        --><?php //echo $this->Form->create(false, ['type' => 'GET']); ?>
<!--        <div class="input-group">-->
<!--            <div class="input-group-addon">-->
<!--                <i class="ti-search"></i>-->
<!--            </div>-->
<!--            --><?php
//                echo $this->Form->control(
//           'search', [
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
<!--            <span class="input-group-btn">-->
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
//                                'Clear'
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
<!--            </span>-->
<!--        </div>-->
<!--        --><?php //echo $this->Form->end(); ?>
<!--    </div>-->
<!--</div>-->

<div class="row" id="policy">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Policy</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('office') ?></th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $id = 0;?>
                        <?php foreach ($policies as $policy): ?>
                        <?php $id++; ?>
                            <tr>
                                <td><?php echo $id; ?></td>
                                <td><?php echo h($policy->title) ?></td>
                                <td><?php echo h($policy->office) ?></td>
                                <td class="actions">
                                    <?php
                                    echo $this->Html->link(
                                        __(
                                            $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10'))
                                        ),
                                        ['action' => 'view', $policy->id],
                                        [
                                            'escape' => false,
                                            'data-toggle' => 'tooltip',
                                            'data-original-title' => 'View'
                                        ]
                                    );
                               if ($role == 1) {
                                    echo $this->Html->link(
                                        __(
                                            $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10'))
                                        ),
                                        ['action' => 'edit', $policy->id],
                                        [
                                            'escape' => false,
                                            'data-toggle' => 'tooltip',
                                            'data-original-title' => 'Edit'
                                        ]
                                    );
                                
                                   echo $this->Form->postLink(
                                       __(
                                           $this->Html->tag('i', '', array('class' => 'fa fa-trash text-inverse m-r-10'))
                                       ),
                                       ['action' => 'delete', $policy->id],
                                       [
                                           'confirm' => __('Are you sure you want to delete {0}?', $policy->title),
                                           'escape' => false,
                                           'data-toggle' => 'tooltip',
                                           'data-original-title' => 'Delete'
                                       ]
                                    );
                                }
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
