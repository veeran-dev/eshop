<?php
/**
 * 2007-2014 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2014 PrestaShop SA
 *  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

/**
 * Description of Utilisateur
 *
 * @author ESPIAU Nicolas <nicolas.espiau at fia-net.com>
 */
class CertissimUtilisateur extends CertissimXMLElement
{

	const TYPE_ENTREPRISE = 1;
	const TYPE_PARTICULIER = 2;

	public function __construct($type = null, $civility = null, $lastname = null, $firstname = null, $society = null,
		$phone_home = null, $phone_mobile = null, $phone_fax = null, $email_address = null)
	{
		parent::__construct();
		if (!is_null($type))
			$this->addAttribute('type', $type);
		$this->addAttribute('qualite', self::TYPE_PARTICULIER);

		$this->childNom($lastname, array('titre' => $civility));
		$this->childPrenom($firstname);
		$this->childSociete($society);
		$this->childTelhome($phone_home);
		$this->childTelmobile($phone_mobile);
		$this->childFax($phone_fax);
		$this->childEmail($email_address);
	}

}