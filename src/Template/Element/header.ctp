<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">
                <b>
                    <?php
                        if($loggedUser['role_id'] == 1){ echo "Super Admin"; }
                        if($loggedUser['role_id'] == 2){echo "HR Admin";}
                        if($loggedUser['role_id'] == 3){echo " Admin";}
                        if($loggedUser['role_id'] == 4){echo "Member";}
                        if($loggedUser['role_id'] == 5){echo "Project Manager";}
                        if($loggedUser['role_id'] == 6){echo "Team Lead";}
                    ?>
                </b>
            </a>
        </div>

        <div class="navbar-collapse">
            <ul class="navbar-nav mr-auto mt-md-0">
                <li class="nav-item">
                    <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)">
                        <i class="mdi mdi-menu"></i>
                    </a>
                </li>

                <li class="nav-item m-l-10">
                    <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)">
                        <i class="ti-menu"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav my-lg-0">
                <?php if($loggedUser['role_id'] == 1 || $loggedUser['role_id'] == 2 || $loggedUser['role_id'] == 3){ ?>
                    <a href="/employee-skills/approval-index" class="skill-notification">
                        <span class="badge"></span>
                        <span class="tooltiptext">Skill approval requests</span>
                    </a>
                <?php } ?>
                <?php if(!empty($loggedUser['office_location'])):?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if($loggedUser['office_location'] == 'GOA') {?>
                            <i class="flag-icon flag-icon-in"></i>
                        <?php } elseif ($loggedUser['office_location'] == 'NYC') { ?>
                            <i class="flag-icon flag-icon-us"></i>
                        <?php } elseif ($loggedUser['office_location'] == 'SYL') { ?>
                            <i class="flag-icon flag-icon-bd"></i>
                        <?php } elseif ($loggedUser['office_location'] == 'DHK') { ?>
                            <i class="flag-icon flag-icon-bd"></i>
                        <?php } elseif ($loggedUser['office_location'] == 'UKR') { ?>
                            <i class="flag-icon flag-icon-ua"></i>
                        <?php } ?>
                    </a>
                </li>
                <?php endif;?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark " href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-settings text-white"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right scale-up">
                        <ul class="dropdown-user">
                            <li role="separator" class="divider"></li>
                            <li>
                                <?php
                                    echo $this->Html->link(
                                        '<i class="fa fa-power-off"></i> Logout',
                                        array (
                                            'controller' => 'Employees',
                                            'action' => 'logout',
                                        ),
                                        array(
                                            'escape' => false
                                        )
                                    );
                                ?>
                            </li>

                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
