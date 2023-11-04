<?php

namespace Amon\Helper;

class Validation
{
	
	final public static function hasWhitespace(string $string): bool
	{
		return (bool) preg_match('/\s/', $string);
	}
	
	final public static function isEmail(string $email, bool $checkDomain = true, bool $allowAlias = false): bool
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			return false;
		}
		
		if (! $allowAlias && strpos($email, '+') !== false) {
			return false;
		}
		
		if ($checkDomain) {
			// Check if the domain is real
			$domain = explode("@", $email, 2);
			return ! empty($domain[1]) ? checkdnsrr($domain[1]) : false;
		}
		return true;
	}
	
	final public static function isPhone(string $phone, bool $strict = false): bool
	{
		return (bool) preg_match(($strict ? '/^((\+|00)\d{1,4})?\d{9}$/' : '/^((\+|00)\d{1,4})?\d{9,}$/'), $phone);
	}
	
	final public static function isStreetName(string $name): bool
	{
		return (bool) preg_match('/^[\p{L} \.0-9\"\-]+$/ui', $name);
	}
	
	final public static function isCityName(string $name): bool
	{
		return (bool) preg_match('/^[\p{L} -]+$/ui', $name);
	}
	
	final public static function isBuildingNumber(string $name): bool
	{
		return (bool) preg_match('/^([0-9]+[A-Z]*[\/-]?)+$/i', $name);
	}
	
	final public static function isApartmentNumber(string $name): bool
	{
		return (bool) preg_match('/^[0-9]+[A-Z]*$/i', $name);
	}
	
	final public static function isNotEmpty($var): bool
	{
		return $var !== '' && !is_null($var);
	}
	
	final public static function isAlphabeticOnly(string $string, bool $includeSpace = true): bool
	{
		$regex = $includeSpace ? '/^[\p{L} ]+$/ui' : '/^[\p{L}]+$/ui';
		return (bool) preg_match($regex, $string);
	}
	
	final public static function isValidTimeStamp($timestamp): bool
	{
		return ((string) (int) $timestamp === $timestamp) && ($timestamp <= PHP_INT_MAX) && ($timestamp >= ~ PHP_INT_MAX);
	}
	
	final public static function isDateEmpty(string $date): bool
	{
		return DateHelper::isEmpty($date);
	}
	
	final public static function isFloat($value, bool $decimal = null): bool
	{
		$options = is_null($decimal) ? null : [
			'options' => [
				'decimal' => $decimal
			]
		];
		if ($options === null) {
			return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
		} else {
			return filter_var($value, FILTER_VALIDATE_FLOAT, $options) !== false;
		}
	}
	
	final public static function isInt($value, ?int $min = null, ?int $max = null): bool
	{
		$options = [
			'options' => []
		];
		if (! is_null($min)) {
			$options['options']['min_range'] = intval($min);
		}
		if (! is_null($max)) {
			$options['options']['max_range'] = intval($max);
		}
		if (empty($options['options'])) {
			return filter_var($value, FILTER_VALIDATE_INT) !== false;
		} else {
			return filter_var($value, FILTER_VALIDATE_INT, $options) !== false;
		}
	}
	
	final public static function isBoolean($value): bool
	{
		$result = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
		return $result !== null;
	}
	
	final public static function isUrl(string $url): bool
	{
		return (bool) preg_match("_(^|[\s.:;?\-\]<\(])(https?:\/\/[-\w;\/?:@&=+$\|\_.!~*\|'()\[\]%#,â�ş]+[\w\/#](\(\))?)(?=$|[\s',\|\(\).:;?\-\[\]>\)])_i", $url);
	}
}