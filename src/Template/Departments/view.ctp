<div class="row department">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">View Department</h4>
            </div>
            <div class="card-body">
                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Name :</label>
                                    <?php
                                        echo $department->name;
                                    ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Lead :</label>
                                    <?php
                                        echo $department->lead;
                                    ?>
                            </div>
                        </div>
                </div>
                <div class="row">
                       <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">No of Employess: </label>
                                <?php
                                    echo $department->no_of_employees;
                                ?>
                            </div>
                        </div>
                       <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Status: </label>
                                <?php
                                    echo ($department->status==1 ? 'active' : 'inactive');
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



