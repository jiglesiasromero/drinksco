Feature: Create a new seller
  I want to create a new seller given the name

Scenario: Create seller
  When Send a "POST" request to "/drinksco/v1/sellers" with body:
  """
   {
      "name": "article-from-behat"
   }
  """
  Then Response status code should be 201
  And Response content should be:
  """
    {}
  """

Scenario: Delete seller
  Given A valid seller with id "e0d13249-a427-4a99-a0ae-74efc2f7955c" and name "product-behat"
  When Send a "DELETE" request to "/drinksco/v1/sellers/e0d13249-a427-4a99-a0ae-74efc2f7955c"
  Then Response status code should be 204
