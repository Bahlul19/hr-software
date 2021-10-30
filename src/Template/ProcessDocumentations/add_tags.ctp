<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\tags $processDocumentation
 */
?>
<div class="tags form large-9 medium-8 columns content">
<br>
<?= $this->Form->create($tags,['type' => 'POST','id'=>'addtags','class'=>'tagForm']) ?>
    <div class="row" id="main-container">
        <div class="col-md-12">
           <div class="form-group">
                    <?php echo $this->Form->control(
                         'name',[
                             'type'=>'text',
                             'class' => 'form-control',
                             'label' => 'Add Tags',
                             'id'    => 'tag',
                             'placeholder'=>'New Tags'
                         ]);
                    ?>
           </div>
       </div>
    </div>
    <?= $this->Form->button(__('Add Tag'),['class'=>'btn btn-primary','id'=>'processsubmit']) ?>
    <?= $this->Form->end() ?> <br>
    <div id='alltags'>
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Process Documentations</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover"> 
                        <thead>
                        <th>Id</th>
                        <th>Tag Name</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($allTags as $key => $singletag){ 
                                        ?>
                                        <tr>
                                            <td><?=($key+1)?></td>
                                            <td><?= $singletag['name'] ?></td>
                                            <td class="actions">
                                                <?= $this->Html->link(__('Edit'), ['action' => 'edit_tags', $singletag->id]) ?>
                                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete_tags', $singletag->id], ['confirm' => __('Are you sure you want to delete this tag ?', $singletag->id)]) ?>
                                            </td>
                                        </tr>
                            <?php  } ?>   
                            </tbody>    
                    </table>  
                </div>
            </div>   
        </div>               
    </div>
</div>