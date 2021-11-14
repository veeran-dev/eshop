<?php

/*Copyright 2011 maofree  email: msecco@gmx.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 3, as 
published by the Free Software Foundation.

This file can't be removed. This module can't be sold.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.

*/
    
if (!defined('_PS_VERSION_'))
	exit;

class Maofree_BlockManufacturer extends Module
{
    public function __construct()
    {
        $this->name = 'maofree_blockmanufacturer';
        $this->tab = 'others';
        $this->version = '2.0';
        $this->author = 'maofree';
		  $this->need_instance = 0;
        
        parent::__construct();

        $this->displayName = $this->l('Manufacturer Block with Carousel');
        $this->description = $this->l('Adds a block with a carousel of manufacturer');
    }

	public function install()
	{
		if (
		   !parent::install() ||
		   !$this->registerHook('leftColumn') ||
		   !$this->registerHook('header') ||		    
		   !Configuration::updateValue('MANUFACTURER_TIMEEFFECT', 2000) || 
		   !Configuration::updateValue('MANUFACTURER_MOUSEWHEEL', 1) ||
		   !Configuration::updateValue('MANUFACTURER_TIMETRANSITION', 4000) || 
		   !Configuration::updateValue('MANUFACTURER_EFFECT', 'random') ||
			!Configuration::updateValue('MANUFACTURER_MOVEMENT', 'horizontal') ||
		   !Configuration::updateValue('MANUFACTURER_ITEMSVIS', 1) ||
		   !Configuration::updateValue('MANUFACTURER_ADDSCRIPTS', 1) ||
			!Configuration::updateValue('MANUFACTURER_HOOK_POSITION', 'leftColumn') ||		    
		   !Configuration::updateValue('MANUFACTURER_DISPLAY_FORM', 1)
		)
         return false;		
		return true;
	}

   public function uninstall()
   {
      if (
         !Configuration::deleteByName('MANUFACTURER_TIMEEFFECT') ||
         !Configuration::deleteByName('MANUFACTURER_TIMETRANSITION') ||
         !Configuration::deleteByName('MANUFACTURER_EFFECT') ||
         !Configuration::deleteByName('MANUFACTURER_MOUSEWHEEL') ||
         !Configuration::deleteByName('MANUFACTURER_ITEMSVIS') ||
         !Configuration::deleteByName('MANUFACTURER_ADDSCRIPTS') ||
         !Configuration::deleteByName('MANUFACTURER_MOVEMENT') ||                  
         !Configuration::deleteByName('MANUFACTURER_DISPLAY_FORM') ||
         !Configuration::deleteByName('MANUFACTURER_HOOK_POSITION') ||             
         !parent::uninstall()
      )
         return false;
      return true;
    }

	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		$errors = array();
		$hookidleftcolumn = (int)(Hook::get('leftColumn'));
		$hookidrightcolumn = (int)(Hook::get('rightColumn'));
				
