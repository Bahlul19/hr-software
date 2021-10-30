<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeSkill $employeeSkill
 */

use PhpParser\Node\Stmt\Label;

?>
<div class="employeeSkills form large-9 medium-8 columns content">
    <?= $this->Form->create($employeeSkill) ?>
    <fieldset>
        <Label>Employee : <?= h($employeeSkill->employee->first_name)." ".h($employeeSkill->employee->last_name) ?></Label><br/>
        <Label>Skill : <?= h($employeeSkill->skill->skill_name) ?></Label><br/>
        <Label>Skill Level : <?= h(ucfirst($employeeSkill->skill_level->level_name)) ?></Label><br/>
        <Label>Start Date : <?= h($employeeSkill->from_date) ?></Label><br/>
        <Label>End date : <?= h($employeeSkill->to_date) ?></Label><br/>
        <div class="form-group green-border-focus">
            <label for="exampleFormControlTextarea5">Why are you rejecting the skill for this employee?</label>
            <textarea class="form-control" id="exampleFormControlTextarea5" name='comments' rows="3" required></textarea>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit',['class'=>'btn btn-danger'])) ?>
    <?= $this->Form->end() ?>
</div>
