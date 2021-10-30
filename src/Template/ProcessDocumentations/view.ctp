<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProcessDocumentation $processDocumentation
 */
?>
<div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Process Documentation</h4>
            </div>
            <div class="card-body">
            <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <!-- <label class="control-label"><?php 
                                //__('Description')  ?>: </label> -->
                                
                                <fieldset>
                                    <legend> <?= $processDocumentation->title ?></legend>
                                    <?= $processDocumentation->description ?>
                                <fieldset>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>