<?php
namespace common\helpers;

use yii\helpers\BaseArrayHelper;
use yii\base\Object;
use common\base\Exception;
use common\base\UserException;
use dosamigos\qrcode\lib\Enum;
use dosamigos\qrcode\QrCode;

/**
 * 68Shop 图片操作工具类
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
class ImageHelper extends Object
{

	/**
	 * 创建图片的缩略图
	 *
	 * @access public
	 * @param string $img
	 *        	原始图片的路径
	 * @param int $thumb_width
	 *        	缩略图宽度
	 * @param int $thumb_height
	 *        	缩略图高度
	 * @param strint $path
	 *        	指定生成图片的目录名
	 * @return mix 如果成功返回缩略图的路径，失败则返回false
	 */
	public static function make_thumb ($img, $thumb_width = 0, $thumb_height = 0, $path = '', $bgcolor = '')
	{
		$gd = static::gd_version(); // 获取 GD 版本。0 表示没有 GD 库，1 表示 GD 1.x，2 表示 GD 2.x
		if($gd == 0)
		{
			throw new UserException(t('@common', 'not install GD library'));
		}
		
		/* 检查缩略图宽度和高度是否合法 */
		if($thumb_width == 0 && $thumb_height == 0)
		{
			return str_replace('\\', '/', realpath($img));
		}
		
		/* 检查原始文件是否存在及获得原始文件的信息 */
		$org_info = @getimagesize($img);
		
		if(! $org_info)
		{
			throw new UserException(t('@common', 'missing orgin image {0}', $img));
		}
		
		$type_maping = array(
			1 => 'image/gif', 
			2 => 'image/jpeg', 
			3 => 'image/png'
		);
		
		$image_type = $org_info[2];
		
		if(! static::check_img_function($org_info[2]))
		{
			throw new UserException(t('@common', 'not support image type {0}', static::getImageExtensions($org_info[2])));
		}
		
		$img_org = static::img_resource($img, $org_info[2]);
		
		/* 原始图片以及缩略图的尺寸比例 */
		$scale_org = $org_info[0] / $org_info[1];
		/* 处理只有缩略图宽和高有一个为0的情况，这时背景和缩略图一样大 */
		if($thumb_width == 0)
		{
			$thumb_width = $thumb_height * $scale_org;
		}
		if($thumb_height == 0)
		{
			$thumb_height = $thumb_width / $scale_org;
		}
		
		/* 创建缩略图的标志符 */
		if($gd == 2)
		{
			$img_thumb = imagecreatetruecolor($thumb_width, $thumb_height);
		}
		else
		{
			$img_thumb = imagecreate($thumb_width, $thumb_height);
		}
		
		/* 背景颜色 */
		if(empty($bgcolor))
		{
			$bgcolor = "#FFFFFF";
		}
		
		$bgcolor = trim($bgcolor, "#");
		sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
		$clr = imagecolorallocate($img_thumb, $red, $green, $blue);
		imagefilledrectangle($img_thumb, 0, 0, $thumb_width, $thumb_height, $clr);
		
		if($org_info[0] / $thumb_width > $org_info[1] / $thumb_height)
		{
			$lessen_width = $thumb_width;
			$lessen_height = $thumb_width / $scale_org;
		}
		else
		{
			/* 原始图片比较高，则以高度为准 */
			$lessen_width = $thumb_height * $scale_org;
			$lessen_height = $thumb_height;
		}
		
		$dst_x = ($thumb_width - $lessen_width) / 2;
		$dst_y = ($thumb_height - $lessen_height) / 2;
		
		/* 将原始图片进行缩放处理 */
		if($gd == 2)
		{
			imagecopyresampled($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);
		}
		else
		{
			imagecopyresized($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);
		}
		
		/* 创建目录 */
		if(empty($path))
		{
			// 如果目录为空则存放在当前图片的目录下
			$dir = dirname($img) . '/';
		}
		else
		{
			$dir = $path;
		}
		
		/* 如果目标目录不存在，则创建它 */
		if(! file_exists($dir))
		{
			if(! make_dir($dir))
			{
				/* 创建目录失败 */
				throw new \Exception(t('@common', 'directory {0} is readonly', $dir));
			}
		}
		
		/* 如果文件名为空，生成不重名随机文件名 */
		// 文件名称采用图片原名+宽度+高度的命名规则
		
		$extension = '.' . pathinfo($img, PATHINFO_EXTENSION);
		
		$filename = basename($img, $extension) . '_' . $thumb_width . '_' . $thumb_height . $extension;
		
		/* 生成文件 */
		if($type_maping[$image_type] == 'image/jpeg' && function_exists('imagejpeg'))
		{
			imagejpeg($img_thumb, $dir . $filename);
		}
		elseif($type_maping[$image_type] == 'image/gif' && function_exists('imagegif'))
		{
			imagegif($img_thumb, $dir . $filename);
		}
		elseif($type_maping[$image_type] == 'image/png' && function_exists('imagepng'))
		{
			imagepng($img_thumb, $dir . $filename);
		}
		else
		{
			throw new UserException(t('@common', 'create image failure') . '不支持的图片类型：' . $extension);
		}
		
		imagedestroy($img_thumb);
		imagedestroy($img_org);
		
		// 确认文件是否生成
		if(file_exists($dir . $filename))
		{
			return $dir . $filename;
		}
		else
		{
			throw new UserException(t('@common', 'write image failure'));
		}
	}

	/**
	 * 获得服务器上的 GD 版本
	 *
	 * @access public
	 * @return int 可能的值为0，1，2
	 */
	public static function gd_version ()
	{
		$version = - 1;
		
		if($version >= 0)
		{
			return $version;
		}
		
		if(! extension_loaded('gd'))
		{
			$version = 0;
		}
		else
		{
			// 尝试使用gd_info函数
			if(PHP_VERSION >= '4.3')
			{
				if(function_exists('gd_info'))
				{
					$ver_info = gd_info();
					preg_match('/\d/', $ver_info['GD Version'], $match);
					$version = $match[0];
				}
				else
				{
					if(function_exists('imagecreatetruecolor'))
					{
						$version = 2;
					}
					elseif(function_exists('imagecreate'))
					{
						$version = 1;
					}
				}
			}
			else
			{
				if(preg_match('/phpinfo/', ini_get('disable_functions')))
				{
					/* 如果phpinfo被禁用，无法确定gd版本 */
					$version = 1;
				}
				else
				{
					// 使用phpinfo函数
					ob_start();
					phpinfo(8);
					$info = ob_get_contents();
					ob_end_clean();
					$info = stristr($info, 'gd version');
					preg_match('/\d/', $info, $match);
					$version = $match[0];
				}
			}
		}
		
		return $version;
	}

	/**
	 * 根据来源文件的文件类型创建一个图像操作的标识符
	 *
	 * @access public
	 * @param string $img_file
	 *        	图片文件的路径
	 * @param string $mime_type
	 *        	图片文件的文件类型
	 * @return resource 如果成功则返回图像操作标志符，反之则返回错误代码
	 */
	public static function img_resource ($img_file, $mime_type)
	{
		switch($mime_type)
		{
			case 1:
			case 'image/gif':
				$res = imagecreatefromgif($img_file);
				break;
			
			case 2:
			case 'image/pjpeg':
			case 'image/jpeg':
				$res = imagecreatefromjpeg($img_file);
				break;
			
			case 3:
			case 'image/x-png':
			case 'image/png':
				$res = imagecreatefrompng($img_file);
				break;
			
			default:
				return false;
		}
		
		return $res;
	}

	/**
	 * 检查图片处理能力
	 *
	 * @access public
	 * @param string $img_type
	 *        	图片类型
	 * @return void
	 */
	public static function check_img_function ($img_type)
	{
		switch($img_type)
		{
			case 'image/gif':
			case 1:
				
				if(PHP_VERSION >= '4.3')
				{
					return function_exists('imagecreatefromgif');
				}
				else
				{
					return (imagetypes() & IMG_GIF) > 0;
				}
				break;
			
			case 'image/pjpeg':
			case 'image/jpeg':
			case 2:
				if(PHP_VERSION >= '4.3')
				{
					return function_exists('imagecreatefromjpeg');
				}
				else
				{
					return (imagetypes() & IMG_JPG) > 0;
				}
				break;
			
			case 'image/x-png':
			case 'image/png':
			case 3:
				if(PHP_VERSION >= '4.3')
				{
					return function_exists('imagecreatefrompng');
				}
				else
				{
					return (imagetypes() & IMG_PNG) > 0;
				}
				break;
			default:
				return false;
		}
	}

	/**
	 * 生成二维码
	 *
	 * @param string $text
	 *        	内容
	 * @param string $outfile
	 *        	输出文件
	 * @param string $logofile
	 *        	logo文件
	 * @param integer $level
	 *        	容错级别
	 * @param number $size
	 *        	尺寸
	 * @param number $margin        	
	 * @param string $saveAndPrint        	
	 */
	public static function qrcode ($text, $outfile, $logofile = false, $level = Enum::QR_ECLEVEL_Q, $size = 4, $margin = 1, $saveAndPrint = false)
	{
		if(! file_exists(dirname($outfile)))
		{
			FileHelper::createDirectory(dirname($outfile));
		}
		
		QrCode::png($text, $outfile, $level, $size, $margin, $saveAndPrint);
		
		if(! empty($logofile))
		{
			try
			{
				$QR = imagecreatefromstring(file_get_contents($outfile));
				$logo = imagecreatefromstring(file_get_contents($logofile));
				// 二维码图片宽度
				$QR_width = imagesx($QR);
				// 二维码图片高度
				$QR_height = imagesy($QR);
				// logo图片宽度
				$logo_width = imagesx($logo);
				// logo图片高度
				$logo_height = imagesy($logo);
				$logo_qr_width = $QR_width / 5;
				$scale = $logo_width / $logo_qr_width;
				$logo_qr_height = $logo_height / $scale;
				$from_width = ($QR_width - $logo_qr_width) / 2;
				// 重新组合图片并调整大小
				imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
				// 输出图片
				imagepng($QR, $outfile);
			}
			catch(\Exception $e)
			{
			}
		}
	}

	public static function getImageExtensions ($type)
	{
		return [
			0 => 'UNKNOWN', 
			1 => 'GIF', 
			2 => 'JPEG', 
			3 => 'PNG', 
			4 => 'SWF', 
			5 => 'PSD', 
			6 => 'BMP', 
			7 => 'TIFF_II', 
			8 => 'TIFF_MM', 
			9 => 'JPC', 
			10 => 'JP2', 
			11 => 'JPX', 
			12 => 'JB2', 
			13 => 'SWC', 
			14 => 'IFF', 
			15 => 'WBMP', 
			16 => 'XBM', 
			17 => 'ICO', 
			18 => 'COUNT'
		];
	}

	/**
	 * 将PNG图片转换为JPG图片
	 *
	 * @param string $png_file        	
	 * @return string 生成的JPG图片
	 */
	public static function png2jpg ($png_file, $jpg_file, $is_replace = false)
	{
		$srcFile = $png_file;
		
		$extension = pathinfo($png_file, PATHINFO_EXTENSION);
		
		if($extension == 'png')
		{
			$photoSize = GetImageSize($srcFile);
			$pw = $photoSize[0];
			$ph = $photoSize[1];
			$jpg_image = imagecreatetruecolor($pw, $ph);
			$bg = imagecolorallocate($jpg_image, 255, 255, 255);
			imagefill($jpg_image, 0, 0, $bg);
			// 读取图片
			$srcImage = ImageCreateFromPNG($srcFile);
			// 合拼图片
			imagecopyresampled($jpg_image, $srcImage, 0, 0, 0, 0, $pw, $ph, $pw, $ph);
			imagejpeg($jpg_image, $jpg_file, 90);
			imagedestroy($srcImage);
			
			return $jpg_file;
		}
		else
		{
			return false;
		}
	}

	/**
	 * 删除商品图片的缩略图文件
	 *
	 * @param string $name
	 *        	文件名
	 * @param string $file
	 *        	包含图片名称的绝对路径
	 */
	public static function delTempFile ($file)
	{
		if(! file_exists($file))
		{
			return false;
		}
		
		$file = FileHelper::normalizePath($file);
		
		$pathinfo = pathinfo($path);
		$filename = $pathinfo['filename'];
		$extension = $pathinfo['extension'];
		
		$images = scandir(dirname($file));
		
		foreach($images as $item)
		{
			if(preg_match("/" . $filename . "_(\d+)_(\d+)\." . $extension . "/i", $item))
			{
				@unlink(FileHelper::normalizePath(dirname($file) . '/' . $item));
			}
		}
	}
}