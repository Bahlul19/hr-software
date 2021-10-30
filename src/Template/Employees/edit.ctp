
    <div class="row employees" id="validation">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><?php echo _("Edit Employee"); ?></h4>
                </div>
                <div class="card-body wizard-content">
                    <?php echo $this->Form->create($employee, ['type'=>'file','class' => 'validation-wizard wizard-circle']); ?>
                        <!-- Step 1 -->
                        <h6>Personal Info</h6>
                        <section>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('first_name', 
                                        [
                                            'class' => 'form-control',
                                            'label' => 'First Name *',
                                        ]); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('last_name', 
                                            [
                                                'class' => 'form-control',
                                                'label' => 'Last Name *'
                                            ]); 
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('personal_email', 
                                            [
                                                'class' => 'form-control',
                                                'label' => 'Personal Email * ',
                                            ]); 
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('office_email', 
                                            [
                                                'class' => 'form-control',
                                                'label' => 'Office Email *',
                                            ]); 
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('mobile_number', 
                                            [
                                                'class' => 'form-control',
                                                'label' => 'Mobile Number *',
                                            ]); 
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('permanent_address', 
                                            [
                                                'class' => 'form-control',
                                                'label' => 'Permanent Address *',
                                            ]); 
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('present_address', ['class' => 'form-control']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('alternate_number', 
                                            [
                                                'class' => 'form-control',
                                                'label' => 'Alternate Number *',
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('emergency_number', 
                                            [
                                                'class' => 'form-control',
                                                'label' => 'Emergency Number *',
                                            ]); 
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('country', [
                                                'class' => 'form-control',
                                                'label' => [
                                                    'class' => 'control-label',
                                                    'text' => 'Country *'
                                                ],
                                                'options' => [
                                                    'India' => 'India',
                                                    'Bangladesh' => 'Bangladesh',
                                                    'United States' => 'United States',
                                                    'Ukraine' => 'Ukraine',
                                                    '' => 'Select Country'
                                                ],
                                                'disabled' => [''],
                                                'value' => (isset($employee->country)) ? $employee->country :  ['']
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('office_location', [
                                                'class' => 'form-control office-location',
                                                'label' => [
                                                    'class' => 'control-label',
                                                    'text' => 'Office Location *'
                                                ],
                                                'options' => [
                                                    'NYC' => 'NYC',
                                                    'GOA' => 'GOA', 
                                                    'SYL' => 'SYL',
                                                    'DHK' => 'DHK',
                                                    'UKR' => 'UKR',
                                                    '' => 'Select Office'
                                                ],
                                                'disabled' => [''],
                                                'value' => (isset($employee->office_location)) ? $employee->office_location :  ['']
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('gender', [
                                                'class' => 'form-control',
                                                'label' => [
                                                    'class' => 'control-label',
                                                    'text' => 'Gender *',
                                                ],
                                                'options' => [
                                                    '1' => 'Male',
                                                    '2' => 'Female',
                                                    '' => 'Select Gender'
                                                ],
                                                'disabled' => [''],
                                                'value' => (isset($employee->gender)) ? $employee->gender :  ['']
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('birth_date', [
                                                'class' => 'form-control mydatepicker',
                                                'type' => 'text',
                                                'value' => date('m/d/Y', strtotime($employee->birth_date))
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('maritial_status', [
                                                'class' => 'form-control',
                                                'options' => [
                                                    'married'=>'married',
                                                    'unmarried'=>'unmarried' ,
                                                    '' => 'Select Maritial Status'
                                                ],
                                                'disabled' => [''],
                                                'value' => ($employee->maritial_status)!="" ? $employee->maritial_status :  ''
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <?php
                                            echo $this->Form->control('blood_group', [
                                                'class' => 'form-control',
                                                'options' => [
                                                    'A'=>'A',
                                                    'A+ve'=>'A +ve',
                                                    'A-ve'=>'A -ve',
                                                    'B+ve'=>'B +ve',
                                                    'B-ve'=>'B -ve',
                                                    'AB+ve'=>'AB +ve',
                                                    'AB-ve'=>'AB -ve',
                                                    'O+ve'=>'O +ve',
                                                    'O-ve'=>'O -ve',
                                                    '' => 'Select Blood Group'
                                                ],
                                                'disabled' => [''],
                                                'value' => (isset($employee->blood_group)) ? $employee->blood_group :  ['']
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('languages', [
                                                'class' => 'form-control'
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('bank_name', [
                                                'class' => 'form-control bank-name'
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('bank_account_number', ['class' => 'form-control']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('tax_bracket', ['class' => 'form-control']); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('max_qualification', 
                                            [
                                                'class' => 'form-control',
                                                'label' => 'Max Qualification *'
                                            ]); 
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <?php 
                                            if($loggedUser['role_id'] ==1){
                                                    echo $this->Form->control('role_id', [
                                                    'class' => 'form-control',
                                                        'label' => [
                                                            'class' => 'control-label',
                                                            'text' => 'Role *'
                                                        ],
                                                    'options' => $role,
                                                    'disabled' => [''],
                                                    'value' => (isset($employee->role_id)) ? $employee->role_id :  ['']
                                                    ]
                                                );
                                            }
                                            else if ($loggedUser['role_id'] ==2){
                                                echo $this->Form->control(
                                                    'role_id', [
                                                    'class' => 'form-control',
                                                        'label' => [
                                                            'class' => 'control-label',
                                                            'text' => 'Role *'
                                                        ],
                                                    'options' => $roleWithouSuperAdmin,
                                                    'disabled' => [''],
                                                    'value' => (isset($employee->role_id)) ? $employee->role_id :  ['']
                                                    ]
                                                );
                                            }
                                            else{
                                                echo $this->Form->control(
                                                    'role_id', [
                                                        'type' => 'select',
                                                        'empty' => 'Select Role',
                                                        'options' => $roleWithouHrAdmin,
                                                        'class' => 'form-control',
                                                        'label' => [
                                                            'class' => 'control-label',
                                                            'text' => 'Role *'
                                                        ],
                                                    'value' => (isset($employee->role_id)) ? $employee->role_id :  ['']
                                                    ]
                                                );
                                            }
                                        ?>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                         if($employee->birth_date2!=null || $employee->birth_date2!=""){
                                            $date=date('m/d/Y', strtotime($employee->birth_date2));
                                         }else{
                                             $date="";
                                         }
                                            echo $this->Form->control('birth_date2', [
                                                'class' => 'form-control mydatepicker',
                                                'type' => 'text',
                                                'value' => $date,
                                                'label'=>"Registered Birth Date"
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Step 2 -->
                        <h6>Work Details</h6>
                        <section>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('designation_id', [
                                                    'class' => 'form-control',
                                                    'label' => 'Designation * ',
                                                    'options' => $designations,
                                                    'disabled' => [''],
                                                    'value' => (isset($employee->designation_id)) ? $employee->designation_id :  ['']
                                                ]
                                            );
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('shift_type', [
                                                'class' => 'form-control',
                                                'label' => 'Office time *',
                                                'options' => [
                                                    '8:00-17:00' => '8:00-17:00',
                                                    '8:30-17:30' => '8:30-17:30',
                                                    '9:00-18:00' => '9:00-18:00',
                                                    '9:30-18:30' => '9:30-18:30',
                                                    '10:00-19:00' => '10:00-19:00',
                                                    '10:30-19:30' => '10:30-19:30',
                                                    '11:00-20:00' => '11:00-20:00',
                                                    '11:30-20:30' => '11:30-20:30',
                                                    '12:00-21:00' => '12:00-21:00',
                                                    '12:30-21:30' => '12:30-21:30',                                                    
                                                    '13:00-22:00' => '13:00-22:00',
                                                    '13:30-22:30' => '13:30-22:30',
                                                    '14:00-23:00' => '14:00-23:00',
                                                    '14:30-23:30' => '14:30-23:30',
                                                    '15:00-00:00' => '15:00-00:00',
                                                    '18:00-02:30' => '18:00-02:30',
                                                    '18:30-03:00' => '18:30-03:00',
                                                    '' => 'Select Shift'
                                                ],
                                                'disabled' => [''],
                                                'value' => (isset($employee->shift_type)) ? $employee->shift_type :  [''],
                                                'id' => (!empty($employee->shift_type) ? 'shift-type-request' : 'shift-type')
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('department_id', [
                                                'class' => 'form-control',
                                                'options' => $departments,
                                                'disabled' => [''],
                                                'value' => (isset($employee->department_id)) ? $employee->department_id :  ['']
                                            ]);
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('reporting_team', [
                                                'class' => 'form-control',
                                                'options' => $reportingTeam,
                                                'disabled' => [''],
                                                'value' =>(isset($employee->reporting_team)) ? $employee->reporting_team :  ['']
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('reporting_manager', [
                                                'class' => 'form-control',
                                                'options' => $reportingManager,
                                                'disabled' => [''],
                                                'value' => (isset($employee->reporting_manager) && array_key_exists($employee->reporting_manager, $reportingManager)) ? $employee->reporting_manager :  ['']
                                            ]);
                                        ?>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('mentor', [
                                                'class' => 'form-control',
                                                'options' =>  [
                                                    '' => 'Select Mentor',
                                                    'Mohan Pai' => 'Mohan Pai', 
                                                    'Madhav Ranganekar' => 'Madhav Ranganekar',],
                                                'disabled' => [''],
                                                'value' => (isset($employee->mentor)) ? $employee->mentor :  ['']
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input text required" aria-required="true">
                                            <label for="date-of-joining">Date Of Joining *</label>
                                            <input value="<?=date('m/d/Y', strtotime($employee->date_of_joining))?>" type="text" name="date_of_joining" class="form-control mydatepicker" required="required" id="date-of-joining" aria-required="true" aria-invalid="false">
                                        </div>
                                        <?php
                                            // echo $this->Form->control('date_of_joining', [
                                            //     'class' => 'form-control mydatepicker',
                                            //     'type' => 'text',
                                            //     'label' => 'Date Of Joining *'
                                            // ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('source_of_hire', [
                                                'class' => 'form-control'
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('referred_by', [
                                                'class' => 'form-control'
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="employment-status">Employment Status</label>
                                        <div class="switch">
                                            <label>
                                                InActive
                                                <?php
                                                    echo $this->Form->checkbox(
                                                        'employment_status', [
                                                            'value' => 1
                                                        ]
                                                    );
                                                ?>
                                                <span class="lever"></span>Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('work_phone', [
                                                'class' => 'form-control',
                                                'label' => 'Work Phone *'
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('employment_type', [
                                                'class' => 'form-control',
                                                'label' => 'Employment Type *',
                                                'options' => [
                                                    'full-time' => 'Full Time',
                                                    'part-time' => 'Part Time',
                                                    'contract' => 'contract',
                                                    'intern' => 'Intern',
                                                    'other' => 'other',
                                                    '' => 'Select Employment Type'
                                                ],
                                                'disabled' => [''],
                                                'value' => (isset($employee->employment_type)) ? $employee->employment_type :  ['']
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('confirmation_date', [
                                                'class' => 'form-control mydatepicker',
                                                'type' => 'text',
                                                'label' => 'Confirmation Date *',
                                                'value' => date('m/d/Y', strtotime($employee->confirmation_date))
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        $totalDesignation = count($employee->designation_changes);
                                        $updatedDesignationIndex = $totalDesignation -1;
                                            echo $this->Form->control('designation_change', [
                                                'class' => 'form-control',
                                                'type' => 'text',
                                                'label' => 'Designation Change *',
                                                'value' => (!empty($employee->designation_changes[$updatedDesignationIndex]['designation_change']) ? $employee->designation_changes[$updatedDesignationIndex]['designation_change']: '') 
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('designation_change_date', [
                                                'class' => 'form-control mydatepicker',
                                                'type' => 'text',
                                                'label' => 'Designation Change Date *',
                                                'value' => (!empty($employee->designation_changes[$updatedDesignationIndex]['change_date']) ? $employee->designation_changes[$updatedDesignationIndex]['change_date']: '')
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('increment_date', [
                                                'class' => 'form-control mydatepicker',
                                                'type' => 'text',
                                                'value'=> (strtotime($employee->increment_date) == 0 ? '' : date('m/d/Y', strtotime($employee->increment_date)))
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('resignation_date', [
                                                'class' => 'form-control mydatepicker',
                                                'type' => 'text',
                                                'label' => 'Resignation Date',
                                                'value' => (strtotime($employee->resignation_date) == 0 ? '' : date('m/d/Y', strtotime($employee->resignation_date)))
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('last_working_date', [
                                                'class' => 'form-control mydatepicker',
                                                'type' => 'text',
                                                'label' => 'Last Working Date',
                                                'value' => (strtotime($employee->last_working_date) == 0 ? '' : date('m/d/Y', strtotime($employee->last_working_date)))
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('notice_period', [
                                                'class' => 'form-control',
                                                'label' => 'Notice Period *'
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('reason', [
                                                'class' => 'form-control'
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('blacklisted', [
                                                'class' => 'form-control'
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="employment-status">Reporting Manager Responsibility</label>
                                        <div class="switch">
                                            <label>
                                                No
                                                <?php
                                                    echo $this->Form->checkbox(
                                                        'reporting_manager_responsibilities', [
                                                            'value' => 0
                                                        ]
                                                    );
                                                ?>
                                                <span class="lever"></span>Yes
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('notes', [
                                                'class' => 'form-control',
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('knowledge', [
                                                'class' => 'form-control',
                                                'label' => 'Knowledge *',
                                            ]);
                                        ?>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">
                                            Identity Proof
                                        </label>
                                        <?php
                                            echo $this->Form->file('identity_proof', [
                                                'class' => 'form-control',
                                                'label' => 'Identity Proof ',
                                                'required' => false,
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="employment-status">Project Manager Responsibility</label>
                                        <div class="switch">
                                            <label>
                                                No
                                                <?php
                                                    echo $this->Form->checkbox(
                                                        'is_pm', [
                                                            'value' => 1
                                                        ]
                                                    );
                                                ?>
                                                <span class="lever"></span>Yes
                                                
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>
