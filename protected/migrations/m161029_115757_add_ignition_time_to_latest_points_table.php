<?php

class m161029_115757_add_ignition_time_to_latest_points_table extends CDbMigration
{
	public function up()
	{
		$this->addColumn('latest_points', 'ignition_time', 'datetime');
	}

	public function down()
	{
		$this->dropColumn('latest_points', 'ignition_time');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}