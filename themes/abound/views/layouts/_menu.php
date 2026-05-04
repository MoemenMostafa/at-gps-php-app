 <?php


 		if ($this->userData->userType->level >=1){
		$subItemsReports =  array(
				//array('label'=>'Home', 'url'=>array('/site/index')),
				//array('label'=>'Abbreviated Old', 'url'=>array('/reports/abbreviated'),'active'=>$_GET['r']=='reports/abbreviated'?true:false),
				array('label'=>'Abbreviated', 'url'=>array('/reports/abbreviatedNew'),'active'=>$_GET['r']=='reports/abbreviatedNew'?true:false),
                array('label'=>'Abbreviated (new reports)', 'url'=>'https://app.at-gps.com/reports', 'linkOptions' => array('target' => '_blank'),'active'=>$_GET['r']=='reports/abbreviatedNew'?true:false),
                                //array('label'=>'Over Speeding Old', 'url'=>array('/reports/overSpeeding'),'active'=>$_GET['r']=='reports/overSpeeding'?true:false),
                                array('label'=>'Over Speeding', 'url'=>array('/reports/overSpeedingNew'),'active'=>$_GET['r']=='reports/overSpeeding'?true:false),
				array('label'=>'Over Speeding All', 'url'=>array('/reports/overSpeedingAll'),'active'=>$_GET['r']=='reports/overSpeedingAll'?true:false),
				array('label'=>'Disconnected Vehicles', 'url'=>array('/reports/disconnected'),'active'=>$_GET['r']=='reports/disconnected'?true:false),
                                array('label'=>'Vehciles And Drivers', 'url'=>array('/reports/vehiclesAndDrivers'),'active'=>$_GET['r']=='reports/vehiclesAndDrivers'?true:false),
                                array('label'=>'Charts', 'url'=>array('/reports/charts'),'active'=>$_GET['r']=='reports/charts'?true:false),
                                array('label'=>'Input Status', 'url'=>array('/reports/inputStatus'),'active'=>$_GET['r']=='reports/inputStatus'?true:false),
                                array('label'=>'Vehicles Distance', 'url'=>array('/reports/vehiclesDistance'),'active'=>$_GET['r']=='reports/vehiclesDistance'?true:false),
                                array('label'=>'Single Vehicle Distance', 'url'=>array('/reports/vehicleDistance'),'active'=>$_GET['r']=='reports/vehicleDistance'?true:false),
                                array('label'=>'Vehicles Distance Details', 'url'=>array('/reports/vehiclesDistanceDetails'),'active'=>$_GET['r']=='reports/vehiclesDistanceDetails'?true:false),
                                array('label'=>'Vehicles Distance Accumulative', 'url'=>array('/reports/vehiclesDistanceAccumulative'),'active'=>$_GET['r']=='reports/vehiclesDistanceAccumulative'?true:false),
                                array('label'=>'Vehicles Speed Zone', 'url'=>array('/reports/vehicleSpeedZone'),'active'=>$_GET['r']=='reports/vehicleSpeedZone'?true:false),

                    );
		$subItemsSettings = array(
                                array('label'=>'Personal Settings', 'url'=>array('/user&id='.Yii::app()->user->id),'active'=>$this->id=='user'?true:false),
				array('label'=>'My Alerts', 'url'=>array('/userSettings&id='.Yii::app()->user->id),'active'=>$this->id=='userSettings'?true:false),
				array('itemOptions'=>array('class'=>'divider')),
				array('label'=>'Logout', 'url'=>array('/site/logout')),
                                );

		$subItemsService = array(
                                array('label'=>'Maintenence', 'url'=>array('/maintenence/index&sort=KmToMaint'),'active'=>$this->id=='maintenence'?true:false, 'visible'=>!Yii::app()->user->isGuest),						
                                array('label'=>'Repairs', 'url'=>array('/repairs/index&sort=vehicle.serial&Repairs_sort=vehicle.serial'),'active'=>$this->id=='repairs'?true:false, 'visible'=>!Yii::app()->user->isGuest),						
                                );
                
                }
 
	
		if ($this->userData->userType->level >=600){
		$subItemsAdmin =  array(
				array('label'=>'Users', 'url'=>array('/userAdmin'),'active'=>$this->id=='userAdmin'?true:false),
				array('label'=>'Drivers', 'url'=>array('/driver'),'active'=>$this->id=='driver'?true:false),
                array('label'=>'Speed Zones', 'url'=>array('/speedZone'),'active'=>$this->id=='speedZone'?true:false),
				array('label'=>'Routes', 'url'=>array('/route'),'active'=>$this->id=='route'?true:false),
                                
				array('label'=>'Trips', 'url'=>array('/trip'),'active'=>$this->id=='trip'?true:false),
                                array('label'=>'Locations', 'url'=>array('/location'),'active'=>$this->id=='location'?true:false),
				array('label'=>'Users Alerts', 'url'=>array('/userSettingsAdmin'),'active'=>$this->id=='userSettingsAdmin'?true:false),
				array('label'=>'Maintenance', 'itemOptions'=>array('class'=>'divider'), 
                                    'items'=>array(
                                            array('label'=>'Items', 'url'=>array('/maintItem'),'active'=>$this->id=='maintItem'?true:false),
                                            array('label'=>'Item Brands', 'url'=>array('/maintItemBrand'),'active'=>$this->id=='maintItemBrand'?true:false),
                                            array('label'=>'Item Groups', 'url'=>array('/maintGroup'),'active'=>$this->id=='maintGroup'?true:false),
                                            array('label'=>'Setup', 'url'=>array('/maintSetup'),'active'=>$this->id=='maintSetup'?true:false),
                                    )
                                )
                    ); 
		$subItemsSettings = array(
                                array('label'=>'Personal Settings', 'url'=>array('/user&id='.Yii::app()->user->id),'active'=>$this->id=='user'?true:false),
				array('label'=>'Company Settings', 'url'=>array('/Company&id='.Yii::app()->user->company_id),'active'=>$this->id=='company'?true:false),
				array('label'=>'My Alerts', 'url'=>array('/userSettings&id='.Yii::app()->user->id),'active'=>$this->id=='userSettings'?true:false),
				array('itemOptions'=>array('class'=>'divider')),
                                array('label'=>'Logout', 'url'=>array('/site/logout')),
                                );
		}
		
		 if ($this->userData->userType->level >=1000){
		$subItemsAdmin =  array(
				
				array('label'=>'Users', 'url'=>array('/userAdmin'),'active'=>$this->id=='userAdmin'?true:false),
				array('label'=>'User Types', 'url'=>array('/userType'),'active'=>$this->id=='userType'?true:false),
				array('label'=>'Companies', 'url'=>array('/companyAdmin'),'active'=>$this->id=='companyAdmin'?true:false),
				array('label'=>'Vehicles', 'url'=>array('/vehicle'),'active'=>$this->id=='vehicle'?true:false),
				array('label'=>'Vehicle Types', 'url'=>array('/vehicleType'),'active'=>$this->id=='vehicleType'?true:false),
				array('label'=>'Devices', 'url'=>array('/device'),'active'=>$this->id=='device'?true:false),
				array('label'=>'Device Types', 'url'=>array('/deviceType'),'active'=>$this->id=='deviceType'?true:false),
				array('label'=>'Drivers', 'url'=>array('/driver'),'active'=>$this->id=='driver'?true:false),
				array('label'=>'Vehicle Driver', 'url'=>array('/vehicleDrivers'),'active'=>$this->id=='vehicleDrivers'?true:false),
                array('label'=>'Speed Zones', 'url'=>array('/speedZone'),'active'=>$this->id=='speedZone'?true:false),
				array('label'=>'Routes', 'url'=>array('/route'),'active'=>$this->id=='route'?true:false),
				array('label'=>'Trips', 'url'=>array('/trip'),'active'=>$this->id=='trip'?true:false),
                                array('label'=>'Locations', 'url'=>array('/location'),'active'=>$this->id=='location'?true:false),
				array('label'=>'Users Alerts', 'url'=>array('/userSettingsAdmin'),'active'=>$this->id=='userSettingsAdmin'?true:false),
                                array('label'=>'Commands', 'itemOptions'=>array('class'=>'divider'), 
                                    'items'=>array(
                                        array('label'=>'Manage', 'url'=>array('/deviceCommands'),'active'=>$this->id=='deviceCommands'?true:false),
                                        array('label'=>'Send', 'url'=>array('/commands'),'active'=>$this->id=='Commands'?true:false),
                                    )
                                ),
                                array('label'=>'Export Data', 'itemOptions'=>array('class'=>'Export'), 
                                    'items'=>array(
                                        array('label'=>'Export Offline Data', 'url'=>array('/vehicle/export'),'active'=>$this->id=='vehicle'?true:false),
                                    )
                                ),
                                array('label'=>'Maintenance', 'itemOptions'=>array('class'=>'divider'), 
                                    'items'=>array(
                                                array('label'=>'Items', 'url'=>array('/maintItem'),'active'=>$this->id=='maintItem'?true:false),
                                                array('label'=>'Item Brands', 'url'=>array('/maintItemBrand'),'active'=>$this->id=='maintItemBrand'?true:false),
                                                array('label'=>'Item Groups', 'url'=>array('/maintGroup'),'active'=>$this->id=='maintGroup'?true:false),
                                                array('label'=>'Setup', 'url'=>array('/maintSetup'),'active'=>$this->id=='maintSetup'?true:false),
                                    )
                                )
                         ); 
		}
		
 ?>  