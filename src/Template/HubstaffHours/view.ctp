<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HubstaffHours $HubstaffHours
 */
?>
<div class="HubstaffHourss large-9 medium-8 columns content">
<br>
    <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Hubstaff Report for : <?= $date ?></h4>
                </div>
                <div class="card-body">
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="control-label">Name Of Employee: </label>
                                        <?= h($hubstaffName) ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <?php $avgActivity=0; $count=0;
                                            foreach($HubstaffHours as $HubstaffHour) : 
                                                $activities=$HubstaffHour['activity'];
                                                $act=explode("%",$activities);
                                                $avgActivity+=(int)$act[0];
                                                $count++;
                                            ?>
                                                <div class="row"> 

                                                <div class="card-header col-md-12">
                                                    <h4 class="m-b-0 text-white"> Project : <?= $HubstaffHour->project; ?></h4>
                                                </div>
                                                <div class="col-md-12">
                                                <br>
                                                </div>
                                                    <div class="col-md-6">
                                                        <label> Time Zone :</label> 
                                                        <?= $HubstaffHour->time_zone; ?>
                                                    </div>
                                                    <div class="col-md-6">
                
                                                    <label> Date : </label> 
                                                        <?= $HubstaffHour->date; ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <label> Task Id :</label> 
                                                        <?= ($HubstaffHour->task_id)=="" ? "N/A":$HubstaffHour->task_id; ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <label> Time Spent :</label> 
                                                        <?= date("H:i:s",strtotime($HubstaffHour->time)); ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <label> Activity :</label> 
                                                        <?= $HubstaffHour->activity; ?>
                                                    </div>
                                                    <div class="col-md-12">
                                                    <label> Notes :</label> 
                                                        <?= ($HubstaffHour->notes)=="" ? "N/A":$HubstaffHour->notes; ?>
                                                    </div>
                                                    <br><br>
                                            </div>
                                    <?php endforeach; 
                                        $avgActivity/=$count;
                                        $avgActivity.="%";   
                                    ?><br> 
                                </div>
                              
                               <div class="col-md-12 card-header"> 
                                    <label class="text-white"> Overall Activity  : 
                                    <?= $avgActivity; ?></label> 
                                </div>
                            </div> 
                           
                        </div>
                </div>
            </div>
        </div>
</div>
