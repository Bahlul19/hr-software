<div class="row employees">
    <div class="col-lg-12 remove-padding">
        <div class="card card-outline-info form-material">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="m-b-0 text-white">My Profile</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="accordion" role="tablist">
                    <?php
                        echo $this->element('profile/personal-info');
                        echo $this->element('profile/work-details');
                        echo $this->element('profile/change-password');
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
