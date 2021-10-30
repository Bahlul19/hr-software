<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeSkill[]|\Cake\Collection\CollectionInterface $employeeSkills
 */
?>
<div class="employeeSkills index large-9 medium-8 columns content">
    <div class="row pt-2">
    <div class="col-md-5">
        <h3><?= __('Employee Skills') ?></h3>
    </div>
    <div class="col-md-5">
    </div>
    <div class="col-md-2">
        <?= $this->Html->link(__('Graphical view'), ['action' => 'skills_graph', $user],['class'=>'btn btn-primary']) ?>
    </div>
    </div>
    <br>
    <table class="table table-hover table-bordered datatable">
        <thead>
            <tr>
                <th scope="col">Skill</th>
                <th scope="col">Skill Level</th>
                <th scope="col">Status</th>
                <th scope="col">Approved by</th>
                <th scope="col">Comment</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employeeSkills as $employeeSkill): ?>
            <tr>
                <td><?= $employeeSkill->has('skill') ? $this->Html->link($employeeSkill->skill->skill_name, ['controller' => 'Skills', 'action' => 'view', $employeeSkill->skill->id]) : '' ?></td>
                <td><?= $employeeSkill->has('skill_level') ? h(ucfirst($employeeSkill->skill_level->level_name)) : '' ?></td>
                <td>
                <?php
                    if($employeeSkill->status==1){echo '<span class="approved">Approved</span>';}
                    elseif($employeeSkill->status==2){echo '<span class="pending">Pending</span>';}
                    elseif($employeeSkill->status==0){echo '<span class="rejected">Rejected</span>';}
                ?>
                </td>
                <td><?= ($employeeSkill->updated_by_name != " ") ? h($employeeSkill->updated_by_name) : "--" ?></td>
                <td><?= $employeeSkill->comments ? h($employeeSkill->comments) : "--"?></td>
                <td><?= h($employeeSkill->from_date) ?></td>
                <td><?= h($employeeSkill->to_date) ?></td>
                <td><?= h($employeeSkill->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
