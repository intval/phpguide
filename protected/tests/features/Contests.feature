Feature: Contests
  Testing the work of contests on the site

Background:

  Given Database contains ContestProblem:
    | problemid | contestid | title     | shortDesc | text         |
    |   1       | 1         | p1titlexx | descp1xx  | textp1blabla |

  And   Database contains User:
    | login   | email      | password | salt |
    | testuser| test@ya.ru | $2a$06$78jytO3OMADLNsIvFJxJ7eeFtAP7vrFtjXRjjUiI2dXrIfN29t7XC | 78jytO3OMADLNsIvFJxJ7i |


Scenario: I can read problem text
  Given I am not authorized
  When  I am on "/contest/problem/1"
  Then  I should see "p1titlexx"
  And   I should see "textp1blabla"

Scenario: Unauthorized user sees login popup on submission
  Given I am not authorized
  When  I am on "/contest/problem/1"
  Then  I should see an "input#contestSolutionSubmitButton" element
  When  I type into ace_editor:
    """
    123
    """
  And   I press "contestSolutionSubmitButton"
  Then  I should see "רק משתמשים רשומים"


Scenario: Authorized user can submit solution
  Given I am on "/contest/problem/1"
  And   I am authorized as "testuser" pass "123456"
  And   I memorize count of "div.singleSubmitResult" elements
  When  I type into ace_editor:
    """
    123
    """
  And   I press "contestSolutionSubmitButton"
  Then  I wait for the submission ajax request completion
  Then  Count of "div.singleSubmitResult" elements increased by 1