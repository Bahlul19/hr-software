<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeSkill $employeeSkill
 */
?>
<div class="row">
    <div class="col-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?php echo "Add skils"; ?></h4>
            </div>
            <div class=" employeeSkills card-body wizard-content">
                <?= $this->Form->create($employeeSkill) ?>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Skill</label>
                    </div>
                    <div class="col-md-2">
                       <label>Skill Level</label>
                    </div>
                    <div class="col-md-2">
                        <label>Start Date</label>
                    </div>
                    <div class="col-md-2">
                        <label>End date</label>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <?= $this->Form->control('employeeSkill.0.skill_id', ['label'=>false,'onchange'=>"getlevel('0');",'class' => 'form-control skills-cat','id'=>'skill-select-0','required'=>'required','type'=>'select','options'=>$skills,'empty'=>'Choose']);?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('employeeSkill.0.skill_level_id', ['label'=>false,'onchange'=>"checkval('0');",'class' => 'form-control','id'=>'skill-levels-0','required'=>'required','type'=>'select','empty'=>'Choose']);?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('employeeSkill.0.from_date', ['label'=>false,'type' => 'text','class' =>'form-control skilldatepicker','id' => 'from_date','autocomplete' => 'off','required' => 'true']);?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('employeeSkill.0.to_date', ['label'=>false,'type' => 'text','class' =>'form-control skilldatepicker','id' => 'to_date','autocomplete' => 'off','required' => 'true']);?>
                    </div>
                    <div class="col-md-2">
                        <button class="btn" id="btn-0" onclick="add(0);"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="row mb-3 ml-1"><div id="error-0"></div></div>
                <div id="replace"></div>
                <?= $this->Form->button(__('Submit'),['class' => 'btn btn-info']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
<script>
    function add(num){
    var newRowNum = num + 1;
    var skills = <?php echo json_encode($skills); ?>;
    console.log(skills);
    var skillOp = '';

    $.each(skills, function(key, value){
        skillOp +='<optgroup label="' + key + '" />';
        $.each(value, function(key,value){
            skillOp +='<option value="'+ key +'">'+ value +'</option>';
        });

    });
    pass(num,newRowNum,skillOp);
}
</script>
