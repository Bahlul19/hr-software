<div class="row" id="dashbord-title">
    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
        <div class="">
            <div class="card-body" id="bottom-padding-0px">
                <h4 class="card-title" id="1">Company Motto/Slogan</h4>
                <p>
                    &bull; Employee happiness generates client success.
                </p>

                <h4 class="card-title" id="1">Company Vision</h4>
                <p>
                   &bull; To continuously work hard towards clients success.
                </p>
                <p>
                   &bull; To have a happy productive workforce working together with the same vision.
                </p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
        <div class="">
            <div class="card-body" id="bottom-padding-0px">
                <h4 class="card-title" id="1">SJ Core Culture</h4>
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-sm-12 col-12">
                        <p> &bull; Be Humble</p>
                        <p> &bull; Do Great Things</br> &nbsp; Together</p>
                        <p> &bull; Work To Make Client</br> &nbsp; Successful</p>
                    </div>
                    <div class="col-md-12 col-lg-6 col-sm-12 col-12">
                        <p> &bull; Take Accountability</p>
                        <p> &bull; Embrace challenge and</br> &nbsp; Grow yourself</p>
                        <p> &bull; Help each other</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row card">
  <div class="col-md-12 ribbon-wrapper">
       <label class="ribbon ribbon-default">Review forms</label>
     <table class="table table-hover">
       <thead>
         <th>Id</th>
         <th>Name</th>
         <th>Description</th>
         <th>Link</th>
       </thead>
        <tbody>
        <?php 
        if(!empty($formResult->toArray())){
            $empty=1;
            $index=1;
            foreach($formResult as $key => $form){
                if(!empty($form['form_visibility'])){
                    $empids = array_map(create_function('$o', 'return $o->employee_id;'), $form['form_feedback_for']);       
                    if(($form['form_field']['field_data']!="" || $form['form_field']==null ) && !in_array($empid,$empids) ){ 
                        $empty=0; ?>
                        <tr>
                            <td><?= ($index++) ?></td>
                            <td><?= $form['title'] ?></td>
                            <td><?= $form['description'] ?></td>
                            <!-- <td><a href="<?php // "/formview/".$form['slug'] ?>">Submit Review</a></td> -->
                            <td>
                             <?php 
                             echo $this->Html->link(
                                'Submit Review',
                                ['controller' => 'Forms', 'action' => 'formView',$form['slug']]
                            );
                             ?>
                            </td>
                        </tr>
                    <?php 
                    }else{
                          if($empty!=0){
                            $empty=1;
                           }
                        }
                    }
                }
                if($empty==1){
                    ?>
                        <tr>
                        <td colspan="4">No Review forms are available</td>
                    </tr>
          <?php  
                }
        }else{ ?>
            <tr>
                <td colspan="4">No Review forms are available</td>
            </tr>
        <?php }
        ?>
       </tbody>
     </table>
  </div>
</div>
<div class="row">
    <div class="col-md-6 padding-remove-left">
        <div class="ribbon-wrapper card left-leave-card">
            <div class="ribbon ribbon-default"><i class="fa fa-location-arrow"></i>&nbsp;&nbsp;Employees on leave</div>
            <div style="height:400px;overflow-y:auto;overflow-x: hidden;">
                <table class="table table-hover sticky-tab">
                    <thead>
                        <tr>
                            <th class="sticky" scope="col">Employee </th>
                            <th class="sticky" scope="col">From</th>
                            <th class="sticky" scope="col">To</th>
                            <th class="sticky" scope="col">Reliever</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employeeOnLeave as $leaveRequest):  ?>
                        <tr>
                            <td style="color: #007bff;"><?= $leaveRequest->employee_name; ?></td>
                            <td><?= date('m/d/Y',strtotime(h($leaveRequest->min_date))); ?></td>
                            <td><?= date('m/d/Y',strtotime(h($leaveRequest->max_date)));?></td>
                            <td><?= h($leaveRequest->reliever_name);?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 padding-remove-right">

                <div class="ribbon-wrapper card">
            <div class="ribbon ribbon-default"><i class="fa fa-microphone"></i> Latest Announcement</div>
            <?php
                $i = 1;
                foreach($results as  $result):

            ?>
                <p class="ribbon-content">
                    <h4 class="card-title" id="1">
                    <?php
                        echo   $i++."."." <span>";
                        echo $this->Html->Link(
                            $result['title'],
                            'announcement-modal', array(
                                'data-toggle' => 'modal',
                                'escape' => false,
                                'class' => 'announcement-view',
                                'data-id' => $result['id']
                            )
                        );
                        echo " | ".date('d M Y',strtotime($result['start_date']))."</span>";

                        if(in_Array($result['id'],$addNewTag)){
                            echo " <span>".$this->Html->image("/img/new-gif.gif",['class'=>'new-announcement-img'])."</span>";
                        }
                    ?>
                    </h4>
                </p>

            <?php endforeach;?>
            <?php echo $this->element('announcement-modal'); ?>
        </div>

        <div class="ribbon-wrapper card">
            <div class="ribbon ribbon-default"><i class="fa fa-birthday-cake"></i> Employee Birthdays</div>
            <?php
                $i = 1;
                foreach($employeeBirthdays as  $birthday):
            ?>
                <p class="ribbon-content">
                    <h4 class="card-title" id="1">
                    <?php
                        echo   date('M d',strtotime($birthday['birth_date']))." - ";
                        echo  $birthday['first_name'].' '.$birthday['last_name'];
                        // echo " | ".date('d M',strtotime($birthday['birth_date']));
                    ?>
                    </h4>
                </p>
            <?php endforeach;?>
        </div>
        <div class="ribbon-wrapper card">
            <div class="ribbon ribbon-default"><i class="fa fa-gift"></i> Employee Anniversary</div>
            <?php
                $i = 1;
                foreach($employeeAnniversary as  $anniversary):
            ?>
                <p class="ribbon-content">
                    <h4 class="card-title" id="1">
                    <?php
                        echo   $i++."."." ";
                        echo  $anniversary['first_name'].' '.$anniversary['last_name'];
                        echo " - ".$anniversary['years']." years anniversary";
                    ?>
                    </h4>
                </p>

            <?php endforeach;?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="ribbon-wrapper card scrolling">
            <div class="ribbon ribbon-default"><i class="fa fa-plane"></i> Holidays</div>
            <p class="ribbon-content">
                <h4 class="card-title" id="1">
                <br />
                    <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;height=450&amp;wkst=1&amp;bgcolor=%23ffffff&amp;src=sjinnovation.com_g92qesbhrlujhn9oq55md1aj88%40group.calendar.google.com&amp;color=%236B3304&amp;ctz=Asia%2FDhaka" style="border-width:0" width="100%" height="400" frameborder="0" scrolling="no"></iframe>
                </h4>
            </p>
        </div>
    </div>
</div>


