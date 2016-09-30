<?php

namespace RelativeDate;
use DateInterface;
use DateTime as _DateTime;
use DateTimeZone;

/**
 * RelativeDate\DateTime
 * A relative version of the DateTime class, returns a RelativeDate\DateInterval instead of the standard DateInterval.
 */
class DateTime extends _DateTime
{
	/**
	 * Constructor.
	 * @param string            $time     
	 * @param DateTimeZone|null $timezone
	 */
	public function __construct( $time = 'now', DateTimeZone $timezone = null )
	{
		parent::__construct( $time, $timezone );
	}

	/**
	 * Override the parent diff method to return a relative date interval.
	 * @param  DateTimeInterface $date     
	 * @param  boolean           $absolute 
	 * @return RelativeDate\DateInterval                      
	 */
	public function diff( $date2, $absolute = false )
	{
		// Call parent diff method
		$interval = parent::diff( $date2 );

		// Convert DateInterval class into relative version
		$relativeInterval = new DateInterval();
		foreach (get_object_vars( $interval ) as $key => $name) {
      $relativeInterval->$key = $name;
    }
		
		return $relativeInterval;
	}
}
