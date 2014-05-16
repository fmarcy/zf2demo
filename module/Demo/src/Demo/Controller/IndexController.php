<?php

namespace Demo\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
	public function indexAction()
	{
		
	}
	
	public function viewHelperAction()
	{
		
	}
	
	public function controllerPluginAction()
	{
		$docs = array(
			'/Users/freddymarcy/Dev/web/workspaces/dev/zf2demo.dev/public/MyWord.docx' => null,
			'/Users/freddymarcy/Dev/web/workspaces/dev/zf2demo.dev/public/MyPdf.pdf' => null,
		);
		
		foreach ($docs as $key => $val)
		{
			$docs[$key] = $this->fileType($key);
		}
		
		return compact('docs');
	}
	
	public function formIsValidAction()
	{
		
	}
}