<div class="row department">
    <div class="col-lg-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Add Department</h4>
            </div>
            <div class="card-body">
                <?php echo $this->Form->create($department) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'name', [
                                                'label' => [
                                                        'class' => 'control-label'
                                                    ],
                                                'class' => 'form-control '
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'lead', [
                                                'label' => [
                                                        'class' => 'control-label'
                                                    ],
                                                'class' => 'form-control'
                                            ]
                                        );
                                    ?>
                                </div>
                           </div>
                           <?php
                                echo $this->Form->control(
                                    'no_of_employees', [
                                        'label' => [
                                                'class' => 'control-label'
                                            ],
                                        'class' => 'form-control',
                                        'type'  => 'hidden',
                                        'value' =>  0
                                    ]
                                );
                            ?>
                            <?php
                                echo $this->Form->control(
                                    'status', [
                                        'label' => [
                                                'class' => 'control-label'
                                            ],
                                        'class' => 'form-control',
                                        'type'  => 'hidden',
                                        'value' =>  1
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
