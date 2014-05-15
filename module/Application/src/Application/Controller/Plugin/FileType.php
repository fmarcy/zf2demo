<?php

namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class FileType extends AbstractPlugin
{
	public function __invoke($uri)
	{
		$finfo = finfo_open(FILEINFO_MIME_TYPE); 
		
		$mimeType = finfo_file($finfo, $uri);
		
		switch ($mimeType)
		{
			case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
				$fileType = 'Word';
				break;
			case 'application/pdf':
				$fileType = 'PDF';
				break;
			default:
				$fileType = 'Unknown type';
		}
		
		finfo_close($finfo);
		
		return $fileType;
	}
}