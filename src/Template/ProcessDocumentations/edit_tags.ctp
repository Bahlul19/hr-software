<div class="tags form large-9 medium-8 columns content">
<br>
<?= $this->Form->create($tags,['type' => 'POST','id'=>'editTags','class'=>'tagForm']) ?>
    <div class="row" id="main-container">
        <div class="col-md-12">
           <div class="form-group">
                    <?php echo $this->Form->control(
                         'name',[
                             'type'=>'text',
                             'class' => 'form-control',
                             'label' => 'Add Tags',
                             'id'    => 'tag',
                             'placeholder'=>'New Tags',
                             'value'=> $tags->name
                         ]);
                    ?>
           </div>
       </div>
      
    </div>
    <?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary','id'=>'processsubmit']) ?>
    <?= $this->Form->end() ?> <br>