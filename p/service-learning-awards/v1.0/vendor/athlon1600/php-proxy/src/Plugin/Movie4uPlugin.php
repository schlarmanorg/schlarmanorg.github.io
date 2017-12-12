<?php
namespace Proxy\Plugin;

use Proxy\Plugin\AbstractPlugin;
use Proxy\Event\ProxyEvent;

use Proxy\Html;

class Movie4uPlugin extends AbstractPlugin {

	// Matches multiple domain names (abc.com, abc.de, abc.pl) using regex (you MUST use / character)
	protected $url_pattern = '/^abc\.(com|de|pl)$/is';
	// Matches a single domain name
	//protected $url_pattern = 'abc.com';

	public function onCompleted(ProxyEvent $event){

		$response = $event['response'];

		$html = $response->getContent();

		// do your stuff here...

		$response->setContent($html);
	}
}
?>
