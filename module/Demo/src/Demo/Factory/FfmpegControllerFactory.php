<?php

namespace Demo\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Demo\Controller\FfmpegController;

class FfmpegControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $controllerManager)
	{
		$serviceLocator = $controllerManager->getServiceLocator();
		$ffmpeg = $serviceLocator->get('FFMpeg');
		
		return new FfmpegController($ffmpeg);
	}
}