<?php

namespace Demo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Filters\Video\ResizeFilter;
use FFMpeg\Format\Video\X264;

class FfmpegController extends AbstractActionController
{
	protected $ffmpeg;
	
	public function __construct(FFMPeg $ffmpeg)
	{
		$this->ffmpeg = $ffmpeg;
	}
	
	public function indexAction()
	{
		$video = $this->ffmpeg->open("/Users/freddymarcy/Dev/web/workspaces/dev/zf2demo.dev/public/myscreen.mov");
		
		$video
			->filters()
			->resize(new Dimension(200, 150), ResizeFilter::RESIZEMODE_INSET)
			->synchronize();
		
		$video->save(new X264(), "/Users/freddymarcy/Dev/web/workspaces/dev/zf2demo.dev/public/myscreen.mp4");
	}
}