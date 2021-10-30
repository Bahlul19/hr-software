<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <div class="user-profile">

            <div class="logo">
                <a href="/">
                    <img src="/img/logo/sj-connect-logo.png"  class = "img-responsive" alt="logo">
                </a>
            </div>
         
            <div class="profile-pic" style="display: flex; justify-content: center;">
              <?php if($this->request->getSession()->read('profile_pic')!=null){ ?>
                  <img src="/file/employessPicture/<?php echo $this->request->getSession()->read('profile_pic'); ?>" class = "img-circle" alt="profile-img" width="120px" height="100px"/>
              <?php } ?>
            </div>
            <br/>
            <div class="profile-text">
                <h4>
                    <?php echo $loggedUser['first_name'] . ' ' . $loggedUser['last_name']; ?>
                </h4>
                <p style="word-wrap: break-word; width:95%;">
                    <?php echo $loggedUser['office_email']; ?>
                </p>
                <br/>
            </div>
        </div>

        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li>
                    <a class="waves-effect waves-dark" href="/employees/dashboard" aria-expanded="false">
                        <i class="mdi mdi-home"></i>
                        <span class="hide-menu">Home</span>
                    </a>

                </li>
                <li>
                    <a class="waves-effect waves-dark" href="/employees/profile/" aria-expanded="false">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">My Profile</span>
                    </a>
                </li>

                 <?php
                    $role = array(1,2,3,4);
                    if (in_array($loggedUser['role_id'], $role)) {?>

                <li>
                    <a class="waves-effect waves-dark" href="/employees/member_can_edit/" aria-expanded="false">
                        <i class="mdi mdi-account-edit"></i>
                        <span class="hide-menu">Edit Profile</span>
                    </a>
                </li>

                <?php } ?>
                <?php 
                    $role = array(1,2,3);
                    if (in_array($loggedUser['role_id'], $role)) {?>
                        <li>
                            <a class="waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="hide-menu">Employees</span>
                            </a>
                            <ul>
                                <li><a href="/employees/add"><i class="fa fa-arrow-right"></i>Add Employee</a></li>
                                <li><a href="/employees"><i class="fa fa-arrow-right"></i> List Employees</a></li>
                            </ul>
                        </li>
                <?php  } ?>
                <li>
                    <a class="waves-effect waves-dark" href="/emp-leaves/reliever_assignee" aria-expanded="false">
                        <i class="fa fa-list-alt"></i>
                        <span class="hide-menu">Reliver Request</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa fa-location-arrow"></i>
                        <span class="hide-menu">Leaves</span>
                    </a>
                    <ul>
                        <li><a href="/emp-leaves/add"><i class="fa fa-arrow-right"></i> New Leave Requests</a></li>
                        <li><a href="/emp-leaves"><i class="fa fa-arrow-right"></i> List Leave Requests</a></li>
                         <li><a href="/emp-leaves/cancelledleaveslist"><i class="fa fa-arrow-right"></i> Cancelled Leave List</a></li>
                        <?php
                        $role = array(1,2,3);
                            if (in_array($loggedUser['role_id'], $role)) { ?>
                        <li><a href="/emp-leaves/leaveforothers"><i class="fa fa-arrow-right"></i> Leave For Others</a></li>
                        <li><a href="/emp-leaves/leave-report"><i class="fa fa-arrow-right"></i>   Leave Report</a></li>
                        <li><a href="/emp-leaves/branch-leave-report"><i class="fa fa-arrow-right"></i> Branch Leave Report</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa fa-hourglass"></i>
                        <span class="hide-menu">Comp Off</span>
                    </a>
                    <ul>
                        <li>
                            <a class="waves-effect waves-dark" href="/CompOff/add" aria-expanded="false">
                                <i class="fa fa-arrow-right"></i>
                                <span>Comp Off Request</span>
                            </a>
                        </li>

                        <?php
                        //$role = array(1,2);
                        //if (in_array($loggedUser['role_id'], $role) || $loggedUser['is_manager'] == 1) {?>

                        <li>
                            <a class="waves-effect waves-dark" href="/CompOff/index" aria-expanded="false">
                                <i class="fa fa-arrow-right"></i>
                                <span>Comp Off List</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Utilize Comp Off</span>
                    </a>
                    <ul>
                        <li>
                            <a class="waves-effect waves-dark" href="/utilize-comoffs/add" aria-expanded="false">
                                <i class="fa fa-arrow-right"></i>
                                <span>Utilize approved Comp Off</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="/utilize-comoffs/" aria-expanded="false">
                                <i class="fa fa-arrow-right"></i>
                                <span>List utilizing Comp Off</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-calendar-clock"></i>
                            <span class="hide-menu">Attendence</span>
                    </a>

                    <ul>
                    <?php
                      $role = array(1,2);
                    if(in_array($loggedUser['role_id'],$role)){ ?>
                        <li>
                            <a class="waves-effect waves-dark" href="/employee-attendance/add" aria-expanded="false">
                                <i class="fa fa-arrow-right"></i>
                                <span>Add Attandence</span>
                            </a>
                        </li>
                        <li>
                            <a href="/hubstaff-hours/add"><i class="fa fa-arrow-right"></i>Upload Hubstaff CSV</a>
                        </li>
                        <li>
                            <a href="/hubstaff-hours/hubstaff-names"><i class="fa fa-arrow-right"></i>Hubstaff Names</a>
                        </li>
                    <?php } ?>
                        <li>
                            <a class="waves-effect waves-dark" href="/employee-attendance/index" aria-expanded="false">
                                <i class="fa fa-arrow-right"></i>
                                <span>Show Attendence</span>
                            </a>
                        </li>
                        <li><a href="/hubstaff-hours/index"><i class="fa fa-arrow-right"></i>Show Hubstaff Hours</a></li>
                    </ul>
                </li>
                <?php //} ?>

                <?php

                    if (in_array($loggedUser['role_id'], $role)) {?>
                    <li>
                        <a class="waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-tab"></i>
                            <span class="hide-menu">Desgination</span>
                        </a>
                        <ul>
                            <li><a href="/designations/add"><i class="fa fa-arrow-right"></i>Add Desgination</a></li>
                            <li><a href="/designations"><i class="fa fa-arrow-right"></i> List Desgination</a></li>
                        </ul>
                    </li>

                <?php
                    }
                $role = array(1,2);
                if (in_array($loggedUser['role_id'], $role)) {?>
                    <li>
                        <a class="waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-library"></i>
                            <span class="hide-menu">Department</span>
                        </a>
                        <ul>
                            <li><a href="/departments/add"><i class="fa fa-arrow-right"></i>Add Departments</a></li>
                            <li><a href="/departments"><i class="fa fa-arrow-right"></i> List Departments</a></li>
                        </ul>
                    </li>

                <?php } ?>
                <li>
                    <a class="waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa fa-bullhorn"></i>
                        <span class="hide-menu">Announcements</span>
                    </a>
                    <ul>
                    <?php
                    $role = array(1,2,3);
                        if (in_array($loggedUser['role_id'], $role)) {?>
                            <li><a href="/announcements/add"><i class="fa fa-arrow-right"></i>Add Announcement</a></li>
                    <?php
                        }
                    ?>
                        <li><a href="/announcements"><i class="fa fa-arrow-right"></i> List Announcements</a></li>
                    </ul>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa fa-user-circle-o"></i>
                        <span class="hide-menu">Process</span>
                    </a>
                    <ul>
                     <li><a href="/process-documentations/list-assign-processes"><i class="fa fa-arrow-right"></i>List Assign Processes</a></li>
                       <?php $role = array(1,2,3);
                           if (in_array($loggedUser['role_id'], $role)) { ?>
                            <li><a href="/process-documentations/index"><i class="fa fa-arrow-right"></i>Show Processes</a></li>
                            <li><a href="/process-documentations/add"><i class="fa fa-arrow-right"></i>Add Processes</a></li>
                            <li><a href="/process-documentations/review"><i class="fa fa-arrow-right"></i>Review Processes</a></li>
                            <li><a href="/process-documentations/assign-processes"><i class="fa fa-arrow-right"></i>Assign Processes</a></li>
                            <li><a href="/process-documentations/add-tags"><i class="fa fa-arrow-right"></i>Add Tags</a></li>
                        <?php  }
                         ?>
                    </ul>
                </li>
                <?php
                    $role = array(1,2,3,4,5,6);
                    if (in_array($loggedUser['role_id'], $role)) {?>
                <li>
                    <a class="waves-effect waves-dark" aria-expanded="false">
                        <i class="fa fa-cogs"></i>
                        <span class="hide-menu">Skills</span>
                    </a>
                    <ul>
                        <?php $role = array(1,2,3);
                           if (in_array($loggedUser['role_id'], $role)) { ?>
                                <li><a href="/skills/index"><i class="fa fa-arrow-right"></i>Show Skills</a></li>
                                <li><a href="/skills/add"><i class="fa fa-arrow-right"></i>Add Skills</a></li>
                                <li><a href="/skill-levels/index"><i class="fa fa-arrow-right"></i>show skill levels</a></li>
                                <li><a href="/skill-levels/add"><i class="fa fa-arrow-right"></i>Add skill levels</a></li>
                                <li>
                                <a class="waves-effect waves-dark" aria-expanded="false">
                                        <i class="fa fa-circle"></i>
                                        <span>Employee Skills</span>
                                    </a>
                                    <ul>
                                        <li><a href="/employee-skills/approval-index"><i class="fa fa-arrow-right"></i>Approve Employee Skills</a></li>
                                        <li><a href="/employee-skills/index"><i class="fa fa-arrow-right"></i>Approved Employee Skills</a></li>
                                        <li><a href="/employee-skills/rejected-index"><i class="fa fa-arrow-right"></i>Rejected Employee Skills</a></li>
                                    </ul>
                                </li>
                                <li>
                                <a class="waves-effect waves-dark" aria-expanded="false">
                                        <i class="fa fa-circle"></i>
                                        <span>Personal Skills</span>
                                    </a>
                                    <ul>
                                        <li><a href="/employee-skills/add"><i class="fa fa-arrow-right"></i>Add my Skills</a></li>
                                        <li><a href="/employee-skills/my-skills"><i class="fa fa-arrow-right"></i>My Skills</a></li>
                                    </ul>
                                </li>
                            <?php  }else {
                            ?>
                            <?php $role = array(4,5,6); ?>
                                <li><a href="/employee-skills/add"><i class="fa fa-arrow-right"></i>Add Skills</a></li>
                                <li><a href="/employee-skills/my-skills"><i class="fa fa-arrow-right"></i>My Skills</a></li>
                            <?php  
                            }
                         ?>
                    </ul>
                </li>
                <?php } ?>
                <li>
                    <a class="waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa fa-wpforms"></i>
                        <span class="hide-menu">Forms</span>
                    </a>
                    <ul>
                    <?php $role = array(1,2,3,5,6);
                        if (in_array($loggedUser['role_id'], $role)) { ?>
                            <li><a href="/forms/add"><i class="fa fa-arrow-right"></i> Add Form</a></li>
                            <li><a href="/forms"><i class="fa fa-arrow-right"></i> List Forms</a></li>
                    <?php  } ?>      
                        <li><a href="/form-submissions"><i class="fa fa-arrow-right"></i> Submissions</a></li>
                    </ul>
                </li>
            <?php
                $role = array(1,2);
                if (in_array($loggedUser['role_id'], $role)) {
            ?>
                <li>
                    <a class="waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa fa-university"></i>
                        <span class="hide-menu">Salary</span>
                    </a>
                    <ul>
                        <li><a href="/Salary"><i class="fa fa-arrow-right"></i>List</a></li>
                        <li><a href="/Salary/pending"><i class="fa fa-arrow-right"></i>Pending</a></li>
                    </ul>
                </li>
            <?php  } ?>
                <li>
                    <a class="waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="fa fa-address-book-o"></i>
                            <span class="hide-menu">Important Contacts</span>
                        </a>
                        <ul>
                            <li><a href="/important-contacts/index"><i class="fa fa-arrow-right"></i>All Contacts</a></li>
                            <?php
                            $role = array(1,2,3);
                                if (in_array($loggedUser['role_id'], $role)) { ?>
                            <li><a href="/important-contacts/add"><i class="fa fa-arrow-right"></i>Add Contacts</a></li>
                            <?php } ?>
                        </ul>
                </li>
                                <li>
                    <a class="waves-effect waves-dark" href="/Policies" aria-expanded="false">
                        <i class="fa fa-address-card-o"></i>
                        <span class="hide-menu">Policy</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>



