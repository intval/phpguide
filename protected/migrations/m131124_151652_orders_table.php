<?php

class m131124_151652_orders_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('orders', [
            'id' => 'pk',
            'buyer' => 'integer',
            'buyer_email' => 'string',
            'product' => 'string',
            'time' => 'datetime',
            'ip' => 'string',
            'txid' => 'string',
            'data' => 'text'
        ]);

        $this->createIndex('ordertxid', 'orders', 'txid');
        $this->createIndex('orderip', 'orders', 'ip');
	}

	public function down()
	{
        $this->dropIndex('orderip', 'orders');
        $this->dropIndex('ordertxid', 'orders');
		$this->dropTable('orders');
	}
}