		if (Tools::isSubmit('submitManufacturers'))
		{
			$movement = Tools::getValue('movement');
			$itemsvisible = (int)(Tools::getValue('itemsvisible'));			
			$hookposition = Tools::getValue('hookposition');						
			$timeeffect = (int)(Tools::getValue('timeeffect'));
			$timetransition = (int)(Tools::getValue('timetransition'));
			$effect = Tools::getValue('effect');
			$addscripts = (int)(Tools::getValue('addscripts'));
			$mousewheel = (int)(Tools::getValue('mousewheel'));			
			$formlist = (int)(Tools::getValue('formlist'));
			if (!$timeeffect OR $timeeffect <= 0 OR !Validate::isInt($timeeffect))
				$errors[] = $this->l('Invalid number in = Time of effect');
			else		
				Configuration::updateValue('MANUFACTURER_TIMEEFFECT', $timeeffect);
			if (!$timetransition OR $timetransition <= 0 OR !Validate::isInt($timetransition))
				$errors[] = $this->l('Invalid number in = Time of transition');
			else
				Configuration::updateValue('MANUFACTURER_TIMETRANSITION', $timetransition);		
			Configuration::updateValue('MANUFACTURER_EFFECT', $effect);
			Configuration::updateValue('MANUFACTURER_MOUSEWHEEL', $mousewheel);
			Configuration::updateValue('MANUFACTURER_MOVEMENT', $movement);
			Configuration::updateValue('MANUFACTURER_ITEMSVIS', $itemsvisible);
			Configuration::updateValue('MANUFACTURER_ADDSCRIPTS', $addscripts);
			Configuration::updateValue('MANUFACTURER_HOOK_POSITION', $hookposition);									
		   Configuration::updateValue('MANUFACTURER_DISPLAY_FORM', $formlist);
			if(!$this->isRegisteredInHook($hookposition))
			{
				if($hookposition == 'rightColumn')
					$this->unregisterHook($hookidleftcolumn);
				else
					$this->unregisterHook($hookidrightcolumn);				    	 
				$this->registerHook($hookposition);
			}		   
			if (isset($errors) AND sizeof($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		return $output.$this->displayForm();
	}
	
	public function displayForm()
	{		
		$output = '
			<fieldset>
				<legend><img src="'.$this->_path.'logo.gif" alt="maofree\'s module" title="maofree\'s module" />maofree</legend>
				<a href="http://www.maofree-developer.com" target="_blank"><img src="'._MODULE_DIR_.$this->name.'/img/donate.png" alt="maofree\'s website" title="'.$this->l('Do you need some help? (click here)').'" /></a>
				<div style="float:right;width:70%;">
					<h3 style="color:lightCoral;">'.$this->l('If you like my job, you could support me with a donation').'.</h3>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="MEF3Z7XDHQZF8">
						<input type="image" src="https://www.paypal.com/en_GB/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="Paypal" style="margin-top:20px;">
						<img alt="" border="0" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1">
					</form>
				</div>
			</fieldset>			
		
			<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
				<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="maofree\'s module" title="maofree\'s module" />'.$this->l('Settings').'</legend>
				   <label>'.$this->l('Time of effect').':</label>
					<div class="margin-form">
						<input type="text" size="5" name="timeeffect" value="'.Tools::getValue('timeeffect', Configuration::get('MANUFACTURER_TIMEEFFECT')).'" />
						<p class="clear">'.$this->l('The time of each effect in ms (default: 2000)').'</p>
					</div>		
					<label>'.$this->l('Time of transition').':</label>
					<div class="margin-form">
						<input type="text" size="5" name="timetransition" value="'.Tools::getValue('timetransition', Configuration::get('MANUFACTURER_TIMETRANSITION')).'" />
						<p class="clear">'.$this->l('The time between each slide in ms (default: 4000)').'</p>
					</div>					
					<label>'.$this->l('Mouse wheel').':</label>
					<div class="margin-form">
						<input type="radio" name="mousewheel" id="mousewheel_on" value="1" '.(Tools::getValue('mousewheel', Configuration::get('MANUFACTURER_MOUSEWHEEL')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="mousewheel_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
						<input type="radio" name="mousewheel" id="mousewheel_off" value="0" '.(!Tools::getValue('mousewheel', Configuration::get('MANUFACTURER_MOUSEWHEEL')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="mousewheel_off"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
						<p class="clear">'.$this->l('Mouse wheel to scroll from one item to next').'</p>
					</div>
				   <label>'.$this->l('Use a drop-down list').':</label>
					<div class="margin-form">
						<input type="radio" name="formlist" id="formlist_on" value="1" '.(Tools::getValue('formlist', Configuration::get('MANUFACTURER_DISPLAY_FORM')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="formlist_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
						<input type="radio" name="formlist" id="formlist_off" value="0" '.(!Tools::getValue('formlist', Configuration::get('MANUFACTURER_DISPLAY_FORM')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="formlist_off"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
						<p class="clear">'.$this->l('To display manufacturers in a drop-down list').'</p>
					</div>
				   <label>'.$this->l('Add two javascritps').':</label>
					<div class="margin-form">
						<input type="radio" name="addscripts" id="addscripts_on" value="1" '.(Tools::getValue('addscripts', Configuration::get('MANUFACTURER_ADDSCRIPTS')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="addscripts_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
						<input type="radio" name="addscripts" id="addscripts_off" value="0" '.(!Tools::getValue('addscripts', Configuration::get('MANUFACTURER_ADDSCRIPTS')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="addscripts_off"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
						<p class="clear">'.$this->l('jcarousellite and mousewheel script will be added into the header (if you use more than one of my carousels, you can remove javascript duplications from header, disabling this option)').'</p>
					</div>
					<label>'.$this->l('Visible Items').':</label>
					<div class="margin-form">
						<select name="itemsvisible">
						';
						
					for ($i = 1; $i <= 10; $i++)
						$output .= '<option value="' . $i . '" '.(Tools::getValue('itemsvisible', Configuration::get('MANUFACTURER_ITEMSVIS')) ==  $i ? 'selected="selected"' : '').'>'. $i .'</option>';
						
					$output .= '							
						</select>
						'.$this->l('More visible items are only available with a vertical moviment (default: 1)').'
					</div><br />					
					<label>'.$this->l('Carousel movement').':</label>
					<div class="margin-form">
						<select name="movement">
							<option value="horizontal" '.(Tools::getValue('movement', Configuration::get('MANUFACTURER_MOVEMENT')) == 'horizontal' ? 'selected="selected"' : '').'>'.$this->l('horizontal').'</option>
							<option value="vertical" '.(Tools::getValue('movement', Configuration::get('MANUFACTURER_MOVEMENT')) == 'vertical' ? 'selected="selected"' : '').'>'.$this->l('vertical').'</option>
						</select>
						'.$this->l('(default: horizontal)').'
					</div><br />					
					<label>'.$this->l('Hook Position').':</label>
					<div class="margin-form">
						<select name="hookposition">
							<option value="leftColumn" '.(Tools::getValue('hookposition', Configuration::get('MANUFACTURER_HOOK_POSITION')) == 'leftColumn' ? 'selected="selected"' : '').'>leftColumn</option>
							<option value="rightColumn" '.(Tools::getValue('hookposition', Configuration::get('MANUFACTURER_HOOK_POSITION')) == 'rightColumn' ? 'selected="selected"' : '').'>rightColumn</option>
						</select>
						'.$this->l('(default: leftColumn)').'
					</div><br />					
					<label>'.$this->l('Choose the effect').':</label>
					<div class="margin-form">
						<select name="effect">
					';
						
			      $effectsc = array('\'easeInQuad\'', '\'easeOutQuad\'', '\'easeInOutQuad\'', '\'easeInCubic\'', '\'easeOutCubic\'', '\'easeInOutCubic\'', '\'easeInQuart\'', '\'easeOutQuart\'', '\'easeInOutQuart\'', '\'easeInQuint\'','\'easeOutQuint\'', '\'easeInOutQuint\'', '\'easeInSine\'', '\'easeOutSine\'', '\'easeInOutSine\'','\'easeInExpo\'', '\'easeOutExpo\'', '\'easeInOutExpo\'', '\'easeInCirc\'', '\'easeOutCirc\'', '\'easeInOutCirc\'', '\'easeInElastic\'', '\'easeOutElastic\'', '\'easeInOutElastic\'', '\'easeInBack\'','\'easeOutBack\'', '\'easeInOutBack\'', '\'easeInBounce\'', '\'easeOutBounce\'', '\'easeInOutBounce\'', 'random');					
			      $effects = array('easeInQuad', 'easeOutQuad', 'easeInOutQuad', 'easeInCubic', 'easeOutCubic', 'easeInOutCubic', 'easeInQuart', 'easeOutQuart', 'easeInOutQuart', 'easeInQuint','easeOutQuint', 'easeInOutQuint', 'easeInSine', 'easeOutSine', 'easeInOutSine','easeInExpo', 'easeOutExpo', 'easeInOutExpo', 'easeInCirc', 'easeOutCirc', 'easeInOutCirc', 'easeInElastic', 'easeOutElastic', 'easeInOutElastic', 'easeInBack','easeOutBack', 'easeInOutBack', 'easeInBounce', 'easeOutBounce', 'easeInOutBounce', 'random');	
					for ($i = 0; $i <= 30; $i++)
						$output .= '<option value="' . $effectsc[$i] . '" '.(Tools::getValue('effect', Configuration::get('MANUFACTURER_EFFECT')) ==  $effectsc[$i] ? 'selected="selected"' : '').'>'. $effects[$i] .'</option>';
	
					$output .= '																																																																									
						</select>
						<p class="clear">'.$this->l('In random mode, the slideshow, for each new page, will have a different effect (default random)').'</p>
					</div>	
					<div class="margin-form clear"><input type="submit" name="submitManufacturers" value="'.$this->l('Save').'" class="button" /></div>
				</fieldset>
			</form>';
			
		return $output;
	}	
	
	private function sortmanufacturers($a, $b) {
	   return strcmp ($a['name'], $b['name']);
	}	

	public function hookLeftColumn($params)
   {
		global $smarty, $link;

      $manufacturers = array();
		$manufacturers = Manufacturer::getManufacturers();
		$manufacturerssort = $manufacturers;
		usort($manufacturerssort, array($this, 'sortmanufacturers'));
		if ($manufacturers) {
			shuffle($manufacturers);
			if (sizeof($manufacturers) > 50)
			   $manufacturers = array_splice($manufacturers, 0, 50);
	   }
		   	   
	   $smarty->assign(array(
		   'formlistmanu' => Configuration::get('MANUFACTURER_DISPLAY_FORM'),
			'display_link_manufacturersslide' => Configuration::get('PS_DISPLAY_SUPPLIERS'),
			'manufacturers_imagesize' => Image::getSize('medium'),
			'link' => $link,
		   'manufacturerssort' => $manufacturerssort,	         			   	         
         'manufacturersslide' => $manufacturers
      ));
      
	   return $this->display(__FILE__, 'maofree_blockmanufacturer.tpl');
   }
   
   public function hookHeader($params)
   {
   	global $smarty;

   	$itemsvisible = '1';
   	$movement = Configuration::get('MANUFACTURER_MOVEMENT');
   	
   	if($movement == 'vertical') 
   	{
   	   $vertical = 'true';
   	   $itemsvisible = (int)(Configuration::get('MANUFACTURER_ITEMSVIS'));
   	}   
   	else
   	   $vertical = 'false';
  	
      $effects = array('\'easeInQuad\'', '\'easeOutQuad\'', '\'easeInOutQuad\'', '\'easeInCubic\'', '\'easeOutCubic\'', '\'easeInOutCubic\'', '\'easeInQuart\'', '\'easeOutQuart\'', '\'easeInOutQuart\'', '\'easeInQuint\'','\'easeOutQuint\'', '\'easeInOutQuint\'', '\'easeInSine\'', '\'easeOutSine\'', '\'easeInOutSine\'','\'easeInExpo\'', '\'easeOutExpo\'', '\'easeInOutExpo\'', '\'easeInCirc\'', '\'easeOutCirc\'', '\'easeInOutCirc\'', '\'easeInElastic\'', '\'easeOutElastic\'', '\'easeInOutElastic\'', '\'easeInBack\'','\'easeOutBack\'', '\'easeInOutBack\'', '\'easeInBounce\'', '\'easeOutBounce\'', '\'easeInOutBounce\'');   	
		$effect = Configuration::get('MANUFACTURER_EFFECT');
		if	($effect == 'random')
		{
		   shuffle($effects);
		   $effect = $effects[0];
		}
		   	
	   $smarty->assign(array(
         'timeeffectmanu' => Configuration::get('MANUFACTURER_TIMEEFFECT'),
         'timetransitionmanu' => Configuration::get('MANUFACTURER_TIMETRANSITION'),
         'effectmanu' => $effect,
         'itemsvismanu' => $itemsvisible,         
         'verticalmanu' => $vertical,         	         	         
         'mousewheelmanu' => Configuration::get('MANUFACTURER_MOUSEWHEEL')			   
      ));
      
		Tools::addCSS(($this->_path).'css/blockmanufacturer.css', 'all');
		if (Configuration::get('MANUFACTURER_ADDSCRIPTS'))
		{
			Tools::addJS(($this->_path).'js/jcarousellite_1.0.1.min.js');
			if (Configuration::get('MANUFACTURER_MOUSEWHEEL'))
				Tools::addJS(($this->_path).'js/jquery.mousewheel.min.js');
		}
         	
		return $this->display(__FILE__, 'header.tpl');
   }   

   public function hookRightColumn($params)
   {
      return $this->hookLeftColumn($params);
   }
}