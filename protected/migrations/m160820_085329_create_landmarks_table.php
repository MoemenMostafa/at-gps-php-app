<?php

class m160820_085329_create_landmarks_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('landmarks', array(
			'id' => 'pk',
			'company_id' => 'int NOT NULL',
			'name' => 'varchar(255)',
			'lat' => 'decimal(20,18)',
			'long' => 'decimal(20,18)',
			'icon' => 'varchar(255)'

		));

		$this->addForeignKey("fk_company_id_landmarks_company_id", "landmarks", "company_id", "company", "id", "CASCADE", "CASCADE");

	}

	public function down()
	{
		$this->dropForeignKey("fk_company_id_landmarks_company_id", "landmarks");

		$this->dropTable('landmarks');
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