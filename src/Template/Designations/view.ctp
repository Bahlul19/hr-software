<div class="row designation">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
            <h4 class="m-b-0 text-white">View Designation</h4>
            </div>
            <div class="card-body">
                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Title :</label>
                                    <?php
                                        echo $designation->title;
                                    ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">No of Employess: </label>
                                <?php
                                    echo $designation->no_of_employees;
                                ?>
                            </div>
                        </div>
                </div>
                <div class="row">
                       <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Status: </label>
                                <?php
                                    echo ($designation->status==1 ? 'active' : 'inactive');
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
            </div>
        </div>
    </div>
</div>





