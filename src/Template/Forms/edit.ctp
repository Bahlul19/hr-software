<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Form $form
 */
$feedbackFor=0;
if(!empty($feedback_for_employee)){
  $feedbackFor=1;
}else{
    $feedbackFor=2;
}
?>
<div class="row forms">
    <div class="col-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?= __('Edit Form') ?></h4>
            </div>
            <div class="card-body">
                  <input type="hidden" id="editpage" value="1" />
                <?= $this->Form->create($form,['id'=>'edit-form']) ?>
                 <input type="hidden" value="<?= $form['id'] ?>" id="form" />
                 <input type="hidden" value="<?=$feedbackFor ?>" id="role-type"/>
                <section>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= $this->Form->control('title', [
                                        'type'=>'text',
                                        'label' => [
                                                'text'=>'Title*',
                                                'class' => 'control-label'
                                            ],
                                        'class' => 'form-control',
                                        'pattern'=>'[a-zA-Z0-9 ]+$',
                                        'required'=>true,
                                        'id'=> 'title'
                                    ]); 
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= $this->Form->control('slug', [
                                        'label' => [
                                                'text'=>'Slug*',
                                                'class' => 'control-label'
                                            ],
                                        'class' => 'form-control',
                                        'required'=>true,
                                        'readonly'=>true
                                    ]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= $this->Form->control('description', [
                                        'label' => [
                                                'text'=>'Description*',
                                                'class' => 'control-label'
                                            ],
                                        'class' => 'form-control',
                                        'required'=>true,
                                        'pattern'=>'[a-zA-Z0-9.,-\'" ]+$',
                                        'id'=>'description'
                                    ]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= $this->Form->control('access_roles', [
                                        'options' => $roles,
                                        'label' => [
                                            'text' => 'Feedback For Roles*',
                                            'class' => 'control-label'
                                        ],
                                        'class' => 'form-control',
                                        'id'=>'access-roles',
                                        'multiple' => 'multiple',
                                        'value' => $feedback_for_role,
                                        'required'=>true,
                                    ]); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= $this->Form->control('feedback_for', [
                                        'options' => $employees,
                                        'label' => [
                                            'text' => 'Feedback For Employees*',
                                            'class' => 'control-label'
                                        ],
                                        'class' => 'form-control',
                                        'id'=>'feedback-for', 
                                        'multiple' => true,
                                        'value' => $feedback_for_employee,
                                        'required'=>true,
                                    ]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="form-status">Status</label>
                                <div class="radio-blocks">
                                    <?php
                                        echo $this->Form->radio(
                                            'status',[
                                                '1' => 'Active',
                                                '0' => 'Inactive'
                                            ],
                                            [
                                                'default' => '1',
                                                'label' => [
                                                    'class' => 'radio-inline'
                                                ],
                                                'value'=>$form['status'],
                                                'required'=>true
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label class='control-label'>Form Available From*</label>
                              <input type="date" name='available_from'  min="<?= date("Y-m-d",strtotime($form['created'])) ?>" max="2999-12-31" value="<?=  date("Y-m-d",strtotime($form['available_from'])) ?>" class ='form-control' id='available-from'  required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class='control-label'>Form Available To*</label>
                              <input type="date" name='available_to'  min="<?= date("Y-m-d",strtotime($form['created'])) ?>" max="2999-12-31" value="<?= date("Y-m-d",strtotime($form['available_to'])) ?>" class ='form-control' id='available-to'  required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= $this->Form->control('available_for', [
                                        'options' => $roles,
                                        'label' => [
                                            'text' => 'Form Available To*',
                                            'class' => 'control-label'
                                        ],
                                        'class' => 'form-control',
                                        'id'=>'available_roles',
                                        'multiple' => 'multiple',
                                        'value'=>$available_for,
                                        'required'=>true
                                    ]); ?>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="form-actions">
                    <?php
                        echo $this->Form->button(__('Save'), ['class' => 'btn btn-info mr-1']);
                        echo $this->Html->link(
                            __('Back'),
                            ['action' => 'index'], ['class' => 'btn btn-inverse']
                        );
                    ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
<?=  $this->Html->script('../dist/js/jquery.min'); ?>
<?= $this->Html->script('../js/jquery-ui.min.js'); ?>
<script src="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"></script> 
 <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
 <?= $this->Html->script('../js/formBuilder/form-builder-code.js'); ?>
