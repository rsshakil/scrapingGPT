<?php
require_once('vendor/autoload.php');
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use Facebook\WebDriver\WebDriverExpectedCondition;

// Start a browser session

// $host = 'http://localhost:4444/wd/hub'; // this is the default http://localhost:9515
$host = 'http://localhost:9515'; // this is the default http://localhost:9515
// $host = 'http://172.17.0.2:4444'; // this is the default
$capabilities = DesiredCapabilities::chrome();
$driver = RemoteWebDriver::create($host, $capabilities);

// Navigate to the login page

$driver->get('http://localhost:8000/register');
$driver->findElement(WebDriverBy::id('registration_form_email'))->sendKeys('demo9397@gmail.com');
sleep(2);

// パスワード
$driver->findElement(WebDriverBy::id('registration_form_plainPassword'))->sendKeys('123456');
$driver->findElement(WebDriverBy::id('registration_form_name'))->sendKeys('Sakil');
$driver->findElement(WebDriverBy::id('registration_form_agreeTerms'))->sendKeys('1');
// Locate the checkbox input by ID and check it
$checkbox = $driver->findElement(WebDriverBy::id('registration_form_agreeTerms')); // Replace 'myCheckboxId' with the actual ID

// Check if the checkbox is already selected
if (!$checkbox->isSelected()) {
    $checkbox->click(); // Click to check the checkbox
}

// Optionally, wait for some condition (e.g., the checkbox to be selected)
$driver->wait()->until(
    WebDriverExpectedCondition::elementToBeSelected($checkbox)
);

// Find the button by its text using XPath and click it
$buttonText = 'Register'; // Replace with the text of your button
$button = $driver->findElement(WebDriverBy::xpath("//button[text()='$buttonText']"));
$button->click();

// Optionally, wait for some condition after clicking the button
// $driver->wait()->until(WebDriverExpectedCondition::...);

$driver->get('http://localhost:8000/admin');

// Wait for 5 seconds
sleep(5);

echo "Button clicked successfully.\n";

// Close the browser
$driver->quit();



// Close the browser session

$driver->quit();
echo "selenium run ok";
?>