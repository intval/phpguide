<?php

use Behat\Behat\Event\StepEvent;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\MinkContext;

class PhpgMinkSubContext extends MinkContext
{

    const LOGIN_URL = '/login';
    const LOGIN_LOGOUT_URL = '/login/logout';
    protected $countMemorizer = [];

    /**
     * @BeforeScenario
     */
    public function BeforeScenario()
    {
        $disable = "SET FOREIGN_KEY_CHECKS = 0";
        $enable = "SET FOREIGN_KEY_CHECKS = 1";

        Yii::app()->db->createCommand($disable)->execute();

        foreach(Yii::app()->db->getSchema()->tableNames as $table)
        {
            Yii::app()->db->createCommand('TRUNCATE TABLE '.$table)->execute();
        }

        Yii::app()->db->createCommand($enable)->execute();
    }

    /**
     * Take screenshot when step fails.
     * Works only with Selenium2Driver.
     *
     * @AfterStep
     */
    public function takeScreenshotAfterFailedStep(StepEvent $event)
    {
        if (4 === $event->getResult()) {
            $driver = $this->getSession()->getDriver();

            if (!($driver instanceof Selenium2Driver)) {
                //throw new UnsupportedDriverActionException('Taking screenshots is not supported by %s, use Selenium2Driver instead.', $driver);
                return;
            }

            $screenshot = $driver->getWebDriverSession()->screenshot();
            file_put_contents('/vagrant/screen.png', base64_decode($screenshot));
        }
    }



    /**
     * @Given /^I am not authorized$/
     */
    public function iAmNotAuthorized()
    {
        $this->getSession()->reset();
        $this->visit(self::LOGIN_LOGOUT_URL);
    }

    /**
     * @Given /^Database contains ([-_a-zA-Z0-9]+):$/
     */
    public function AddRecordsToDb($model, TableNode $problemsTable)
    {
        if(!class_exists($model) || !is_subclass_of($model, 'CActiveRecord'))
            throw new \Exception("No such model found $model");

        foreach ($problemsTable->getHash() as $row)
        {
            /*** @var CActiveRecord $record */
            $record = new $model();

            foreach($row as $columnName => $columnValue)
                $record->$columnName = $columnValue;

            if(!$record->save())
                throw new \Exception("Can't store record: ".
                var_export($record->getErrors(), true));
        }
    }

    /**
     * @Given /^I am authorized as "([^"]*)" pass "([^"]*)"$/
     */
    public function AuthenticateAs($login, $pass)
    {
        $userModel = User::model()->findByAttributes(['login' => $login]);

        if(null === $userModel)
            throw new \Exception("User with login '$login' wasn't found");

        $session = $this->getSession();


        $currentUrl = $session->getCurrentUrl();
        $this->visit(static::LOGIN_URL);
        $this->clickLink('כבר יש לי שם משתמש וסיסמה לאתר');
        $this->fillField('loginname', 'testuser');
        $this->fillField('loginpass', '1234567');
        $this->iWaitMs(12000);
        $this->pressButton('loginSubmitBtn');
        $this->iWaitMs(4000);
        $this->assertUrlRegExp('#^/$#');
        $this->visit($currentUrl);
    }

    /**
     * @When /^I type into ace_editor:/
     */
    public function iTypeIntoAceEditor(PyStringNode $text)
    {
        $text = addcslashes($text->getRaw(), "\\'");
        $script = "window.ace_editor.getSession().setValue('$text');";
        $this->getSession()->executeScript($script);
    }


    /**
     * @Given /^I memorize count of "(?P<element>[^"]*)" elements$/
     */
    public function MemorizeCountOfElements($element)
    {
        $nodes = $this->getSession()->getPage()->findAll('css', $element);

        if (null === $nodes) {
            throw new ElementNotFoundException
                ($this->getSession(), 'element: '.$element.' ');
        }

        $this->countMemorizer[$element] = count($nodes);
    }


    /**
     * @Then /^Count of "(?P<element>[^"]*)" elements increased by (-?\d+)$/
     */
    public function countOfElementsIncreasedBy($element, $count)
    {
        if(!isset($this->countMemorizer[$element]))
            throw new \Exception("Should have MemoreCountOfElements ".
                "step first");

        $previously = $this->countMemorizer[$element];

        $this->assertNumElements($previously + $count, $element);
    }


    /**
     * @Given /^I wait (\d+) ms$/
     */
    public function iWaitMs($time)
    {
        $this->getSession()->wait($time);
    }

} 