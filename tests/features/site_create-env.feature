Feature: Working with multidev environments
  In order to work collaboratively on Pantheon
  As a user
  I need to be able to create, remove, and alter multidev environments.

  Background: I am authenticated and have a site named [[test_site_name]]
    Given I am authenticated
    And a site named "[[test_site_name]]"

  @vcr site_create-env
  Scenario: Create a multidev environment
    When I run "terminus site create-env --site=[[test_site_name]] --from-env=dev --to-env=multidev"
    Then I should get: "."
    And I should get:
    """
    Creating Multidev environment "multidev"
    """
