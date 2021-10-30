<div class="form-group">
    <div class="input text required">
        <?php 
        echo $this->Form->control('reliever', [
                'class' => 'form-control',
                'empty' => 'Select Reliever',
                'options' => $reliever,
                'maxlength'=>100,
                'id' => 'reliever',
                'label' => 'Reliever * ',
                'required' => 'true',
                'onchange' => 'return calcualteHalfLWOP()'
            ]
        );
        ?>                                    
    </div>
</div>