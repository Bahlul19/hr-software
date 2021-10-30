<!-- <?//= $employeeDesignationId; ?> -->
<div class="row" id="leave-request">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Add Leave Request</h4>
            </div>
            <div class="card-body">
                <?php echo $this->Form->create($leaveRequest) ?>   
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php 
                                        echo $this->Form->control('employee_id', [
                                                'class' => 'form-control',
                                                'empty' => 'Select Employee',
                                                'options' => $employees,
                                                'id' => 'employee-id',
                                                'label' => 'Employee * ',
                                                'required' => 'true'
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6" id="leave_type">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
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
                                                'required' => 'true'
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'date_to',[
                                                'label' =>[
                                                    'class' => 'control-label'
                                                ],
                                                'type' => 'text',
                                                'class' => 'form-control mydatepicker',
                                                'id' => 'dateTo',
                                                'autocomplete' => 'off',
                                                'required' => 'true'
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
                                            'no_of_days',[
                                                'label' => [
                                                    'class' => 'control-label'
                                                ],
                                                'type' => 'text',
                                                'class' => 'form-control',
                                                'id' => 'noOfDays',
                                                'readonly' => 'true'
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Half Day</label>
                                    <?php
                                        echo $this->Form->select(
                                            'half_day',[
                                                '0' => 'Select',
                                                '1'=>'First Half', 
                                                '2'=>'Second Half'
                                            ],['class'=>'form-control',
                                            'required'=>'false', 'id' => 'halfDay']             
                                        );
                                    ?>
                                </div>
                            </div>  
                        </div>
                        <div id="leave_taken">
                                        
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'leave_reason',[
                                                'label' => [
                                                    'class' => 'control-label'
                                                ],
                                                'type' => 'textarea',
                                                'class'=> 'form-control'
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input text required">
                                        <label class="control-label" for="reliever">Reliever <span style="color: red; font-weight: bold; font-size: 15px;">*</span></label>
                                        <br/>
                                        <!-- <input type="text" name="reliever" class="form-control" required="required" maxlength="100" id="reliever" placeholder="Reliever"> -->
                                        <select required name="list[]" data-placeholder="Choose a Reliever..." class="chosen-select" multiple tabindex="4" style="width: 100%!important; font-size: 18px">
                                            <?php
                                            foreach ($reliever as $key=>$value):?>
                                                <option name="check_list[]" value="<?php echo $key?>" style="font-size: 16px;"><?php echo $value?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                </div>
                            </div>
<!--                            <div class="col-md-6" id="reliever">-->
<!---->
<!--                            </div>-->
                        </div>    
                        <div class="form-actions">
                        <?php
                            echo $this->Form->button(__('Submit'), ['type' => 'submit','class' => 'btn btn-info mr-1']);

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
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Please Enter a Valid Date. "Date to" cannot be Earlier then "Date From". </p>
            </div>
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
<!--            </div>-->
        </div>

    </div>
</div>

<div class="modal fade" id="myRemainingModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Your Leave request day(s) is/are greater then the remaining leave days. Please add a valid request or else your request will be rejected. Thank you.</p>
            </div>
        </div>

    </div>
</div>