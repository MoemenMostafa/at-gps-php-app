<?php
/* @var $this UserSettingsController */
/* @var $model UserSettings */
/* @var $form CActiveForm */
?>

<div class="form">

<?php 

$this->widget('ext.ibutton.IButton', array(
            'selector'=>':checkbox',
            'options' =>array(
                'duration' => 250,
                //'change'=>'js:function(){alert("ooohay! it has been changed!");}'
            )
    ));


$form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-settings-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

        <table>
            <thead>
                    <th></th>
                    <th style="color:white">Sound-Alert on/off</th>
                    <th style="color:white">Value to trigger Sound-Alert</th>
            </thead>
            <tr>
                <td>
                        <?php echo $form->labelEx($model,'geofence'); ?>
                </td>
                <td>
                        <?php echo $form->checkBox($model,'geofence'); ?>
                        <?php echo $form->error($model,'geofence'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->labelEx($model,'overspeed'); ?>
                </td>
                <td>
                    <?php echo $form->checkBox($model,'overspeed'); ?>
                    <?php echo $form->error($model,'overspeed'); ?>
                </td>
                <td>
                    <?php echo $form->textField($model,'overspeed_SoundAlertValue'); ?>
                    Km/h
                    <?php echo $form->error($model,'overspeed_SoundAlertValue'); ?>

                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->labelEx($model,'rpm'); ?>
                </td>
                <td>
                    <?php echo $form->checkBox($model,'rpm'); ?>
                    <?php echo $form->error($model,'rpm'); ?>
                </td>
                <td>
                    <?php echo $form->textField($model,'rpm_SoundAlertValue'); ?>
                    rpm
                    <?php echo $form->error($model,'rpm_SoundAlertValue'); ?>
                </td>                   
            </tr>

            <tr>
                <td>
                    <?php echo $form->labelEx($model,'fueltemp'); ?>
                </td>
                <td>
                    <?php echo $form->checkBox($model,'fueltemp'); ?>
                    <?php echo $form->error($model,'fueltemp'); ?>
                </td>
                <td>
                    <?php echo $form->textField($model,'fueltemp_SoundAlertValue'); ?>
                    C
                    <?php echo $form->error($model,'fueltemp_SoundAlertValue'); ?>
                </td> 
            </tr>

            <tr>
                <td>
                    <?php echo $form->labelEx($model,'oilpres'); ?>
                </td>
                <td>
                    <?php echo $form->checkBox($model,'oilpres'); ?>
                    <?php echo $form->error($model,'oilpres'); ?>
                </td>
                <td>
                    <?php echo $form->textField($model,'oilpres_SoundAlertValue'); ?>
                    bar
                    <?php echo $form->error($model,'oilpres_SoundAlertValue'); ?>
                </td> 
            </tr>

            <tr>
                <td>
                    <?php echo $form->labelEx($model,'engtemp'); ?>
                </td>
                <td>
                    <?php echo $form->checkBox($model,'engtemp'); ?>
                    <?php echo $form->error($model,'engtemp'); ?>
                </td>
                <td>
                    <?php echo $form->textField($model,'engtemp_SoundAlertValue',array('1'=>'On','0'=>'Off')); ?>
                    C
                    <?php echo $form->error($model,'engtemp_SoundAlertValue'); ?>
                </td> 
            </tr>

            <tr>
                <td>
                    <?php echo $form->labelEx($model,'fuellevel'); ?>
                </td>
                <td>
                    <?php echo $form->checkBox($model,'fuellevel'); ?>
                    <?php echo $form->error($model,'fuellevel'); ?>
                </td>
                <td>
                    <?php echo $form->textField($model,'fuellevel_SoundAlertValue'); ?>
                    %
                    <?php echo $form->error($model,'fuellevel_SoundAlertValue'); ?>
                </td> 
            </tr>

            <tr>
                <td>
                    <?php echo $form->labelEx($model,'fuelrate'); ?>
                </td>
                <td>
                    <?php echo $form->checkBox($model,'fuelrate'); ?>
                    <?php echo $form->error($model,'fuelrate'); ?>
                </td>
                <td>
                    <?php echo $form->textField($model,'fuelrate_SoundAlertValue'); ?>
                    <?php echo $form->error($model,'fuelrate_SoundAlertValue'); ?>
                </td> 
            </tr>

            <tr>
                <td>
                    <?php echo $form->labelEx($model,'accpedal'); ?>
                </td>
                <td>
                    <?php echo $form->checkBox($model,'accpedal'); ?>
                    <?php echo $form->error($model,'accpedal'); ?>
                </td>
                <td>
                    <?php echo $form->textField($model,'accpedal_SoundAlertValue'); ?>
                    %
                    <?php echo $form->error($model,'accpedal_SoundAlertValue'); ?>
                </td> 
            </tr>
       </table>
            <div class="row buttons">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
            </div>
        

<?php $this->endWidget(); ?>

</div><!-- form -->