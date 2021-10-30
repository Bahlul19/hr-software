<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportantContact[]|\Cake\Collection\CollectionInterface $importantContacts
 */
?>

<div class="importantContacts index large-9 medium-8 columns content">
<?php //echo $this->Form->create('searchAttendence',['id'=>'searchAttendence','type'=>'get']); 
?>
    <!-- <div class="row employees" style="padding: 20px;background-color: white;">
        <div class="col-md-6">
            <div class="form-group">
                <label for="search">Contact Type</label>
                <input type="text" name="searhc" id="search"  class="form-control" />
            </div>
        </div>    
       <div class="col-md-6" > 
           <br> -->
            <?php
             
              //  echo $this->Form->button(
                // 'Search', [
                    // 'type' => 'submit',
                    // 'class' => 'btn btn-info',
                    // 'id'=>'attendenceSearch',
                    // 'templates' => [
                        // 'inputContainer' => '{{content}}'
                    // ],
                    // 'data-toggle' => 'tooltip',
                    // 'data-original-title' => 'Search'
                // ]
            //); 
            ?>
            <?php //echo $this->Form->end(); 
            ?>
        <!-- </div> 
    </div> -->
    <div class="row contacts">
    <div class="col-lg-12 remove-padding">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">contact List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="emp-list-table">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('name_of_contact','Name of Contact') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('contact_no','Contact Number') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('type','Contact Type') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('description','Description') ?></th>
                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($importantContacts as $key => $contact): ?>
                                    <tr>
                                    <?php 
                                    $page_no=$this->request->query('page');?>
                                        <td><?= ($key+1)+($page_no*10) ?></td>
                                        <td><?= h($contact->name_of_contact) ?></td>
                                        <td><?= h($contact->contact_no) ?></td>
                                   
                                        <td><?=  $contact->type==1 ? "Mobile": "Landline" ?></td>
                                        <td><?= h($contact->description) ?></td>
                                        <td class="actions">
                                            <?= $this->Html->link(__('View'), ['action' => 'view', $contact->id]) ?>
                                           <?php  if($roleId<4){
                                               ?>
                                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contact->id]) ?>
                                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contact->id], ['confirm' => __('Are you sure you want to delete this contact')]) ?>
                                           <?php }?>
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
