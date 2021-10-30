<div class="row employees">
   <div class="col-lg-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Announcements</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('Announcements.title', 'Title'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Announcements.offices', 'Offices'); ?></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($announcements as $announcement): ?>
                                <tr>
                                   <td><?php echo h($announcement->title) ?></td>
                                   <td><?php echo (h($announcement->offices)); ?></td>
                                   <td class="actions">
                                        <?php
                                            echo $this->Html->link(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10 icon-designation'))
                                                ),
                                                ['action' => 'view', $announcement->id],
                                                [
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'View'
                                                ]
                                            );

                                            $role = array(1,2,3);
                                            if (in_array($loggedUser['role_id'], $role)) {
                                                echo $this->Html->link(
                                                    __(
                                                        $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10 icon-designation'))
                                                    ),
                                                    ['action' => 'edit', $announcement->id],
                                                    [
                                                        'escape' => false,
                                                        'data-toggle' => 'tooltip',
                                                        'data-original-title' => 'Edit'
                                                    ]
                                                );

                                                echo $this->Form->postLink(
                                                    __(
                                                        $this->Html->tag('i', '', array('class' => 'fa fa-trash text-inverse m-r-10 icon-designation'))
                                                    ),
                                                    ['action' => 'delete', $announcement->id],
                                                    [
                                                        'confirm' => __('Are you sure you want to delete {0}?', $announcement->announcement),
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
