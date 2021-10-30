<div class="row designation">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Add Announcement</h4>
            </div>
            <div class="card-body">
                <?php echo $this->Form->create($announcement) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'title', [
                                                'label' => [
                                                        'class' => 'control-label',
                                                        'text' => 'Title*'
                                                    ],
                                                'class' => 'form-control'
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'announcement', [
                                                'label' => [
                                                        'class' => 'control-label',
                                                        'text' => 'Announcement*'
                                                    ],
                                                'class' => 'form-control',
                                                'id' => 'mymce'
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                    echo $this->Form->control(
                                        'start_date', [
                                            'label' => [
                                                    'class' => 'control-label ',
                                                    'text' => 'Start Date*'
                                                ],
                                            'type'  => 'text',
                                            'class' => 'form-control mydatepicker',
                                            'value' => date('m/d/Y', strtotime($announcement->start_date))
                                        ]
                                    );
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                    echo $this->Form->control(
                                        'end_date', [
                                            'label' => [
                                                    'class' => 'control-label',
                                                    'text' => 'End Date*'
                                                ],
                                            'type'  => 'text',
                                            'class' => 'form-control  mydatepicker',
                                            'value' => date('m/d/Y', strtotime($announcement->end_date))
                                        ]
                                    );
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                    echo $this->Form->control(
                                        'offices', [
                                            'options' => [
                                                'New York' => 'New York',
                                                'Goa' => 'Goa', 
                                                'Sylhet' => 'Sylhet',
                                                'Dhaka' => 'Dhaka',
                                                'Ukraine' => 'Ukraine',
                                                'All-Offices' => 'All-Offices',
                                                '' => 'Select Office'
                                            ],
                                            'label' => [
                                                'class' => 'control-label',
                                                'text' => 'Offices*'
                                            ],
                                            'disabled' => [''],
                                            'value' => (isset($announcement->offices))?$announcement->offices: [''],
                                            'class' => 'form-control'
                                        ]
                                    );
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <?php
                            echo $this->Form->button(__('Save'), ['class' => 'btn btn-info mr-1']);

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
