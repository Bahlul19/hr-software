<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FormSubmission[]|\Cake\Collection\CollectionInterface $formSubmissions
 */
?>
<div class="row formSubmissions">
   <div class="col-lg-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Forms Submitted</h4>
            </div>
            <?php echo $this->Form->create(false, ['type' => 'GET']); ?>
            <div class="row"> 
                <div class="col-sm-offset-1"></div>
                <div class="col-md-5 search">
                    <?php if($loggedUserRole !=4) { ?>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="ti-search"></i>
                                </div>
                                <?php
                                echo $this->Form->control(
                                    'keyword', [
                                        'templates' => [
                                            'inputContainer' => '{{content}}'
                                        ],
                                        // 'required' => true,
                                        'class' => 'rmfo-control emp-list-leave-report',
                                        'empty' => 'Select Employee',
                                        'options' => $employeesList,
                                        'label' =>  ''
                                    ]
                                );
                                ?>
                            &nbsp;
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
                                <?php } ?>
                              </div>
                              <div class="col-md-7">
                                  <br>
                                  <?php if($loggedUserRole !=4) { ?>
                                      <span class="input-group-btn">
                                        <?php if (!empty($keyword)) {
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
                                        }?>
                                        </span>
                                        <input type='submit' name='show_my' value='My Response'  class='btn btn-info' />
                                    <?php }
                                    ?>
                                
                          <input type='submit' name='show_all' value='Show All'  class='btn btn-success' />
                          <input type='submit' name='my_response' value='Responses for Me'  class='btn btn-primary'/> 
                </div>
            </div>  
            <?php echo $this->Form->end(); ?>
            <div class="card-body">
                <div class="table-responsive" id="forms-list-table">
                    <table cellpadding="0" cellspacing="0" class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('form_id') ?></th>
                                <!-- <th scope="col"><?php // $this->Paginator->sort('employee_id') ?></th> -->
                                <th scope="col"><?= $this->Paginator->sort('feedback_for') ?></th>
                                <?php if($loggedUserRole !=4 && empty($this->request->getQuery("my_response"))  && empty($this->request->getQuery("show_my")) ) { ?> 
                                <th scope="col"><?= $this->Paginator->sort('is_visible') ?></th>
                                <?php } ?>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody id="submission-table"> 
                            <?php foreach ($formSubmissions as $key => $formSubmission): ?>
                            <tr>
                                <td><?= ($key+1) ?></td>
                                <td>
                                    <?php echo ($formSubmission->form->title);  ?>
                                </td> 
                                <!-- <td><?php // $formSubmission->employees_a->first_name. ' '.$formSubmission->employees_a->last_name ?></td> -->
                                <td><?= $formSubmission->feedback_for==null ? "" : ($formSubmission->employees_b->first_name. ' '.$formSubmission->employees_b->last_name) ?></td>
                                <?php if($loggedUserRole !=4) { ?>
                                <?php 
                                  $visible=$formSubmission->is_visible==0 ? "No":"Yes";
                                ?>
                                    <?php if(empty($this->request->getQuery("my_response")) && empty($this->request->getQuery("show_my"))){ ?>
                                        <td>
                                            <input type="checkbox" 
                                                data-submission=<?= $formSubmission->id?> 
                                                value="<?= $formSubmission->is_visible ?>" 
                                                <?= ($formSubmission->is_visible==1) ? ("checked=checked"):""  ?> 
                                                style="position: initial;left: 0px;opacity: 1;" />&nbsp;<span><?= $visible ?></span>
                                        </td>
                                    <?php } ?>
                                <?php } ?>
                                <td><?= h($formSubmission->created) ?></td>
                              
                                <td class="actions">
                                    <?= $this->Html->link(__(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10'))
                                            ), ['action' => 'view', $formSubmission->id],[
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'View'
                                            ]) ?>
                                      <?php if(empty($this->request->getQuery("my_response"))){?> 
                                    <!-- <?= $this->Html->link(__('Edit'), ['action' => 'edit', $formSubmission->id]) ?> -->
                                    <?= $this->Form->postLink(__(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-trash text-inverse m-r-10'))
                                            ), ['action' => 'delete', $formSubmission->id], ['confirm' => __('Are you sure you want to delete this form submission ?', $formSubmission->id),
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'Delete']) ?>
                                    <?php  } ?>
                                </td>
                                
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= $this->element('pagination'); ?>
                </div>
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

