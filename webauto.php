<?php 
require_once 'vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\DesiredCapabilities;
$host = 'http://localhost:9515';

$driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());

// Navigate to the web page
$driver->get('https://example.com/test_page.html');

// Validate the page title
$expected_title = 'Test Page';
if ($driver->getTitle() == $expected_title) {
    echo 'Page title is correct!' . PHP_EOL;
} else {
    echo 'Page title is incorrect!' . PHP_EOL;
}

// Check if an element has a specific CSS class
$element = $driver->findElement(WebDriverBy::id('test_element'));
$element_classes = $element->getAttribute('class');
if (strpos($element_classes, 'example_class') !== false) {
    echo 'Element has the correct CSS class!' . PHP_EOL;
} else {
    echo 'Element does not have the correct CSS class!' . PHP_EOL;
}

$driver->quit();
?>