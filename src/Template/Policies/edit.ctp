<?php 

if ($role == 1 || $role == 2){

?>
<div class="row" id="policy">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Add Policy</h4>
            </div>
            <div class="card-body">
                <?php echo $this->Form->create($policy) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php
                                echo $this->Form->control(
                                    'title', [
                                        'label' => [
                                            'class' => 'control-label'
                                        ],
                                        'class' => 'form-control '
                                    ]
                                );
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php
                                echo $this->Form->control(
                                    'policies', [
                                        'label' => [
                                            'class' => 'control-label'
                                        ],
                                        'class' => 'form-control',
                                        'id' => 'mymce',
                                        'required' => false
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
                                echo $this->Form->control('office', [
                                    'class' => 'form-control',
                                    'options' => [
                                        'NYC' => 'New York',
                                        'SYL' => 'Sylhet',
                                        'DHK' => 'Dhaka',
                                        'UKR' => 'Ukraine',
                                        'GOA' => 'Goa',
                                        'All-Offices' => 'All-Offices',
                                        '' => 'Select Office'
                                    ],
                                    'disabled' => ['']

                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <?php
                        echo $this->Form->button(__('Update'), ['type' => 'submit','class' => 'btn btn-info mr-1']);

                        echo $this->Html->link(
                            __('Back'),
                            ['action' => 'index'], ['class' => 'btn btn-inverse']
                        );
                        ?>
                    </div>
                </div>
                <?php echo $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
<?php 

}

?>