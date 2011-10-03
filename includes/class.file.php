<?php

/*

File Upload Class

Example:

$f = new File(array('overwrite' => true));
if($f->upload($_FILES['file'])) echo $f->file['url'];
else echo $f->error;

This class also includes a lot of helpful file functions:

delete(), move(), getFileInfo(), hasValidExtension(), isUnderSizeLimit(), uniqueFilename(), sanitizeFilename() and isFile()

Some of these functions first require changes to the default options to work in your environment which you can change when you construct the class (as exampled above) or at some other point, i.e.:

$f->option['max_size'] = 2;
if($f->isUnderSizeLimit('example.png')) echo 'success!';
else echo 'failure!';

*/

class File
{
	public $file = array();
	public $error;
	public $option = array(
		'extension' => array('png', 'gif', 'jpg', 'jpeg'),
		'max_size' => 10,
		'overwrite' => false
	);
	
	function File($options = array())
	{
		if(!empty($options)) $this->option = array_merge($this->option, $options);
		$this->option['fullpath'] = ABSPATH . UPLOAD_PATH;
	}
	
	public function upload($upload)
	{
		if($this->isUploaded($upload) && $this->hasValidExtension($upload['name']) && $this->isUnderSizeLimit($upload['tmp_name'])) return $this->move($upload['tmp_name'], $upload['name']);
	}
	
	public function delete($file)
	{
		$this->getFileInfo($file);
		if(!$this->isFile($file)) return false;
		elseif(unlink($file)) return true;
		else $this->error = 'Unable to delete file';
		return false;
	}
	
	public function move($frompath, $filename)
	{
		if($this->isFile($frompath))
		{
			$filename = $this->sanitizeFilename($filename);
			if(file_exists($this->option['fullpath'] . $filename) && !$this->option['overwrite']) $filename = $this->uniqueFilename($this->option['fullpath'] . $filename);
			if(file_exists($this->option['fullpath'] . $filename) && $this->option['overwrite'])
			{
				if(!$this->delete($this->option['fullpath'] . $filename)) return false;
			}
			if(move_uploaded_file($frompath, $this->option['fullpath'] . $filename))
			{
				$this->getFileInfo($this->option['fullpath'] . $filename);
				$this->file['url'] = SITE_URL . UPLOAD_PATH . $filename;
				return true;
			}
			else
			{
				$this->error = 'File upload error. Your uploads folder may not be writeable';
			}
		}
		return false;
	}
	
	public function getFileInfo($file)
	{
		$info = pathinfo($file);
		if($this->isFile($file))
		{
			$info['size'] = $this->getFileSize($file);
		}
		$this->file['name'] = $info['basename']; unset($info['basename']);
		$this->file['path'] = $info['dirname'] . '/' . $this->file['name'];
		$this->file = array_merge($this->file, $info);
		return $this->file;
	}
	
	public function hasValidExtension($file)
	{
		$this->getFileInfo($file);
		foreach($this->option['extension'] as $ext)
		{
			if($this->file['extension'] == $ext) return true;
		}
		$this->error = 'Invalid file type';
		return false;
	}
	
	public function isUnderSizeLimit($file)
	{
		if($this->isFile($file))
		{
			$info = $this->getFileInfo($file);
			if($info['size'] < ($this->option['max_size'] * 1048576)) return true;
			else $this->error = 'File exceeds limit';
		}
		return false;
	}
	
	public function uniqueFilename($file)
	{
		if($this->isFile($file))
		{
			$this->getFileInfo($file);
			$number = '';
			$filename = $this->sanitizeFilename($this->file['name']);
			$ext = !empty($this->file['extension']) ? '.' . $this->file['extension'] : '';
			
			while(file_exists($this->file['dirname'] . '/' . $filename))
			{
				$new_number = $number + 1;
				$filename = str_replace($number.$ext, $new_number.$ext, $filename);
				$number = $new_number;
			}
			
			return $filename;
		}
		return false;
	}
	
	public function sanitizeFilename($file)
	{
		return str_replace(' ', '-', strtolower(trim(preg_replace('/\s+/', ' ', preg_replace('/[^A-Za-z0-9\.]/', '', $file)))));
	}
	
	public function isFile($file)
	{
		if(is_file($file)) return true;
		else $this->error = 'No such file exists';
		return false;
	}
	
	private function getFileSize($file)
	{
		if($this->isFile($file)) return filesize($file);
		else return false;
	}
	
	private function isUploaded($upload)
	{
		if(!empty($upload) && isset($upload['tmp_name']) && is_uploaded_file($upload['tmp_name'])) return true;
		else $this->error = 'No file uploaded';
		return false;
	}
}