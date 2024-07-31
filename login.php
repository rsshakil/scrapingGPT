<?php

require 'vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;

try {
    // Start the browser
    $host = 'http://localhost:4444/wd/hub'; // Selenium Hub URL
    $capabilities = DesiredCapabilities::chrome();
    $options = new \Facebook\WebDriver\Chrome\ChromeOptions();
    $options->addArguments(['start-maximized']);
    $capabilities->setCapability(\Facebook\WebDriver\Chrome\ChromeOptions::CAPABILITY, $options);

    $driver = RemoteWebDriver::create($host, $capabilities);

    // Navigate to a web page
    $driver->get('https://chatgpt.com');

    // Find an element
    // $element = $driver->findElement(WebDriverBy::name('q'));

    // // Interact with the element
    // $element->sendKeys('Hello WebDriver');
    // $element->submit();

    // Take a screenshot
    $driver->takeScreenshot('screenshot.png');

    // Close the browser
    $driver->quit();

    echo "Test Completed\n";
} catch (\Exception $e) {
    echo "An error occurred: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString();
}
