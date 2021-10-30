<div class="row" id="policy">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">View Policy</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label center-text" style="text-align: center;">
                                <?php
                                    echo $policy->title;
                                ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Office: </label>
                                <?php
                                    switch ($policy->office) {
                                        case 'All-Offices':
                                            echo 'All-Offices';
                                            break;
                                        case 'SYL':
                                            echo "Sylhet";
                                            break;
                                        case 'DHK':
                                                echo "Dhaka";
                                            break;
                                        case 'UKR':
                                                echo "Ukraine";
                                            break;
                                        case 'GOA':
                                                echo "Goa";
                                            break;
                                        case 'NYC':
                                                echo "New York";
                                            break;
                                            
                                    }
                                ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Policy: </label>
                                <?php
                                    echo $policy->policies;
                                ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Modified: </label>
                            <?php
                                echo date('m/d/y',strtotime(h($policy->modified)));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Created: </label>
                            <?php
                                echo date('m/d/y',strtotime(h($policy->created)));
                            ?>
                        </div>
                    </div>
                </div>
        <?php
            if($role == 1){
        ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Updated By: </label>
                            <?php
                                echo h($policy->updated_by);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Approved By: </label>
                            <?php
                                echo h($policy->approved_by);
                            ?>
                        </div>
                    </div>
                </div>
        <?php } ?>
                <div class="form-actions">
                    <?php
                        if($policy->is_approved == 0){
                            echo $this->Html->link(
                                __(
                                    $this->Html->tag('', 'Approve')
                                ),
                                ['action' => 'approve',$policy->id],
                                ['class'=>'btn btn-primary'],
                                ['escape' => false,]
                            );   
                            echo $this->Html->link(
                              __('Back'),
                                ['action' => 'pending'], ['class' => 'btn btn-inverse']
                            );
                             
                        } else {
                            echo $this->Html->link(
                                __('Back'),
                                ['action' => 'index'], ['class' => 'btn btn-inverse']
                            );
                        }
                    ?>

                    <?php
                        if($role == 1) {
                            echo $this->Html->link(
                                __('Edit Policy'),
                                ['action' => 'edit', $policy->id], ['class' => 'btn btn-primary']);
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

