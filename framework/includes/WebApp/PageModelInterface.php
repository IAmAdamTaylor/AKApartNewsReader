<?php

namespace WebApp;

interface PageModelInterface
{
		const STATE_BLANK = '0';
		const STATE_SUCCESS = '1';
		const STATE_ERROR = '2';

		public function setState( $state );
		public function getState();
}
