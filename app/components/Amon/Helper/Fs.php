<?php

namespace Amon\Helper;

use Amon\Helper\Str;

use DirectoryIterator;

class Fs
{
    final public static function getOwner(DirectoryIterator $file): string
    {
        if (!function_exists('posix_getpwuid')) {
            return getenv('USERNAME') ?: (string)getenv('USER');
        }

        $user  = posix_getpwuid($file->getOwner());
        $group = posix_getgrgid($file->getGroup());

        $userName  = !empty($user['name'])  ? $user['name'] : '-?-';
        $groupName = !empty($group['name']) ? $group['name'] : '-?-';

        return $userName . ' / ' . $groupName;
    }

	final public static function createDirectory(string $dir): bool
	{
		$dir = Str::pathFixSlashes($dir);
		$result = true;
		if (! is_dir($dir)) {
			$path = explode(DIRECTORY_SEPARATOR, $dir);
			$tmpPath = "";
			foreach ($path as $subFolder) {
				if (empty($subFolder)) {
					$tmpPath .= DIRECTORY_SEPARATOR;
				}
				
				$tmpPath .= $subFolder . DIRECTORY_SEPARATOR;
				if (! is_dir($tmpPath)) {
					$result = $result && mkdir($tmpPath);
				}
			}
		}
		return $result;
	}
	
	final public static function removeDirectory(string $dir): bool
	{
		$dir = Str::dirSeparator($dir);
		
		if (! is_dir($dir)) {
			return false;
		}
		
		$result = true;
		if ($handle = opendir($dir)) {
			$dirsToVisit = array();
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if (is_dir($dir . $file)) {
						$dirsToVisit[] = $dir . $file;
					} else 
						if (is_file($dir . $file)) {
							$result = $result && unlink($dir . $file);
						}
				}
			}
			closedir($handle);
			foreach ($dirsToVisit as $w) {
				$result = $result && self::removeDirectory($w);
			}
		}
		$result = $result && rmdir($dir);
		return $result;
	}
}
