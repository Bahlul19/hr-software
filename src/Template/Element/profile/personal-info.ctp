<div class="card">
    <div class="card-header" id="personal-info" role="tab" data-toggle="collapse" href="#personal-info-data" aria-expanded="true" aria-controls="personal-info-data">
        <h5 class="mb-0 text-white">
            Personal Info
        </h5>
    </div>
    <div id="personal-info-data" class="collapse show" role="tabpanel" aria-labelledby="personal-info" data-parent="#accordion">
        <div class="card-body">
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">First Name : </label>
                            <?php
                                echo $employee->first_name;
                            ?>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <label class="control-label">Last Name : </label>
                        <?php
                            echo $employee->last_name
                        ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group ">
                    <label class="control-label">Emp id : </label>
                        <?php
                            echo $employee->id
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Personal Email : </label>
                            <?php
                                echo $employee->personal_email
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Office email : </label>
                            <?php
                                echo $employee->office_email
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Present Address : </label>
                            <?php
                                echo $employee->present_address
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Permanent Address: </label>
                            <?php
                                echo $employee->permanent_address
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Blood Group : </label>
                            <?php
                                echo $employee->blood_group
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Mobile Number: </label>
                            <?php
                                echo $employee->mobile_number
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Alternate Number: </label>
                            <?php
                                echo $employee->alternate_number
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Emergency Number: </label>
                            <?php
                                echo $employee->emergency_number;
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Country : </label>
                            <?php
                                echo $employee->country
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Office Location: </label>
                            <?php
                                echo $employee->office_location
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Gender : </label>
                            <?php
                                echo ($employee->gender == '1') ? 'Male': 'Female';
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Birth Date: </label>
                            <?php
                                echo date('d M Y', strtotime($employee->birth_date));
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Registered Birth Date: </label>
                                <?php
                                    if('1970-01-01 00:00:00'!=date('Y-m-d H:i:s', strtotime($employee->birth_date2))){
                                        if(!empty($employee->birth_date2) || $employee->birth_date2!=""){
                                            echo date('Y', strtotime($employee->birth_date2));
                                        }else{
                                                echo "";
                                        } 
                                    }else{
                                        echo "N/A";  
                                    }

                                ?>
                        </div>
                    </div>
            </div>
            <div class="row bottom-margin">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Identification Proof: </label>
                            <?php
                                if(!empty($employee->identity_proof)){
                            ?>
                                    <a href="/file/<?php echo $employee->identity_proof;?>" download class="btn btn-info">Download</a>
                            <?php
                                }
                                else{
                                    echo "Identification Proof is not Added";
                                }
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Bank Name: </label>
                            <?php
                                echo $employee->bank_name;
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Bank Account Number: </label>
                            <?php
                                echo $employee->bank_account_number
                            ?>
                    </div>
                </div>
                
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Salary: </label>
                            <?php
                                if(!empty($employeeSalary['salary']) && $employeeSalary['approval'] == 1){
                                    echo $employeeSalary['salary'];
                                } else if(!empty($employeeSalary['salary']) && $employeeSalary['approval'] == 0){
                                    echo "Waiting For Approval";
                                } else {
                                    echo "Not Set";
                                }
                            ?>
                        </div>
                    </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Tax bracket: </label>
                            <?php
                                echo $employee->tax_bracket
                            ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                          <label class="control-label">Languages: </label>
                            <?php
                                echo $employee->languages
                            ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Martial Status: </label>
                                <?php
                                    echo $employee->maritial_status
                                ?>
                        </div>
                    </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Role: </label>
                        <?php
                            $role_id = $employee->role_id;
                            if($role_id  == 1){ echo "Super Admin"; }
                            if($role_id  == 2){echo "HR Admin";}
                            if($role_id  == 3){echo "Admin";}
                            if($role_id  == 4){echo "Member";}
                        ?>
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Max Qualification: </label>
                            <?php
                                echo $employee->max_qualification
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
