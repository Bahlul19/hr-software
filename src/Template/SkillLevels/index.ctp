<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SkillLevel[]|\Cake\Collection\CollectionInterface $skillLevels
 */
?>
<br>
<div class="skillLevels index large-9 medium-8 columns content">
  <div class="row contacts">
    <div class="col-lg-12 remove-padding">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Skill levels</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="emp-list-table">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('Name') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                        <!-- <th scope="col" class="actions"><?= __('Actions') ?></th> -->
                                    </tr>
                            </thead>
                            <tbody>
                            <?php
                                    $pageNo=(int)$this->request->getQuery('page');
                                    if($pageNo==null){
                                        $pageNo=1;
                                    }
                                    $currentPage=20*($pageNo-1);
                                ?>
                                <?php foreach ($skillLevels as $key => $skillLevel): ?>
                                <tr>
                                    <td><?= $currentPage+($key+1) ?></td>
                                    <td><?= h(ucfirst($skillLevel->level_name)) ?></td>
                                    <td><?= h($skillLevel->created) ?></td>
                                    <!-- <td class="actions">
                                        <?php //echo $this->Html->link(__('Edit'), ['action' => 'edit', $skillLevel->id]) ?>
                                        <?php //echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $skillLevel->id], ['confirm' => __('Are you sure you want to delete # {0}?', $skillLevel->id)]) ?>
                                    </td> -->
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
