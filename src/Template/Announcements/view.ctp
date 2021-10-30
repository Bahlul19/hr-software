<div class="row designation">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">View Announcement</h4>
            </div>
            <div class="card-body">
                <?php echo $this->Form->create($announcement) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label class="control-label">Announcement: </label>
                                    <?php
                                        echo $announcement->announcement;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="control-label">Start Date: </label>
                                <?php
                                    echo date('m/d/Y', strtotime(h($announcement->start_date)));
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">End Date: </label>
                                <?php
                                    echo date('m/d/Y', strtotime(h($announcement->end_date)));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="control-label">Office: </label>
                                <?php
                                    echo h($announcement->offices);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <?php
                            echo $this->Html->link(
                                __('Back'),
                                ['action' => 'index'], ['class' => 'btn btn-inverse']
                            );
                        ?>
                    </div>

                <?php echo $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
