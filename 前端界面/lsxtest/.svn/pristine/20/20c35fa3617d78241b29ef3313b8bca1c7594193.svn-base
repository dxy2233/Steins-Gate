<?php
namespace common\helpers;

use yii\helpers\BaseFileHelper;

/**
 * 68Shop 文件操作工具类
 *
 *
 *
 * ============================================================================
 * 版权所有 2008-2015 秦皇岛商之翼网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.68ecshop.com
 * ----------------------------------------------------------------------------
 * 这是一个免费开源的软件；这意味着您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * ============================================================================
 *
 * @author niqingyang
 * @version 1.0
 */
class FileHelper extends BaseFileHelper
{

	public static function getBaseName ($path, $suffix = null)
	{
		return basename($path);
	}

	/**
	 * Removes a directory (and all its content) recursively.
	 *
	 * @param string $dir
	 *        	the directory to be deleted recursively.
	 * @param array $options
	 *        	options for directory remove. Valid options are:
	 *        	
	 *        	- traverseSymlinks: boolean, whether symlinks to the directories should be traversed too.
	 *        	Defaults to `false`, meaning the content of the symlinked directory would not be deleted.
	 *        	Only symlink would be removed in that default case.
	 */
	public static function removeDirectory ($dir, $options = [])
	{
		if(! is_dir($dir))
		{
			return;
		}
		
		if(isset($options['traverseSymlinks']) && $options['traverseSymlinks'] || ! is_link($dir))
		{
			if(! ($handle = opendir($dir)))
			{
				return;
			}
			while(($file = readdir($handle)) !== false)
			{
				if($file === '.' || $file === '..')
				{
					continue;
				}
				$path = $dir . DIRECTORY_SEPARATOR . $file;
				if(is_dir($path))
				{
					if(static::removeDirectory($path, $options) == false)
					{
						return false;
					}
				}
				else
				{
					if(@unlink($path) == false)
					{
						return false;
					}
				}
			}
			closedir($handle);
		}
		if(is_link($dir))
		{
			if(@unlink($dir) == false)
			{
				return false;
			}
		}
		else
		{
			if(@rmdir($dir) == false)
			{
				return false;
			}
		}
		
		return true;
	}

	/**
	 * 递归删除指定目录下所有文件及目录（不删除目录自己）.
	 *
	 * @param string $dir
	 *        	the directory to be deleted recursively.
	 * @param array $options
	 *        	options for directory remove. Valid options are:
	 *        	
	 *        	- traverseSymlinks: boolean, whether symlinks to the directories should be traversed too.
	 *        	Defaults to `false`, meaning the content of the symlinked directory would not be deleted.
	 *        	Only symlink would be removed in that default case.
	 */
	public static function emptyDirectory ($dir, $options = [])
	{
		if(! is_dir($dir))
		{
			return;
		}
		if(isset($options['traverseSymlinks']) && $options['traverseSymlinks'] || ! is_link($dir))
		{
			if(! ($handle = opendir($dir)))
			{
				return;
			}
			while(($file = readdir($handle)) !== false)
			{
				if($file === '.' || $file === '..')
				{
					continue;
				}
				$path = $dir . DIRECTORY_SEPARATOR . $file;
				if(is_dir($path))
				{
					if(static::removeDirectory($path, $options) == false)
					{
						return false;
					}
				}
				else
				{
					if(@unlink($path) == false)
					{
						return false;
					}
				}
			}
			closedir($handle);
		}
		
		return true;
	}

	/**
	 * 生成指定目录不重名的文件名
	 *
	 * @access public
	 * @param string $dir
	 *        	要检查是否有同名文件的目录
	 *        	
	 * @return string 文件名
	 */
	public static function generateFileName ($dir, $extension)
	{
		$filename = '';
		while(empty($filename))
		{
			$filename = gmtime() . StringHelper::random(4, 'number');
			if(file_exists($dir . $filename . $extension))
			{
				$filename = '';
			}
		}
		
		return $filename;
	}

