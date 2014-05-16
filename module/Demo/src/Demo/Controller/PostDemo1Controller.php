<?php

namespace Demo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Demo\Form\DemoForm;

class PostDemo1Controller extends AbstractActionController
{
	// Dépendances à injecter
	protected $demoForm;
	
	/* Le service manager va se charger de créer le controller avec les dépendances requises
	 * Voir la factory PostDemo1ControllerFactory
	 */
	public function __construct(DemoForm $demoForm)
	{
		$this->demoForm = $demoForm;
	}
	
	public function indexAction()
	{
		$request = $this->getRequest();
		$data = $request->getPost();
		$this->demoForm->setData($data);
		
		if ($request->isPost())
		{
			if ($this->demoForm->isValid())
			{
				return $this->redirect()->toRoute('demo/form-valid');
			}
		}
		
		return array('form' => $this->demoForm);
	}
}