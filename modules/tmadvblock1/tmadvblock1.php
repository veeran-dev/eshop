<?php
if (!defined('_PS_VERSION_'))
	exit;
class TMAdvblock1 extends Module
{
	public $adv_link;
	public $adv_title;
	public $adv_img;
	public $adv_imgname = 'advertising_custom';
	public function __construct()
	{
		$this->name = 'tmadvblock1';
		$this->tab = 'front_office_features';
		$this->version = 1.4;
		$this->author = 'TM';
		$this->need_instance = 0;
		parent::__construct();
		$this->displayName = $this->l('TM Advertising Block #1');
		$this->description = $this->l('Adds a block to display an advertisement');
		if (!file_exists(_PS_MODULE_DIR_.$this->name.'/'.$this->adv_imgname.'.'.Configuration::get('TMADVBLOCK1_IMG_EXT')))
		{
			$this->adv_imgname = 'slide0';
			if (!file_exists(_PS_MODULE_DIR_.$this->name.'/slide0.jpg'))
				$this->adv_imgname = '';
			else
				Configuration::updateValue('TMADVBLOCK1_IMG_EXT','jpg');
		}
		if (!empty($this->adv_imgname))
			$this->adv_img = Tools::getMediaServer($this->name)._MODULE_DIR_.$this->name.'/'.$this->adv_imgname.'.'.Configuration::get('TMADVBLOCK1_IMG_EXT');

		$this->adv_link = htmlentities(Configuration::get('TMADVBLOCK1_LINK'), ENT_QUOTES, 'UTF-8');
		$this->adv_title = htmlentities(Configuration::get('TMADVBLOCK1_TITLE'), ENT_QUOTES, 'UTF-8');
	}
	public function install()
	{
		Configuration::updateValue('TMADVBLOCK1_LINK', 'cms.php?id_cms=1');
		if (!parent::install())
			return false;
		if (!$this->registerHook('rightColumn'))
			return false;
		return true;
	}
	private function _deleteCurrentImg()
	{

		if (file_exists(_PS_MODULE_DIR_.$this->name.'/'.$this->adv_imgname.'.'.Configuration::get('TMADVBLOCK1_IMG_EXT')))
			unlink(_PS_MODULE_DIR_.$this->name.'/'.$this->adv_imgname.'.'.Configuration::get('TMADVBLOCK1_IMG_EXT'));
		$this->adv_imgname = $this->adv_imgname == 'advertising_custom'?'advertising':'';
	}
	public function postProcess()
	{
		global $currentIndex;
		$errors = '';
		if (Tools::isSubmit('submitDeleteImgConf'))
			$this->_deleteCurrentImg();	
		if (Tools::isSubmit('submitAdvConf'))
		{
			$file = false;
			if (isset($_FILES['adv_img']) AND isset($_FILES['adv_img']['tmp_name']) AND !empty($_FILES['adv_img']['tmp_name']))
			{
				if ($error = checkImage($_FILES['adv_img'], Tools::convertBytes(ini_get('upload_max_filesize'))))
					$errors .= $error;
				elseif ($dot_pos = strrpos($_FILES['adv_img']['name'],'.'))
				{
					$this->_deleteCurrentImg();
					$this->adv_imgname = 'advertising';
					$ext = substr($_FILES['adv_img']['name'], $dot_pos+1);
					$newname = 'advertising_custom';
					if (!move_uploaded_file($_FILES['adv_img']['tmp_name'],_PS_MODULE_DIR_.$this->name.'/'.$newname.'.'.$ext))
						$errors .= $this->l('Error move uploaded file');
					else
						$this->adv_imgname = $newname;
					Configuration::updateValue('TMADVBLOCK1_IMG_EXT',$ext);
					$this->adv_img = Tools::getMediaServer($this->name)._MODULE_DIR_.$this->name.'/'.$this->adv_imgname.'.'.Configuration::get('TMADVBLOCK1_IMG_EXT');
				}
			}
			if ($link = Tools::getValue('adv_link'))
			{
				Configuration::updateValue('TMADVBLOCK1_LINK', $link);
				$this->adv_link = htmlentities($link, ENT_QUOTES, 'UTF-8');
			}
			if ($title = Tools::getValue('adv_title'))
			{
				Configuration::updateValue('TMADVBLOCK1_TITLE', $title);
				$this->adv_title = htmlentities($title, ENT_QUOTES, 'UTF-8');
			}
		}
		if ($errors)
			echo $this->displayError($errors);
	}
	public function getContent()
	{
		global $protocol_content;
		$this->postProcess();
		$output = '';
		$output .= '
<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post" enctype="multipart/form-data">
<fieldset><legend>'.$this->l('Advertising block configuration').'</legend>
<a href="'.$this->adv_link.'" target="_blank" title="'.$this->adv_title.'">';
		if ($this->adv_img)
		{
			$output .= '<img src="'.$protocol_content.$this->adv_img.'" alt="'.$this->adv_title.'" title="'.$this->adv_title.'" style="height:163px;margin-left: 100px;width:163px"/>';
			$output .= '<input class="button" type="submit" name="submitDeleteImgConf" value="'.$this->l('Delete image').'" style=""/>';
		}
		else
			$output .= '<div style="margin-left: 100px;width:163px;">'.$this->l('no image').'</div>';
		$output .= '</a>';
		$output .= '<br/>
<br/>
<label for="adv_img">'.$this->l('Change image').'&nbsp;&nbsp;</label><input id="adv_img" type="file" name="adv_img" />
( '.$this->l('Image will be displayed as 155x163').' )
<br/>
<br class="clear"/>
<label for="adv_link">'.$this->l('Image link').'&nbsp;&nbsp;</label><input id="adv_link" type="text" name="adv_link" value="'.$this->adv_link.'" />
<br class="clear"/>
<br/>
<label for="adv_title">'.$this->l('Title').'&nbsp;&nbsp;</label><input id="adv_title" type="text" name="adv_title" value="'.$this->adv_title.'" />
<br class="clear"/>
<br/>
<input class="button" type="submit" name="submitAdvConf" value="'.$this->l('validate').'" style="margin-left: 200px;"/>
</fieldset>
</form>
';
		return $output;
	}
	public function hookRightColumn($params)
	{
		global $smarty, $protocol_content;
		$smarty->assign('image', $protocol_content.$this->adv_img);
		$smarty->assign('adv_link', $this->adv_link);
		$smarty->assign('adv_title', $this->adv_title);
		return $this->display(__FILE__, 'tmadvblock1.tpl');
	}
}