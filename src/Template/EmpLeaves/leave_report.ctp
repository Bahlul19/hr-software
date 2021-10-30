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
                        echo $this->Form->control('employees', [
                                'class' => 'form-control emp-list-leave-report',
                                'empty' => 'Select Employee',
                                'options' => $employees,
                                'maxlength'=>100,
                                'id' => 'emp-list-leave-report',
                                'label' => 'Employee *'
                            ]
                        );
                    ?>
                    </div>

                    <div class="col-md-3" id="office-locationwise-leave-type">
                        <label class="control-label" for="dateFrom">Leave Type</label>
                        <?php
                        echo $this->Form->select(
                            'leave_type',[
                                'text' => 'Select Leaves Type',
                                '1'=>'Sick Leave'
                            ],['class'=>'form-control','id'=>'leaveType']
                        );
                        ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-body text-center">
            <button class="btn btn-primary" type="button" id="btn-leave-report-search">SEARCH</button>
            <button class="btn btn-warning" type="button" id="btn-leave-report-export">EXPORT</button>
            <select id="employee-report-type" class="col-md-2 form-control">
                <option value="">Export Type</option>
                <option value="1">Excel</option>
                <option value="2">CSV</option>
                <option value="3">PDF</option>
            </select>
            <input type="hidden" id="btn-leave-report-hidden" value="/pdf_download/5.pdf" />
        </div>
        <div class="card-body" id="leave-request-list">

        </div>

        <div class="card-body" id="leave-request-list-for-pdf-downloading" style="height: 0px; width: 0px; overflow: hidden;">

        </div>
    </div>
</div>