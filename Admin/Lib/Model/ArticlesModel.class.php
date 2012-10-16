<?php
class ArticlesModel extends RelationModel {
	protected $_link=array(
		'content'=>array(
			'mapping_type'=>HAS_ONE,
			'class_name'=>'articles_content',
			'foreign_key'=>'id',
			'as_fields'=>'text'
		)
	);
}
?>