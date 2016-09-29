<?php

class RelativeDateTime extends DateTime
{
	/**
	 * The limit that the relative style is used. 
	 * Past this limit the absolute style will be returned.
	 * @var integer
	 */
	var $_relativeLimit;

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
	 * Constructor. Use same interface as DateTime object
	 * @param string            $time     
	 * @param DateTimeZone|null $timezone
	 */
	public function __construct( $time = 'now', DateTimeZone $timezone = null )
	{
		// Default to 2 weeks in seconds
		$this->_relativeLimit = self::WEEK_IN_SECONDS * 2;

		parent::__construct( $time, $timezone );
	}

	/**
	 * Get the difference between this date time and now.
	 * The output will be absolute if the interval is larger than the relative limit.
	 * Otherwise, the output will be relative to now, e.g. 34 seconds ago, 1 week ago.
	 * @param  string $absolute_format The date format to use for absolute output.
	 * @return string                  The relative or absolute date, formatted.
	 */
	public function relativeDiffFromNow( $absoluteFormat = 'd/m/Y' )
	{
		$now = new DateTime( 'now', $this->getTimezone() );
		$interval = $this->diff( $now );
		$interval = abs( $this->_getIntervalSeconds( $interval ) );

		if ( $interval >= $this->_relativeLimit ) {
			return $this->format( $absoluteFormat );
		} else {
			return $this->_formatRelativeInterval( $interval );
		}
	}

	/**
	 * Set the upper limit used to show the relative timestamp.
	 * @param integer $limit The upper limit in seconds.
	 * @return self
	 */
	public function setRelativeLimit( $limit )
	{
		if ( $limit != $this->_relativeLimit ) {
			$this->_relativeLimit = $limit;
		}

		return $this;
	}

	/**
	 * Get the relative limit.
	 * @return integer
	 */
	public function getRelativeLimit()
	{
		return $this->_relativeLimit;
	}

	/**
	 * Convert a DateInterval object into a number of seconds.
	 * @param  DateInterval $interval
	 * @return integer
	 */
	private function _getIntervalSeconds( DateInterval $interval )
	{
		$seconds = $interval->s;
		$seconds += $interval->i * self::MINUTE_IN_SECONDS;
		$seconds += $interval->h * self::HOUR_IN_SECONDS;
		$seconds += $interval->d * self::DAY_IN_SECONDS;
		$seconds += $interval->m * self::MONTH_IN_SECONDS;
		$seconds += $interval->y * self::YEAR_IN_SECONDS;

		return $seconds;
	}

	/**
	 * Convert a number of seconds into a relative timestamp.
	 * @param  integer $interval The number of seconds.
	 * @return string
	 */
	private function _formatRelativeInterval( $interval )
	{
		$format = '%d %s ago';

		$type = _n( self::SECOND_SINGULAR, self::SECOND_PLURAL, floor( $interval ) );

		if ( $interval >= self::YEAR_IN_SECONDS ) {
			
			$interval /= self::YEAR_IN_SECONDS;
			$type = _n( self::YEAR_SINGULAR, self::YEAR_PLURAL, floor( $interval ) );

		} else if ( $interval >= self::MONTH_IN_SECONDS ) {

			$interval /= self::MONTH_IN_SECONDS;
			$type = _n( self::MONTH_SINGULAR, self::MONTH_PLURAL, floor( $interval ) );

		} else if ( $interval >= self::WEEK_IN_SECONDS ) {
			
			$interval /= self::WEEK_IN_SECONDS;
			$type = _n( self::WEEK_SINGULAR, self::WEEK_PLURAL, floor( $interval ) );

		} else if ( $interval >= self::DAY_IN_SECONDS ) {

			$interval /= self::DAY_IN_SECONDS;
			$type = _n( self::DAY_SINGULAR, self::DAY_PLURAL, floor( $interval ) );

		} else if ( $interval >= self::HOUR_IN_SECONDS ) {

			$interval /= self::HOUR_IN_SECONDS;
			$type = _n( self::HOUR_SINGULAR, self::HOUR_PLURAL, floor( $interval ) );

		} else if ( $interval >= self::MINUTE_IN_SECONDS ) {

			$interval /= self::MINUTE_IN_SECONDS;
			$type = _n( self::MINUTE_SINGULAR, self::MINUTE_PLURAL, floor( $interval ) );

		}

		return sprintf( $format, $interval, $type );
	}
}
