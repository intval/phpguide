<?php

use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

class ContestsContext extends PhpgMinkSubContext
{
    /**
     * @Then /^I wait for the submission ajax request completion$/
     */
    public function iWaitForTheSubmissionAjaxRequestCompletion()
    {
        $this->getSession()->wait(3500);
    }

} 