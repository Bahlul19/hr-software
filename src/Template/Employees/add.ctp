<div class="row employees">
    <div class="col-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?php echo "Add Employee"; ?></h4>
            </div>
            <div class="card-body wizard-content">
                <?php echo $this->Form->create($employee, ['type' => 'file','class' => 'validation-wizard wizard-circle']); ?>
                    <!-- Step 1 -->
                    <h6>Personal Info</h6>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo $this->Form->control(
                                        'first_name',[
                                            'class' => 'form-control first-name',
                                            'label' => 'First Name *',
                                            'id'    => (isset($employee->first_name) ? 'first-name-request':'first-name-session')
                                        ]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo $this->Form->control(
                                        'last_name', [
                                            'class' => 'form-control last-name',
                                            'label' => 'Last Name *',
                                            'id'    => (isset($employee->last_name) ? 'last-name-request':'last-name-session')
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo $this->Form->control(
                                        'personal_email',[
                                            'class' => 'form-control personal-email',
                                            'label' => 'Personal Email * ',
                                            'id'    => (isset($employee->personal_email) ? 'personal-email-request':'personal-email-session')
                                        ]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo $this->Form->control(
                                        'office_email',[
                                            'class' => 'form-control office-email',
                                            'label' => 'Office Email *',
                                            'id'    => (isset($employee->office_email) ? 'office-email-request':'office-email-session')
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'password', [
                                                'class' => 'form-control',
                                                'type' => 'password',
                                                'label' => 'Password *'
                                            ]);
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo $this->Form->control(
                                        'mobile_number', [
                                            'class' => 'form-control mobile-number',
                                            'label' => 'Mobile Number *',
                                            'id' => (isset($employee->mobile_number) ? 'mobile-number-request':'mobile-number-session'),

                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo $this->Form->control('permanent_address', [
                                            'class' => 'form-control permanent-address',
                                            'label' => 'Permanent Address *',
                                            'id' => (isset($employee->permanent_address) ? 'permanent-address-request':'permanent-address-session'),
                                        ]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo $this->Form->control('present_address', [
                                            'class' => 'form-control present-address',
                                            'id' => (isset($employee->present_address) ? 'present-address-request':'present-address-session'),
                                        ]);
                                     ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo $this->Form->control('alternate_number', [
                                            'class' => 'form-control alternate-number',
                                            'label' => 'Alternate Number *',
                                            'id' => (isset($employee->alternate_number) ? 'alternate-number-request':'alternate-number-session'),
                                        ]);
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo $this->Form->control('emergency_number', [
                                            'class' => 'form-control emergency-number',
                                            'label' => 'Emergency Number *',
                                            'id' => (isset($employee->emergency_number) ? 'emergency-number-request':'emergency-number-session'),
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
                                            'class' => 'form-control country',
                                            'id' => (isset($employee->country) ? 'country-request':'country-session'),
                                            'options' => [
                                                '' => 'Select Country',
                                                'Bangladesh' => 'Bangladesh',
                                                'India' => 'India',
                                                'United States' => 'United States',
                                                'Ukraine' => 'Ukraine',
                                            ],
                                            'label' => [
                                                'class' => 'control-label',
                                                'text' => 'Country *'
                                            ],
                                        ]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control('office_location', [
                                            'class' => 'form-control office-location',
                                            'id' => 'office-location',
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
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo $this->Form->control('gender', [
                                            'class' => 'form-control gender',
                                            'id' => (isset($employee->gender) ? 'gender-request':'gender-session'),
                                            'options' => [
                                                '' => 'Select Gender',
                                                '1' => 'Male',
                                                '2' => 'Female',
                                            ],
                                            'label' => [
                                                'class' => 'control-label',
                                                'text' => 'Gender *',
                                            ],
                                        ]);
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control('birth_date', [
                                            'class' => 'form-control mydatepicker birth-date',
                                            'type' => 'text',
                                            'id' => (isset($employee->birth_date) ? 'birth-date-request':'birth-date-session'),
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
                                            'class' => 'form-control martial-status',
                                            'id' => (isset($employee->martial_status) ? 'martial-status-request':'martial-status-session'),
                                            'options' => [
                                                '' => 'Select Maritial Status',
                                                'married'=>'married',
                                                'unmarried'=>'unmarried',
                                            ],
                                        ]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">

                                    <?php
                                        echo $this->Form->control('blood_group', [
                                            'class' => 'form-control blood-group',
                                            'id' => (isset($employee->blood_group) ? 'blood-group-request':'blood-group-session'),
                                            'options' => [
                                                '' => 'Select Blood Group',
                                                'A'=>'A',
                                                'A+ve'=>'A +ve',
                                                'A-ve'=>'A -ve',
                                                'B+ve'=>'B +ve',
                                                'B-ve'=>'B -ve',
                                                'AB+ve'=>'AB +ve',
                                                'AB-ve'=>'AB -ve',
                                                'O+ve'=>'O +ve',
                                                'O-ve'=>'O -ve',
                                            ]
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
                                            'class' => 'form-control languages',
                                            'id' => (isset($employee->languages) ? 'languages-request':'languages-session'),
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
                                            'class' => 'form-control bank-name',
                                            'id' => (isset($employee->bank_name) ? 'bank-name-request':'bank-name-session'),
                                        ]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control('bank_account_number',
                                                [
                                                    'class' => 'form-control bank-account-number',
                                                    'id' => (isset($employee->bank_account_number) ? 'bank-account-number-request':'bank-account-number-session'),
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
                                        echo $this->Form->control('tax_bracket',
                                            [
                                                'class' => 'form-control tax-bracket',
                                                'id' => (isset($employee->tax_bracket) ? 'tax-bracket-request':'tax-bracket-session'),
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo $this->Form->control('max_qualification', [
                                            'class' => 'form-control max-qualification',
                                            'label' => 'Max Qualification *',
                                            'id' => (isset($employee->max_qualification) ? 'max-qualification-request':'max-qualification-session'),
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
                                            echo $this->Form->control(
                                                'role_id', [
                                                    'type' => 'select',
                                                    'empty' => 'Select Role',
                                                    'options' => $role,
                                                    'class' => 'form-control role-id',
                                                    'id' => (isset($employee->role_id) ? 'role-id-request':'role-id-session'),
                                                    'label' => [
                                                        'class' => 'control-label',
                                                        'text' => 'Role *'
                                                    ],
                                                ]
                                            );
                                        }
                                        else if ($loggedUser['role_id'] ==2){
                                            echo $this->Form->control(
                                                'role_id', [
                                                    'type' => 'select',
                                                    'empty' => 'Select Role',
                                                    'options' => $roleWithouSuperAdmin,
                                                    'class' => 'form-control role-id',
                                                    'id' => (isset($employee->role_id) ? 'role-id-request':'role-id-session'),
                                                    'label' => [
                                                        'class' => 'control-label',
                                                        'text' => 'Role *'
                                                    ],
                                                ]
                                            );
                                        }
                                        else{
                                            echo $this->Form->control(
                                                'role_id', [
                                                    'type' => 'select',
                                                    'empty' => 'Select Role',
                                                    'options' => $roleWithouHrAdmin,
                                                    'class' => 'form-control role-id',
                                                    'id' => (isset($employee->role_id) ? 'role-id-request':'role-id-session'),
                                                    'label' => [
                                                        'class' => 'control-label',
                                                        'text' => 'Role *'
                                                    ],
                                                ]
                                            );
                                        }
                                    ?>

                                </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('birth_date2', [
                                                'class' => 'form-control mydatepicker',
                                                'type' => 'text',
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
                                                'empty' => 'Select Designation',
                                                'options' => $designations,
                                                'label' => 'Designation * '
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo $this->Form->control('shift_type', [
                                            'class' => 'form-control',
                                            'options' => [
                                                '' => 'Select office time',
                                            ],
                                            'label' => 'Office Timing * ',
                                            'id' => 'shift-type'
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
                                                'empty' => 'Select Department',
                                                'options' => $departments,
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control('reporting_team', [
                                            'class' => 'form-control',
                                            'empty' => 'Select Reporting Team',
                                            'options' => $reportingTeam,
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
                                            'empty' => 'Reporting Manager',
                                            'options' => $reportingManager,
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
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control('date_of_joining', [
                                            'class' => 'form-control mydatepicker',
                                            'type' => 'text',
                                            'label' => 'Date Of Joining *'
                                        ]);
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
                                            Inactive
                                            <?php
                                                echo $this->Form->checkbox(
                                                    'employment_status', [
                                                        'value' => 1,
                                                        'Checked'
                                                    ]
                                                );
                                            ?>
                                            <span class="lever"></span>
                                            Active
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
                                            'options' => [
                                                '' => 'Select Employment Type',
                                                'full-time' => 'Full Time',
                                                'part-time' => 'Part Time',
                                                'contract' => 'contract',
                                                'intern' => 'Intern',
                                                'other' => 'other',
                                            ],
                                            'label' => 'Employment Type *'
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
                                            'label' => 'Confirmation Date *'
                                        ]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control('designation_change', [
                                            'class' => 'form-control',
                                            'type' => 'text',
                                            'label' => 'Designation Change *'
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
                                        ]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control('increment_date', [
                                            'class' => 'form-control mydatepicker',
                                            'type' => 'text'
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
                                            'label' => 'Resignation Date'
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
                                            'label' => 'Last Working Date'
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
                                        ]);
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Profile Picture
                                    </label>
                                    <?php
                                        echo $this->Form->file('profile_pic', [
                                            'class' => 'form-control',
                                            'label' => 'Profile Picture',
                                        ]);
                                    ?>
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
