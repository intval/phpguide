<?php

/**
 * DateTime with support for __toString()
 * @author Alex Raskin <Alex@phpguide.co.il>
 */
class SDateTime extends DateTime
{
	public function __toString()
	{
		return $this->format('Y-m-d H:i:s');
	}
}