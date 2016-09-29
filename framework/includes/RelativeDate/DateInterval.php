<?php

namespace RelativeDate;
use DateInterval as _DateInterval;

class DateInterval extends _DateInterval
{
	/**
	 * Time interval constants
	 * @var integer
	 */
	const MINUTE_IN_SECONDS = 60;
	const HOUR_IN_SECONDS = 3600;
	const DAY_IN_SECONDS = 86400;
	const WEEK_IN_SECONDS = 604800;
	const MONTH_IN_SECONDS = 2592000;
	const YEAR_IN_SECONDS = 31104000;

	/**
	 * Constants to use when formatting for display.
	 * @var string
	 */
	const SECOND_SINGULAR = 'second';
	const SECOND_PLURAL = 'seconds';

	const MINUTE_SINGULAR = 'minute';
	const MINUTE_PLURAL = 'minutes';

	const HOUR_SINGULAR = 'hour';
	const HOUR_PLURAL = 'hours';

	const DAY_SINGULAR = 'day';
	const DAY_PLURAL = 'days';

	const WEEK_SINGULAR = 'week';
	const WEEK_PLURAL = 'weeks';

	const MONTH_SINGULAR = 'month';
	const MONTH_PLURAL = 'months';

	const YEAR_SINGULAR = 'year';
	const YEAR_PLURAL = 'years';

	/**
	 * Override constructor to have no arguments.
	 */
	function __construct() {}

	/**
	 * Override the parent format() method to return relative times.
	 * @param $format Optional, The format to return the relative interval in.
	 *                Defaults to '3 days ago', '23 minutes ago' style.
	 *                Use %s to represent the amount and $t to represent the type.
	 * @return string 
	 */
	public function format( $format = '%s %t ago' )
	{
		$seconds = $this->getTotalSeconds();
		$type = _n( self::SECOND_SINGULAR, self::SECOND_PLURAL, floor( $seconds ) );

		if ( $seconds >= self::YEAR_IN_SECONDS ) {
			
			$seconds /= self::YEAR_IN_SECONDS;
			$type = _n( self::YEAR_SINGULAR, self::YEAR_PLURAL, floor( $seconds ) );

		} else if ( $seconds >= self::MONTH_IN_SECONDS ) {

			$seconds /= self::MONTH_IN_SECONDS;
			$type = _n( self::MONTH_SINGULAR, self::MONTH_PLURAL, floor( $seconds ) );

		} else if ( $seconds >= self::WEEK_IN_SECONDS ) {
			
			$seconds /= self::WEEK_IN_SECONDS;
			$type = _n( self::WEEK_SINGULAR, self::WEEK_PLURAL, floor( $seconds ) );

		} else if ( $seconds >= self::DAY_IN_SECONDS ) {

			$seconds /= self::DAY_IN_SECONDS;
			$type = _n( self::DAY_SINGULAR, self::DAY_PLURAL, floor( $seconds ) );

		} else if ( $seconds >= self::HOUR_IN_SECONDS ) {

			$seconds /= self::HOUR_IN_SECONDS;
			$type = _n( self::HOUR_SINGULAR, self::HOUR_PLURAL, floor( $seconds ) );

		} else if ( $seconds >= self::MINUTE_IN_SECONDS ) {

			$seconds /= self::MINUTE_IN_SECONDS;
			$type = _n( self::MINUTE_SINGULAR, self::MINUTE_PLURAL, floor( $seconds ) );

		}

		$formatted = $format;
		$formatted = str_replace( '%s', floor( $seconds ), $formatted );
		$formatted = str_replace( '%t', $type, $formatted );

		return $formatted;
	}

	/**
	 * Convert a DateInterval object into a number of seconds.
	 * @param  DateInterval $interval
	 * @return integer
	 */
	public function getTotalSeconds()
	{
		$seconds = $this->s;
		$seconds += $this->i * self::MINUTE_IN_SECONDS;
		$seconds += $this->h * self::HOUR_IN_SECONDS;
		$seconds += $this->d * self::DAY_IN_SECONDS;
		$seconds += $this->m * self::MONTH_IN_SECONDS;
		$seconds += $this->y * self::YEAR_IN_SECONDS;

		return $seconds;
	}
}
