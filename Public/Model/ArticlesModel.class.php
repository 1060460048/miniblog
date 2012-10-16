<?php
class ArticlesModel extends RelationModel {
	protected $_link=array(
		'content'=>array(
			'mapping_type'=>HAS_ONE,
			'class_name'=>'content',
			'foreign_key'=>'id'
		)
	);
}
?>