	/**
	 * 对文件路径进行格式化
	 *
	 * @param string $file_name        	
	 */
	public static function formatFileName ($file_name)
	{
		$file_name = str_replace('\\', '/', $file_name);
		$file_name = str_replace('//', '/', $file_name);
		
		if(file_exists($file_name) && is_dir($file_name))
		{
			if(StringHelper::endsWith($file_name, '/'))
			{
				$file_name = substr($file_name, 0, - 1);
			}
		}
		
		return $file_name;
	}

	/*
	 * 删除图片
	 * $param string $url
	 * 存在数据库中图片路径
	 */
	function unlinkOldImg ($url)
	{
		if(file_exists(Yii::$aliases['@imagepath'] . $url))
		{
			unlink(Yii::$aliases['@imagepath'] . $url);
		}
	}

	/**
	 * 写入文件
	 *
	 * @param unknown $file        	
	 */
	public static function write_file ($filename, $data, $flags = null, $context = null)
	{
		$directoryLevel = 1;
		$dirMode = 0775;
		$fileMode = 0777;
		
		if($directoryLevel > 0)
		{
			@FileHelper::createDirectory(dirname($filename), $dirMode, true);
		}
		if(@file_put_contents($filename, $data, $flags, $context) !== false)
		{
			if($fileMode !== null)
			{
				@chmod($filename, $fileMode);
			}
			if($duration <= 0)
			{
				$duration = 31536000; // 1 year
			}
			
			return @touch($filename, $duration + gmtime());
		}
		else
		{
			return false;
		}
	}

