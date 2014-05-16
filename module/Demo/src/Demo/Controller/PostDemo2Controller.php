<?php

namespace Demo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Demo\Form\DemoFormFilter;

class PostDemo2Controller extends AbstractActionController
{
	public function indexAction()
	{
		$request = $this->getRequest();
		$data = $request->getPost();
		
		if ($request->isPost()) 
		{
			$inputFilter = new DemoFormFilter;
			$inputFilter->setData($data);
			
			if ($inputFilter->isValid())
			{
				return $this->redirect()->toRoute('demo/form-valid');
			}
			else
			{
				foreach ($inputFilter->getInvalidInput() as $key => $error)
				{
					$errors[$key] = $error->getMessages();
				}
			}
		}
		
		return (compact('data', 'errors'));
	}
}