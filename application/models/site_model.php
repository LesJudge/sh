<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Site_model extends CI_Model
{
	protected $isNew = true;

	public function __construct()
	{
		parent::__construct();
		$this->isNew = $this->config->item('site_new');
	}

	public function getIsNew()
	{
		return $this->isNew;
	}

	public function getTemplateItem($item)
	{
		return $this->getSiteConfigItem($item . $this->getSiteConfigPostfix());
	}

	public function getSiteConfigItem($item)
	{
		return $this->config->item('site_' . $item);
	}

	protected function getSiteConfigPostfix()
	{
		return $this->isNew ? '_new' : '_default';
	}
}