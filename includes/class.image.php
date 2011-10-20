<?php

/*

Image Resize Class

Example:

$img = new Image();
if($img->resize('example.png', 300, 200, 'crop')) echo $img->image['basename'];
else echo $img->error;

*/

class Image
{
	private $file;
	public $image = array();
	public $error;
	
	public function resize($file, $width = null, $height =  null, $option = 'auto', $quality = 100)
	{
		$this->file['old'] = $this->open($file);
		$new = $this->getNewDimensions($width, $height, $option);
		
		$this->file['new'] = imagecreatetruecolor($new['width'], $new['height']);
		imagecopyresampled($this->file['new'], $this->file['old'], 0, 0, 0, 0, $new['width'], $new['height'], $this->image['width'], $this->image['height']);
		
		if($option == 'crop')
		{
			$this->crop($new['width'], $new['height'], $width, $height);
			$new['width'] = $width;
			$new['height'] = $height;
		}
		
		$this->image = array_merge($this->image, $new);		
		$this->save($quality);
		return $this->image['basename'];
	}
	
	private function open($file)
	{
		if($this->image = $this->getImageInfo($file))
		{
			switch($this->image['type'])
			{
				case 'image/jpeg':
					$file = imagecreatefromjpeg($file);
					break;
				case 'image/gif':
					$file = imagecreatefromgif($file);
					break;
				case 'image/png':
					$file = imagecreatefrompng($file);
					break;
				default:
					$file = false;
					break;
			}
			if(!$file) $this->error = 'Error opening image';
			return $file;
		}
		return false;
	}
	
	private function save($quality)
	{
		
		$this->image['basename'] = str_replace('.' . $this->image['extension'], '_' . round($this->image['width']) . 'x' . round($this->image['height']) . '.' . $this->image['extension'], $this->image['basename']);
		$path = ABSPATH . UPLOAD_PATH . '/' . $this->image['basename'];
		switch($this->image['type'])
		{
			case 'image/jpeg':
				imagejpeg($this->file['new'], $path, $quality);
				break;
			case 'image/gif':
				imagegif($this->file['new'], $path, $quality);
				break;
			case 'image/png':
				$quality = 9 - (($quality / 100) * 9);
				imagepng($this->file['new'], $path, $quality);
				break;
		}
		imagedestroy($this->file['old']);
		imagedestroy($this->file['new']);
	}
	
	private function crop($newWidth, $newHeight, $width, $height)
	{
		$crop['x'] = ($newWidth / 2) - ($width / 2);
		$crop['y'] = ($newHeight / 2) - ($height / 2);
		
		$this->file['old'] = $this->file['new'];
		$this->file['new'] = imagecreatetruecolor($width, $height);
		imagecopyresampled($this->file['new'], $this->file['old'], 0, 0, $crop['x'], $crop['y'], $width, $height, $width, $height);
	}
	
	private function getNewDimensions($width, $height, $option)
	{
		switch($option)
		{
			case 'exact':
				$new['width'] = $width;
				$new['height'] = $height;
				break;
			case 'auto':
				$new = $this->getAutoDimensions($width, $height);
				break;
			case 'crop':
				$new = $this->getCropDimensions($width, $height);
				break;
		}
		return $new;
	}
	
	private function getAutoDimensions($width, $height)
	{
		if($width && $height && $this->image['width'] > $this->image['height'])
		{
			$new['width'] = $width;
			$new['height'] = $this->fixedWidthHeight($width);
		}
		elseif($width && $height && $this->image['height'] > $this->image['width'])
		{
			$new['width'] = $this->fixedHeightWidth($height);
			$new['height'] = $height;
		}
		else
		{
			if($width > $height)
			{
				$new['width'] = $width;
				$new['height'] = $this->fixedWidthHeight($width);
			}
			elseif($height > $width)
			{
				$new['width'] = $this->fixedHeightWidth($height);
				$new['height'] = $height;
			}
			else
			{
				$new['width'] = $width;
				$new['height'] = $height;
			}
		}
		return $new;
	}
	
	private function getCropDimensions($width, $height)
	{
		$ratio['width'] = $this->image['width'] / $width;
		$ratio['height'] = $this->image['height'] / $height;
		
		if($ratio['width'] > $ratio['height']) $ratio = $ratio['height'];
		else $ratio = $ratio['width'];
		
		$new['width'] = $this->image['width'] / $ratio;
		$new['height'] = $this->image['height'] / $ratio;
		
		return $new;
	}
	
	private function fixedWidthHeight($width)
	{
		return $width * ($this->image['height'] / $this->image['width']);
	}
	
	private function fixedHeightWidth($height)
	{
		return $height * ($this->image['width'] / $this->image['height']);
	}
	
	private function getImageInfo($file)
	{
		if(function_exists('getimagesize'))
		{
			$info = pathinfo($file);
			foreach(getimagesize($file) as $key => $value)
			{
				if($key == '0') $info['width'] = $value;
				elseif($key == '1') $info['height'] = $value;
				elseif($key == 'mime') $info['type'] = $value;
			}
			return $info;
		}
		else
		{
			$this->error = 'GD is not installed!';
			return false;
		}
	}
}