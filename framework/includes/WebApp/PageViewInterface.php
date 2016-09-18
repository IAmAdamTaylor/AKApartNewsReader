<?php

namespace WebApp;

interface PageViewInterface
{
		public function output();

		public function getPageTitle();
		public function getMetaDescription();
}
