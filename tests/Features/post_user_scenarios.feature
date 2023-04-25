Feature: Post Users

  Scenario: Post an user
    Given the user requests body:
      | name       | email          |
      | Test name | test@email.com |
    When the demo scenario sends a POST request to "/api/user" with the given body
    Then the response should be received a JSON
    Then the response code must be 201
    Then the response must contain a key called "name"
    Then the response must contain a key called "email"
    Then the response "name" must be a "string"
    Then the response "email" must be a "email"


  Scenario: Post an user without email
    Given the user requests body:
      | name       | email     |
      | Test name |           |
    When the demo scenario sends a POST request to "/api/user" with the given body
    Then the response should be received a JSON
    Then the response should be received a JSON
    Then the response code must be 400
    Then the response must contain a key called "email"
    Then the response "email" must be equals to "This value can not be null or empty."

  Scenario: Post an user without name
    Given the user requests body:
      | name       | email      |
      |  | test@email.com |
    When the demo scenario sends a POST request to "/api/user" with the given body
    Then the response should be received a JSON
    Then the response should be received a JSON
    Then the response code must be 400
    Then the response must contain a key called "email"
    Then the response "email" must be equals to "This value can not be null or empty."

  Scenario: Post an existing user
    Given the following user exist:
      | name       | email          |
      | Test name | test@email.com |
    Given the user requests body:
      | name       | email          |
      | Test name | test@email.com |
    When the demo scenario sends a POST request to "/api/user" with the given body
    Then the response should be received a JSON
    Then the response code must be 200
    Then the response must contain a key called "name"
    Then the response must contain a key called "email"
    Then the response "name" must be a "string"
    Then the response "email" must be a "email"