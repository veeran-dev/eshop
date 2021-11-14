<?php 
class Language extends LanguageCore
{
	public static function getAllLanguages()
	{
		return Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'lang`');
	}
}
?>