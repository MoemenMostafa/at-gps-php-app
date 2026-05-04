<?php

class m151021_094128_speed_zone_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('speed_zone', array(
			'id' => 'pk',
			'company_id' => 'int NOT NULL',
			'name' => 'varchar(255)',
			'speed_limit' => 'int NOT NULL',
			'points' => 'text',

		));

		$this->addForeignKey("fk_company_id_speed_zone_company_id", "speed_zone", "company_id", "company", "id", "CASCADE", "CASCADE");

	}

	public function down()
	{
		$this->dropForeignKey("fk_company_id_speed_zone_company_id", "speed_zone");

		$this->dropTable('speed_zone');
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