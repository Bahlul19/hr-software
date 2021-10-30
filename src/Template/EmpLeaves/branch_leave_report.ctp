<div class="row leave-request">
    <div class="card card-outline-info">
        <div class="card-body">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-3">
                        <?php
                        echo $this->Form->control(
                            'date_from', [
                                'label' => [
                                    'class' => 'control-label'
                                ],
                                'type' => 'text',
                                'class' => 'form-control mydatepicker',
                                'id' => 'dateFrom',
                                'autocomplete' => 'off',
                                'required' => ''
                            ]
                        );
                        ?>
                    </div>

                    <div class="col-md-3">
                        <?php
                        echo $this->Form->control(
                            'date_to', [
                                'label' => [
                                    'class' => 'control-label'
                                ],
                                'type' => 'text',
                                'class' => 'form-control mydatepicker',
                                'id' => 'dateTo',
                                'autocomplete' => 'off',
                                'required' => ''
                            ]
                        );
                        ?>
                    </div>

                    <div class="col-md-3">
                    <?php
                        echo $this->Form->control('office_location', [
                            'class' => 'form-control office-location',
                            'id' => 'branch-location-request-dropdown',
                            'options' => [
                                '' => 'Select Office',
                                'NYC' => 'NYC',
                                'SYL' => 'SYL',
                                'GOA' => 'GOA',
                                'DHK' => 'DHK',
                                'UKR' => 'UKR',
                            ],
                            'label' => [
                                'class' => 'control-label',
                                'text' => 'Office Location *'
                            ],
                            'onchange' => 'return getBranchwiseLeaveType()'
                        ]);
                    ?>
                    </div>

                    <div class="col-md-3" id="office-locationwise-leave-type">
                        <label class="control-label" for="dateFrom">Leave Type</label>
                        <?php
                        echo $this->Form->select(
                            'leave_type',[
                                '' => 'Select',
                                '1'=>'Sick Leave'
                            ],['class'=>'form-control','id'=>'leaveType']
                        );
                        ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-body text-center">
            <button class="btn btn-primary" type="button" id="btn-branch-leave-report-search">SEARCH</button>
            <button class="btn btn-warning" type="button" id="btn-branch-leave-report-export">EXPORT</button>
            <select id="employee-report-type" class="col-md-2 form-control">
                <option value="">Export Type</option>
                <option value="1">Excel</option>
                <option value="2">CSV</option>
                <option value="3">PDF</option>
            </select>
            <input type="hidden" id="btn-leave-report-hidden" value="/pdf_download/5.pdf" />
        </div>
        <div class="card-body" id="leave-request-list" >
        </div>

        <div class="card-body" id="leave-request-list-for-pdf-downloading" style="position: relative; right:-100000px; height: 0; overflow: hidden;">

        </div>
    </div>
</div>