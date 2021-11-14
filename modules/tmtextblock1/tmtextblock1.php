<?php
if (!defined('_PS_VERSION_'))
	exit;
class TMTextblock1 extends Module
{
	public $adv_link1;
	public $adv_title1;
	public $adv_img;
	public $adv_imgname = 'advertising_custom';
	public function __construct()
	{
		$this->name = 'tmtextblock1';
		$this->tab = 'front_office_features';
		$this->version = 1.4;
		$this->author = 'TM';
		$this->need_instance = 0;
		parent::__construct();
		$this->displayName = $this->l('TM Text Block1');
		$this->description = $this->l('Adds a block to display some text');
		if (!file_exists(_PS_MODULE_DIR_.$this->name.'/'.$this->adv_imgname.'.'.Configuration::get('TMTEXTBLOCK5')))
		{
			$this->adv_imgname = 'advertising';
			if (!file_exists(_PS_MODULE_DIR_.$this->name.'/advertising.jpg'))
				$this->adv_imgname = '';
			else
				Configuration::updateValue('TMTEXTBLOCK5','jpg');
		}
		if (!empty($this->adv_imgname))
			$this->adv_img = Tools::getMediaServer($this->name)._MODULE_DIR_.$this->name.'/'.$this->adv_imgname.'.'.Configuration::get('TMTEXTBLOCK5');
		$this->adv_link1 = htmlentities(Configuration::get('TMTEXTBLOCK6'), ENT_QUOTES, 'UTF-8');
		$this->adv_title1 = htmlentities(Configuration::get('TMTEXTBLOCK7'), ENT_QUOTES, 'UTF-8');
	}
	public function install()
	{
		Configuration::updateValue('TMTEXTBLOCK6', 'http://www.prestashop.com');
		if (!parent::install())
			return false;
		if (!$this->registerHook('footer'))
			return false;
		return true;
	}
	private function _deleteCurrentImg()
	{
		if (file_exists(_PS_MODULE_DIR_.$this->name.'/'.$this->adv_imgname.'.'.Configuration::get('TMTEXTBLOCK5')))
			unlink(_PS_MODULE_DIR_.$this->name.'/'.$this->adv_imgname.'.'.Configuration::get('TMTEXTBLOCK5'));
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
					// as checkImage tell us it's a good image, we'll just copy the extension
					$this->_deleteCurrentImg();
					$this->adv_imgname = 'advertising';
					$ext = substr($_FILES['adv_img']['name'], $dot_pos+1);
					$newname = 'advertising_custom';
					if (!move_uploaded_file($_FILES['adv_img']['tmp_name'],_PS_MODULE_DIR_.$this->name.'/'.$newname.'.'.$ext))
						$errors .= $this->l('Error move uploaded file');
					else
						$this->adv_imgname = $newname;
					Configuration::updateValue('TMTEXTBLOCK5',$ext);
					$this->adv_img = Tools::getMediaServer($this->name)._MODULE_DIR_.$this->name.'/'.$this->adv_imgname.'.'.Configuration::get('TMTEXTBLOCK5');
				}
			}
			if ($link = Tools::getValue('adv_link1'))
			{
				Configuration::updateValue('TMTEXTBLOCK6', $link);
				$this->adv_link1 = htmlentities($link, ENT_QUOTES, 'UTF-8');
			}
			if ($title = Tools::getValue('adv_title1'))
			{
				Configuration::updateValue('TMTEXTBLOCK7', $title);
				$this->adv_title1 = htmlentities($title, ENT_QUOTES, 'UTF-8');
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
<!--
<a href="'.$this->adv_link1.'" target="_blank" title="'.$this->adv_title1.'">';
		if ($this->adv_img)
		{
			$output .= '<img src="'.$protocol_content.$this->adv_img.'" alt="'.$this->adv_title1.'" title="'.$this->adv_title1.'" style="height:163px;margin-left: 100px;width:163px"/>';
			$output .= '<input class="button" type="submit" name="submitDeleteImgConf" value="'.$this->l('Delete image').'" style=""/>';
		}
		else
			$output .= '<div style="margin-left: 100px;width:163px;"/>'.$this->l('no image').'</div>';
		$output .= '</a>';
		$output .= '<br/>
<br/>
<label for="adv_img">'.$this->l('Change image').'&nbsp;&nbsp;</label><input id="adv_img" type="file" name="adv_img" />
( '.$this->l('Image will be displayed as 155x163').' )
<br/>
-->
<br class="clear"/>
<label for="adv_link1">'.$this->l('Text 3').'&nbsp;&nbsp;</label><input id="adv_link1" type="text" name="adv_link1" value="'.$this->adv_link1.'" />
<br class="clear"/>
<br/>
<label for="adv_title1">'.$this->l('Text 4').'&nbsp;&nbsp;</label><input id="adv_title1" type="text" name="adv_title1" value="'.$this->adv_title1.'" />
<br class="clear"/>
<br/>
<input class="button" type="submit" name="submitAdvConf" value="'.$this->l('validate').'" style="margin-left: 200px;"/>
</fieldset>
</form>
';
		return $output;
	}
	function hookFooter($params)
	{
		global $smarty, $protocol_content;
		Tools::addCSS($this->_path.'blockadvertising.css', 'all');
		$smarty->assign('image', $protocol_content.$this->adv_img);
		$smarty->assign('adv_link1', $this->adv_link1);
		$smarty->assign('adv_title1', $this->adv_title1);
		return $this->display(__FILE__, 'tmtextblock1.tpl');
	}
}