<div class="row employees" id="policy">
    <div class="col-lg-12 no-padding">
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
                                <td><?php
                                switch ($policy->office) {
                                    case 'All-Offices':
                                        echo 'All-Offices';
                                        break;
                                    case 'SYL':
                                        echo "Sylhet";
                                        break;
                                    case 'DHK':
                                            echo "Dhaka";
                                        break;
                                    case 'UKR':
                                            echo "Ukraine";
                                        break;
                                    case 'GOA':
                                            echo "Goa";
                                        break;
                                    case 'NYC':
                                            echo "New York";
                                        break;
                                        
                                }
                                  ?></td>
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
                               if ($role == 1 || $role == 2) {
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
                                }
                                if ($role == 1) {
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
                    <?php
                    if ($role == 1 || $role == 2){
                        echo $this->Html->link(
                            __(
                                $this->Html->tag('', 'Create Policy')
                            ),
                            ['action' => 'add',],
                            ['class'=>'btn btn-primary'],
                            ['escape' => false,]
                        );
                    }
                    ?>
                    <?php
//                    if ($role == 1 || $role == 2){
//                        echo $this->Html->link(
//                            __(
//                                $this->Html->tag('', 'Pending ('.$pendingNumber.' )')
//                            ),
//                            ['action' => 'pending',],
//                            ['class'=>'btn btn-primary'],
//                            ['escape' => false,]
//                        );
//                    }
                    ?>
                    <?php echo $this->element('pagination'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
