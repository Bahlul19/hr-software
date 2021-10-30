<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Form[]|\Cake\Collection\CollectionInterface $forms
 */
?>
<div class="row forms">
   <div class="col-lg-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Forms</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="forms-list-table">
                    <table cellpadding="0" cellspacing="0" class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('slug') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                                <!-- <th scope="col"><?= $this->Paginator->sort('created') ?></th> -->
                                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                <th scope="col"><?= 'Form Fields' ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($forms as $key => $form): ?>
                            <tr>
                                <td><?= ($key+1) ?></td>
                                <td><?= h($form->title) ?></td>
                                <td><?= h($form->description) ?></td>
                                <td><?= h($form->slug) ?></td>
                                <td><?= $form->status ==1 ? 'Active':'Inactive' ?></td>
                                <!-- <td><?= h($form->created) ?></td> -->
                                <td><?= h($form->modified) ?></td>
                                <td>
                                    <?= $this->Html->link(__(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10'))
                                            ),  ['controller' => 'Forms', 'action' => 'formView',$form['slug']],[
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'View'
                                            ]) ?>
                                    <?= $this->Html->link(__(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10'))
                                            ), ['controller'=> 'FormFields','action' => 'edit-field', $form->id],
                                            [
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'Edit'
                                            ]) ?>
                                </td>
                                <td class="actions">
                                    <!-- <?= $this->Html->link(__(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10'))
                                            ), ['action' => 'view', $form->id],[
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'View'
                                            ]) ?> -->
                                    <?= $this->Html->link(__(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10'))
                                            ), ['action' => 'edit', $form->id],
                                            [
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'Edit'
                                            ]) ?>
                                    <?= $this->Form->postLink(__(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-trash text-inverse m-r-10'))
                                            ), ['action' => 'delete', $form->id], 
                                            [   'confirm' => __('Are you sure you want to delete this form?', $form->id),
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'Delete'
                                            ]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php echo $this->element('pagination'); ?>
                    <!-- <div class="paginator">
                        <ul class="pagination">
                            <?= $this->Paginator->first('<< ' . __('first')) ?>
                            <?= $this->Paginator->prev('< ' . __('previous')) ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next(__('next') . ' >') ?>
                            <?= $this->Paginator->last(__('last') . ' >>') ?>
                        </ul>
                        <p>
                        <?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
                    </div> -->
</div>
<?=  $this->Html->script('../dist/js/jquery.min'); ?>
<?= $this->Html->script('../js/jquery-ui.min.js'); ?>
<script src="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"></script> 
 <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
 <?= $this->Html->script('../js/formBuilder/form-builder-code.js'); ?>
