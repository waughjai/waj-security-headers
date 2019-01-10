<?php

declare( strict_types = 1 )
namespace WaughJ\WPToolsPage
{
	class WPToolsPage
	{
		public function __construct( string $slug, string $title, string $capability = 'administrator' )
		{
			$this->slug = $slug;
			$this->title = $title;
			$this->capability = $capability;
		}

		public function submit() : void
		{
			add_management_page( $this->title, $this->title, $this->capability, $this->slug, [ $this, 'render' ] );
		}

		public function render() : void
		{
			echo "<h1>{$this->title}</h1>";
		}

		private $slug;
		private $title;
		private $capability;
	}
}
