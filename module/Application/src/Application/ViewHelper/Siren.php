<?php

namespace Application\ViewHelper;

use Zend\View\Helper\AbstractHelper;

class Siren extends AbstractHelper
{
	public function __invoke($siren = null)
	{
		if($siren)
		{
			return $this->format($siren);
		}
		
		return $this;
	}
	
	public function format($siren)
	{
		$pattern = '/(\d{3})(\d{3})(\d{3})/';
		$replacement = '\\1 \\2 \\3';
		
		return preg_replace($pattern, $replacement, $siren);
	}
	
	public function formControlStatic($siren)
	{
		$output = <<<OUTPUT
<div class="form-group">
	<label class="col-sm-2 control-label">Siren :</label>
    <div class="col-sm-4">
      <p class="form-control-static">{$this->format($siren)}</p>
    </div>
</div>		
OUTPUT;
		
		return $output;
	}
}