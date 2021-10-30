<div class="row employees">
    <div class="col-lg-12">
        <div class="card card-outline-info form-material">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="m-b-0 text-white">View Employee</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="accordion" role="tablist">
                    <?php
                        echo $this->element('employee-form-parts/personal-info');
                        echo $this->element('employee-form-parts/work-details');
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
