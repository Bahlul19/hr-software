<div class="hubstuffHours form large-9 medium-8 columns content">
  <br>
    <?= $this->Form->create('Update Hubstaff Name',['id'=>'UpdateName','class'=>'updatename']) ?>
    <fieldset>
        <legend><?= __('Edit Hubstuff Hour') ?></legend>
    </fieldset>
       <div class="row">
       <br>
       <br>
            <div class='col-md-12'>
                 <div class="form-group">
                     <input type="text" class="form-control"  value="<?php echo $employees->first_name."  ".$employees->last_name;  ?>" name="e_name" readonly/>
                 </div>   
            </div>
            <div class='col-md-12'>
                <div class="form-group">
                    <input type="text"  class="form-control" value="<?php echo $employees->hubstaff_name;  ?>" name="hubstaff_name"  id="name" placeholder="Employee Hubsatff Name" required/>
                </div>
            </div>
        </div>
        <?php
             echo $this->Form->button(
             'Save', [
                 'type' => 'submit',
                 'class' => 'btn btn-info right-align',
                 'id'=>'updatehubstaffname',
                 'templates' => [
                     'inputContainer' => '{{content}}'
                 ],
                 'data-toggle' => 'tooltip',
                 'data-original-title' => 'save'
             ]); 
        ?>

    <?= $this->Form->end() ?>
</div>
