<?php
class WorldsModel extends RelationModel{
	protected $_link=array(
		'response'=>array(
			'mapping_type'=>HAS_MANY,
			'class_name'=>'worlds_responses',
			'foreign_key'=>'w_id',
			'mapping_order'=>'r_id'
		),
		'pic'=>array(
			'mapping_type'=>HAS_MANY,
			'class_name'=>'worlds_pics',
			'foreign_key'=>'w_id',
			'mapping_order'=>'p_id desc'
		)
	);

	protected $_validate=array
	(
		array('w_text','require','操作失败！')
	);

}
?>