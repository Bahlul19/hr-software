<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportantContact $importantContact
 */
?>
<div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">View Contact Information</h4>
            </div>
            <div class="card-body">
            <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="control-label">Name Of Contact: </label>
                                <?= h($importantContact->name_of_contact) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= __('Contact No') ?>: </label>
                                <?= h($importantContact->contact_no) ?>
                            </div>
                        </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="control-label"><?= __('Contact Type') ?>: </label>
                                    <?= h($importantContact->type == 1 ? 'mobile':"Landline") ?>
                                </div>
                            </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= __('Locations') ?>: </label>
                                <?= $locations ?>
                            </div>
                        </div>
                        <?php if($roleId<4)
                        {?>
                            <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="control-label"><?= __('Roles') ?>: </label>
                                        <?= $role ?>
                                    </div>
                            </div>
                        <?php }?>
                </div>
            </div>
        </div>
    </div>
