<?php

namespace WebApp\Page;

interface ViewInterface
{
		public function output();

		public function getPageTitle();
		public function getMetaDescription();
}
