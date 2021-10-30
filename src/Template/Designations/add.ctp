<div class="row designation">
    <div class="col-lg-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Add Designation ( Please dont use short forms )</h4>
            </div>
            <div class="card-body">
                <?php echo $this->Form->create($designation) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'title', [
                                                'label' => [
                                                        'class' => 'control-label'
                                                    ],
                                                'class' => 'form-control ',
                                                'onkeyup' => 'searchComp()',
                                                'onblur' => 'vipeComp()',
                                                'id' => 'title'
                                            ]
                                        );
                                    ?>
                                    <ul id="myUL">
                                        <?php foreach($oldDesignations as $key => $value) { ?>
                                            <li class="hide" data="<?= h($value->title) ?>" onclick=""><a href="#"><?= h($value->title) ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
                                echo $this->Form->control(
                                    'no_of_employees', [
                                        'label' => [
                                                'class' => 'control-label'
                                            ],
                                        'type'  => 'hidden',
                                        'value' => 0
                                    ]
                                );
                            ?>
                             <?php
                                echo $this->Form->control(
                                    'status', [
                                        'label' => [
                                                'class' => 'control-label'
                                            ],
                                        'type'  => 'hidden',
                                        'value' => 1
                                    ]
                                );
                            ?>


                      </div>
                      </div>
                      <div class="form-actions">
                            <?php
                                echo $this->Form->button(__('Save'), ['class' => 'btn btn-info']);

                                echo $this->Html->link(
                                    __('Back'),
                                    ['action' => 'index'], ['class' => 'btn btn-inverse']
                                );
                            ?>
                      </div>

                <?php echo $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
