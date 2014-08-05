Feature: In order to interact with the system
  As a member
  I should to interact with security system successfully

  @reset-schema
  Scenario: I can not see homepage when I am not logged in
    When I go to the homepage
    Then I should be on the login page
    And I should see "Please, sign in"

  @reset-schema
  Scenario: As a new member I should register successfully
    Given I am on the login page
    And I have an account with the following:
      | username | plain_password | email         | enabled | first_name | last_name |
      | andrew   | 12345678       | test@test.com | true    | andrew     | andrew    |
    When I fill in the following:
      | username | andrew   |
      | password | 12345678 |
    And I press "Login"
    Then I should be on the profile page
    And I should see "Hello, andrew"

  @reset-schema
  Scenario: I am not logged in member who wants to login with invalid credentials
    Given I am on the login page
    And I have an account with the following:
      | username | plain_password | email         | enabled | first_name | last_name |
      | andrew   | 12345678       | test@test.com | true    | andrew     | andrew    |
    When I fill in the following:
      | username | andrew |
      | password | 12     |
    And I press "Login"
    Then I should be on the login page
    And I should see "Invalid username or password"
