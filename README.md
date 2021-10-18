# Drinks % co Code Challenge

### Index
1. [What do you need?](#what_do_you_need)
2. [How to install](#install)
3. [Testing](#testing)
4. [Technical decisions](#decisions)
5. [Static code analysis](#analysis)
6. [To improve](#to_improve)

<h2 id="what_do_you_need">What do you need?</h2>

1. Git
2. Docker

<h2 id="install">How to install</h2>

After clone this repo, run `make start` and it will create three containers:
- mysql 8.0
- php-fpm with php 7.4
- nginx

If it is the first time, we need to create the tables within the database. For that, run `make run-migrations`

<h2 id="testing">Testing</h2>

There are unit and acceptance tests. For the first ones, we use phpunit, and for the second one, behat.

You can run with these two commands:
- `make unit-tests`
- `make behat`

<h2 id="decisions">Technical decisions</h2>
It may seems a overkill solution for the challengue. And it is. There is much more than is asked for the test but I wanted to show you what I know in terms of:
- DDD
- Clean architectures
- Symfony
- Testing
- Use docker together with Symfony

Moreover,  I wanted to use this technical test to learn and do things for the first time:
- Configure a command bus with Tactician
- Create and run migrations with Doctrine
- Set up and use doctrine dbal as database abstraction layer
- Install and configure phpunit and behat
- Set up PHPStan as static analysis tool

Regarding the domain models, I decided to make them as much simple as possible:
- Seller: It has two value objects. Id and Name. The Id is auto generated when creating it. I also had the option to pass through the request body, but I chose this one.
- Product: It has four value objects. Id, name, price and seller. The seller one has an Id. We use the seller id to check when we are creating a new product, the seller exists.
- Item: An item is one line of a cart. It has the id, product, quantity, user id and status. The product is a value object with its id. The amount, which is one by default. The user id which is how we know the products the users have on their carts. A user can only has one cart.


<h2 id="analysis">Static code analysis</h2>
Execute static code analysis with phpstan `make phpstan`

<h2 id="to_improve">To improve</h2>
<b>Commits:</b> Regarding the length of commits, some of them was fine since they were not so long and it was well defined about what was added [e1c1ec4e75004de19e46a3cac349bb7bdc9b9426](https://gitlab.com/retadani/jose.iglesias/-/merge_requests/1/diffs?commit_id=e1c1ec4e75004de19e46a3cac349bb7bdc9b9426)

But in others, I was developing a new use case and I realised that I had to refactor another part. At the end, I push all together and the commit was so long due to the amount of changes. It is a bad practice because it is easier, for example, when there is a bug and we have to check commit by commit. The longer they are, the more difficult are to review.
