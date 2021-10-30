<div class="card">
    <div class="card-header" id="work-details" role="tab" data-toggle="collapse" href="#work-details-data" aria-expanded="true" aria-controls="work-details-data">
        <h5 class="mb-0 text-white">
            work-details
        </h5>
    </div>
    <div id="work-details-data" class="collapse" role="tabpanel" aria-labelledby="work-details" data-parent="#accordion">
        <div class="card-body">
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Designation: </label>
                            <?php
                                echo $employee->designation['title'];
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Shift Type: </label>
                            <?php
                                echo $employee->shift_type;
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Department: </label>
                            <?php
                                echo $employee->department['name'];
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Reporting Team: </label>
                        <?php
                            if(isset($reportingTeam[0]['name'])){
                                echo $reportingTeam[0]['name'];
                            } 
                        ?>
                    </div>
                </div>
            </div>

            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Reporting Manager: </label>
                            <?php
                                echo $reportingManager;
                                
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Mentor: </label>
                            <?php
                                echo $employee->mentor;
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Date of Joining: </label>
                            <?php
                                echo date('m/d/Y',strtotime($employee->date_of_joining));
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Source of hire: </label>
                            <?php
                                echo $employee->source_of_hire;
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Refferred By: </label>
                            <?php
                                echo $employee->referred_by;
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Employment Status: </label>
                            <?php
                                if($employee->employment_status == 0){
                                    echo "Active";
                                } else {
                                    echo "Inactive";
                                }

                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Work Phone: </label>
                            <?php
                                echo $employee->work_phone;
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Employment Type: </label>
                            <?php
                                echo $employee->employment_type;                                        
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Confirmation Date: </label>
                            <?php
                                echo date('m/d/Y',strtotime($employee->confirmation_date))
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Designation Change: </label>
                            <?php
                                echo $employee->designation_change;                                        
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Designation change  Date: </label>
                            <?php
                              if(!empty($employee->designation_change_date) && date("Y-m-d",strtotime($employee->designation_change_date))!="1970-01-01"){
                                echo date('m/d/Y',strtotime($employee->designation_change_date));
                             }
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Increment Date: </label>
                            <?php
                                if(!empty($employee->increment_date) && date("Y-m-d",strtotime($employee->increment_date))!="1970-01-01"){
                                    echo date('m/d/Y',strtotime($employee->increment_date));
                               }
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Resignation Date: </label>
                            <?php
                             if(!empty($employee->resignation_date) && date("Y-m-d",strtotime($employee->resignation_date))!="1970-01-01"){
                                echo date('m/d/Y',strtotime($employee->resignation_date));
                            }
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Last working Date: </label>
                            <?php
                             if(!empty($employee->last_working_date) && date("Y-m-d",strtotime($employee->last_working_date))!="1970-01-01"){
                                    echo date('m/d/Y',strtotime($employee->last_working_date));
                             }
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Resignation Date: </label>
                            <?php
                                         echo $employee->notice_period;
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Reason: </label>
                            <?php
                                echo $employee->reason
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Blacklisted: </label>
                            <?php
                                echo $employee->blacklisted
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Notes: </label>
                            <?php
                                echo $employee->notes
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">knowledge: </label>
                            <?php
                                echo $employee->knowledge;
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
