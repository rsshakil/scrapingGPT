<?php

require 'vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Chrome\ChromeOptions;

// Helper function to add random delay
function randomDelay($min = 1, $max = 3) {
    sleep(rand($min, $max));
}

try {
    // Start the browser
    // $host = 'http://localhost:4444/wd/hub';//for docker in hidden wroking
    $host = 'http://localhost:9515';//for chrome driver
    $capabilities = DesiredCapabilities::chrome();
    $options = new \Facebook\WebDriver\Chrome\ChromeOptions();
    // $options->addArguments(['start-maximized']);
    $options->addArguments([
        '--start-maximized',
        '--no-sandbox',
        '--disable-dev-shm-usage',
        '--disable-gpu',
        '--disable-blink-features=AutomationControlled',
        '--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.107 Safari/537.36'
    ]);
    // $capabilities->setCapability(\Facebook\WebDriver\Chrome\ChromeOptions::CAPABILITY, $options);
    // Enable experimental options to further mask automation
    $prefs = [
        'excludeSwitches' => ['enable-automation'],
        'useAutomationExtension' => false
    ];
    $options->setExperimentalOption('prefs', $prefs);
    $options->setExperimentalOption('excludeSwitches', ['enable-automation']);
    $options->setExperimentalOption('useAutomationExtension', false);

    $capabilities = DesiredCapabilities::chrome();
    $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

    $textToFind = "Log in";
    $driver = RemoteWebDriver::create($host, $capabilities);

    // Locate the button (modify the selector to match your button's attributes)
    $buttonSelector = WebDriverBy::cssSelector('.my-button-class');

    // Locate the div by its text content
    $divSelector = WebDriverBy::xpath("//div[text()='{$textToFind}']");
    // Navigate to a web page
    // $driver->get('https://chatgpt.com');
    randomDelay(3, 5);
    $driver->get('https://auth.openai.com/authorize?client_id=TdJIcbe16WoTHtN95nyywh5E4yOo6ItG&scope=openid%20email%20profile%20offline_access%20model.request%20model.read%20organization.read%20organization.write&response_type=code&redirect_uri=https%3A%2F%2Fchatgpt.com%2Fapi%2Fauth%2Fcallback%2Flogin-web&audience=https%3A%2F%2Fapi.openai.com%2Fv1&device_id=b69fe7c2-c492-4be9-a141-f81efa8305fb&prompt=login&screen_hint=login&ext-statsig-tier=production&ext-oai-did=b69fe7c2-c492-4be9-a141-f81efa8305fb&flow=control&state=n1fghTbk72BmocP5JvGFripyeq9uPXdROn3Z4mbu_Ho&code_challenge=BLQwvddO2DCeESDx4kvE6pZHz61GZFUa-mYhX7tcZ_k&code_challenge_method=S256');

//loginByButton click 
try{
     // Wait for the email input to be visible and enter email
     $driver->wait()->until(
        WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('email'))
    );
    //input email email-input 
    $driver->findElement(WebDriverBy::cssSelector('.email-input'))->sendKeys('gene@hounds.tech');
    randomDelay(2, 4);
    $driver->findElement(WebDriverBy::cssSelector('.continue-btn'))->click();
    randomDelay(3, 5);
    // Wait for the password input to be visible and enter password
    $driver->wait()->until(
        WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('password'))
    );
    $driver->findElement(WebDriverBy::name('password'))->sendKeys('~4r+nqh$n-4h');
    randomDelay(3, 5);

    // Click the login button
    $loginButton = $driver->findElement(WebDriverBy::cssSelector('button[type="submit"]'));
    $loginButton->click();
    randomDelay(5, 7);

    // Handle CAPTCHA manually if it appears
    try {
        $captchaCheckbox = $driver->findElement(WebDriverBy::cssSelector('.g-recaptcha'));
        if ($captchaCheckbox) {
            echo "CAPTCHA found. Please solve it manually.\n";
            sleep(60);  // Adjust time as necessary for manual intervention
        }
    } catch (NoSuchElementException $e) {
        echo "CAPTCHA not found.\n";
    }

    // Check if login was successful by verifying the presence of a known element on the home page
    try {
        $homeElement = $driver->findElement(WebDriverBy::id('prompt-textarea')); // Adjust the selector
        if ($homeElement) {
            echo "Login successful.\n";
        }
    } catch (NoSuchElementException $e) {
        echo "Login failed or CAPTCHA not solved.\n";
    }

     // Check if login was successful by verifying the presence of a known element on the home page
     try {
    
        // Check if redirected to an error page
        if (strpos($driver->getCurrentURL(), '/auth/error') !== false) {
            echo 'OAuth callback error occurred during login. Please try again';
        }

    } catch (NoSuchElementException $e) {
        echo "Login failed or CAPTCHA not solved.\n";
    }

} catch (NoSuchElementException $e) {
    echo "Login button not found.\n";
}

    // Take a screenshot
    $driver->takeScreenshot('screenshot.png');

    // Close the browser
    $driver->quit();

    echo "Test Completed\n";
} catch (\Exception $e) {
    echo "An error occurred: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString();
}