	/**
	 * 文件或目录权限检查函数
	 *
	 * @param string $file_path
	 *        	文件路径
	 *        	
	 * @return int 返回值的取值范围为{0 <= x <= 15}，每个值表示的含义可由四位二进制数组合推出。
	 *         返回值在二进制计数法中，四位由高到低分别代表
	 *         可执行rename()函数权限、可对文件追加内容权限、可写入文件权限、可读取文件权限。
	 */
	public static function fileMode ($file_path = '')
	{
		// 如果不存在，则不可读、不可写、不可改
		if(! file_exists($file_path))
		{
			return false;
		}
		
		$mark = 0;
		
		if(strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
		{
			/* 测试文件 */
			$test_file = $file_path . '/cf_test.txt';
			
			/* 如果是目录 */
			if(is_dir($file_path))
			{
				/* 检查目录是否可读 */
				$dir = @opendir($file_path);
				if($dir === false)
				{
					return $mark; // 如果目录打开失败，直接返回目录不可修改、不可写、不可读
				}
				if(@readdir($dir) !== false)
				{
					$mark ^= 1; // 目录可读 001，目录不可读 000
				}
				@closedir($dir);
				
				/* 检查目录是否可写 */
				$fp = @fopen($test_file, 'wb');
				if($fp === false)
				{
					return $mark; // 如果目录中的文件创建失败，返回不可写。
				}
				if(@fwrite($fp, 'directory access testing.') !== false)
				{
					$mark ^= 2; // 目录可写可读011，目录可写不可读 010
				}
				@fclose($fp);
				
				@unlink($test_file);
				
				/* 检查目录是否可修改 */
				$fp = @fopen($test_file, 'ab+');
				if($fp === false)
				{
					return $mark;
				}
				if(@fwrite($fp, "modify test.\r\n") !== false)
				{
					$mark ^= 4;
				}
				@fclose($fp);
				
				/* 检查目录下是否有执行rename()函数的权限 */
				if(@rename($test_file, $test_file) !== false)
				{
					$mark ^= 8;
				}
				@unlink($test_file);
			}
			/* 如果是文件 */
			elseif(is_file($file_path))
			{
				/* 以读方式打开 */
				$fp = @fopen($file_path, 'rb');
				if($fp)
				{
					$mark ^= 1; // 可读 001
				}
				@fclose($fp);
				
				/* 试着修改文件 */
				$fp = @fopen($file_path, 'ab+');
				if($fp && @fwrite($fp, '') !== false)
				{
					$mark ^= 6; // 可修改可写可读 111，不可修改可写可读011...
				}
				@fclose($fp);
				
				/* 检查目录下是否有执行rename()函数的权限 */
				if(@rename($test_file, $test_file) !== false)
				{
					$mark ^= 8;
				}
			}
		}
		else
		{
			if(@is_readable($file_path))
			{
				$mark ^= 1;
			}
			
			if(@is_writable($file_path))
			{
				$mark ^= 14;
			}
		}
		
		return $mark;
	}

	/**
	 *
	 * @param integer $mark
	 *        	文件模式
	 * @param array|string $type
	 *        	权限类型
	 * @return boolean
	 */
	public static function parseFileMode ($mark, $types = ['all'])
	{
		$code = substr(decbin($mark + 16), 1);
		
		$rename = substr($code, 0, 1);
		$add = substr($code, 1, 1);
		$write = substr($code, 2, 1);
		$read = substr($code, 3, 1);
		
		$result = true;
		
		$types = (array)$types;
		
		foreach($types as $type)
		{
			if($type == 'rename' && ! $rename)
			{
				$result = false;
				break;
			}
			if($type == 'add' && ! $add)
			{
				$result = false;
				break;
			}
			if($type == 'write' && ! $write)
			{
				$result = false;
				break;
			}
			if($type == 'read' && ! $read)
			{
				$result = false;
				break;
			}
			if($type == 'all' && ! ($rename * $add * $write * $read))
			{
				$result = false;
				break;
			}
		}
		
		return $result;
	}

	/**
	 * 格式化文件模式
	 *
	 * @param integer $mark        	
	 */
	public static function formatFileMode ($mark)
	{
		$result = [
			'rename' => [
				'desc' => '可执行rename()函数权限', 
				'value' => static::parseFileMode($mark, 'rename')
			], 
			'add' => [
				'desc' => '可对文件追加内容权限', 
				'value' => static::parseFileMode($mark, 'add')
			], 
			'write' => [
				'desc' => '可写入文件权限', 
				'value' => static::parseFileMode($mark, 'write')
			], 
			'read' => [
				'desc' => '可读取文件权限', 
				'value' => static::parseFileMode($mark, 'read')
			]
		];
		
		return $result;
	}

	/**
	 * 获取文件或者目录大小
	 *
	 * @param string $path        	
	 * @param string $unit
	 *        	单位：B-字节、KB-千字节、MB-兆、GB-千兆，默认为B-字节
	 */
	public static function getFileSize ($path, $unit = 'B')
	{
		$units = [
			'B' => 1, 
			'KB' => 1024, 
			'MB' => 1024 * 1024, 
			'GB' => 1024 * 1024 * 1024, 
			'TB' => 1024 * 1024 * 1024 * 1024
		];
		
		$unit = strtoupper($unit);
		
		if(! isset($units[$unit]))
		{
			$unit = 'KB';
		}
		
		$unit = $units[$unit];
		
		if(! file_exists($path))
		{
			return 0;
		}
		
		$size = 0;
		
		if(is_file($path))
		{
			$size = floor(filesize($path));
		}
		else
		{
			
			$files = static::findFiles($path);
			
			foreach($files as $file)
			{
				$size += floor(filesize($file));
			}
		}
		
		$size = $size / $unit;
		
		$size = number_format($size, 2, '.', '');
		
		return $size;
	}

	/**
	 * Returns the files or derectory found under the specified directory and subdirectories.
	 *
	 * @param string $dir
	 *        	the directory under which the files will be looked for.
	 * @param array $options
	 *        	options for file searching. Valid options are:
	 *        	
	 *        	- filter: callback, a PHP callback that is called for each directory or file.
	 *        	The signature of the callback should be: `function ($path)`, where `$path` refers the full path to be
	 *        	filtered.
	 *        	The callback can return one of the following values:
	 *        	
	 *        	* true: the directory or file will be returned (the "only" and "except" options will be ignored)
	 *        	* false: the directory or file will NOT be returned (the "only" and "except" options will be ignored)
	 *        	* null: the "only" and "except" options will determine whether the directory or file should be
	 *        	returned
	 *        	
	 *        	- except: array, list of patterns excluding from the results matching file or directory paths.
	 *        	Patterns ending with '/' apply to directory paths only, and patterns not ending with '/'
	 *        	apply to file paths only. For example, '/a/b' matches all file paths ending with '/a/b';
	 *        	and '.svn/' matches directory paths ending with '.svn'.
	 *        	If the pattern does not contain a slash /, it is treated as a shell glob pattern and checked for a
	 *        	match against the pathname relative to $dir.
	 *        	Otherwise, the pattern is treated as a shell glob suitable for consumption by fnmatch(3) with the
	 *        	FNM_PATHNAME flag: wildcards in the pattern will not match a / in the pathname.
	 *        	For example, "views/*.php" matches "views/index.php" but not "views/controller/index.php".
	 *        	A leading slash matches the beginning of the pathname. For example, "/*.php" matches "index.php" but
	 *        	not "views/start/index.php".
	 *        	An optional prefix "!" which negates the pattern; any matching file excluded by a previous pattern
	 *        	will become included again.
	 *        	If a negated pattern matches, this will override lower precedence patterns sources. Put a backslash
	 *        	("\") in front of the first "!"
	 *        	for patterns that begin with a literal "!", for example, "\!important!.txt".
	 *        	Note, the '/' characters in a pattern matches both '/' and '\' in the paths.
	 *        	- only: array, list of patterns that the file paths should match if they are to be returned. Directory
	 *        	paths are not checked against them.
	 *        	Same pattern matching rules as in the "except" option are used.
	 *        	If a file path matches a pattern in both "only" and "except", it will NOT be returned.
	 *        	- caseSensitive: boolean, whether patterns specified at "only" or "except" should be case sensitive.
	 *        	Defaults to true.
	 *        	- recursive: boolean, whether the files under the subdirectories should also be looked for. Defaults
	 *        	to true.
	 * @return array files found under the directory. The file list is sorted.
	 * @throws InvalidParamException if the dir is invalid.
	 */
	public static function listFiles ($dir, $options = [])
	{
		if(! is_dir($dir))
		{
			throw new InvalidParamException("The dir argument must be a directory: $dir");
		}
		$dir = rtrim($dir, DIRECTORY_SEPARATOR);
		if(! isset($options['basePath']))
		{
			// this should be done only once
			$options['basePath'] = realpath($dir);
			$options = self::normalizeOptions($options);
		}
		$list = [];
		$handle = opendir($dir);
		if($handle === false)
		{
			throw new InvalidParamException("Unable to open directory: $dir");
		}
		while(($file = readdir($handle)) !== false)
		{
			if($file === '.' || $file === '..')
			{
				continue;
			}
			$path = $dir . DIRECTORY_SEPARATOR . $file;
			if(static::filterPath($path, $options))
			{
				
				$list[] = $path;
				
				if(! isset($options['recursive']) || $options['recursive'])
				{
					$list = array_merge($list, static::findFiles($path, $options));
				}
			}
		}
		closedir($handle);
		
		return $list;
	}

	/**
	 *
	 * @param array $options
	 *        	raw options
	 * @return array normalized options
	 */
	private static function normalizeOptions (array $options)
	{
		if(! array_key_exists('caseSensitive', $options))
		{
			$options['caseSensitive'] = true;
		}
		if(isset($options['except']))
		{
			foreach($options['except'] as $key => $value)
			{
				if(is_string($value))
				{
					$options['except'][$key] = self::parseExcludePattern($value, $options['caseSensitive']);
				}
			}
		}
		if(isset($options['only']))
		{
			foreach($options['only'] as $key => $value)
			{
				if(is_string($value))
				{
					$options['only'][$key] = self::parseExcludePattern($value, $options['caseSensitive']);
				}
			}
		}
		return $options;
	}
}