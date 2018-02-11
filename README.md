## Syfony Flex API Starter

This in an API starter kit built with Symfony flex and FOS bundles that help achieve a full fledged rest API with an OAuth 2.0 server.

[![Build Status](https://travis-ci.org/0xMatt/symfony-flex-api-starter.svg?branch=master)](https://travis-ci.org/0xMatt/symfony-flex-api-starter)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/0xMatt/symfony-flex-api-starter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/0xMatt/symfony-flex-api-starter/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/0xMatt/symfony-flex-api-starter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/0xMatt/symfony-flex-api-starter/?branch=master)

## Getting Started

Simply clone this repo, run `composer install`, modify your .env file and run `php bin/console server:run` to view the live development server!

## What does it include?

* [FOSRESTBundle](https://github.com/FriendsOfSymfony/FOSRestBundle)
* [FOSOAuthServerBundle](https://github.com/FriendsOfSymfony/FOSOAuthServerBundle)
* [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle)
* [NelmioAPIDocBundle](https://github.com/nelmio/NelmioApiDocBundle)
* [JSMSerializerBundle](https://github.com/schmittjoh/JMSSerializerBundle)


## Help me set up?

Sure. Getting setup with the available console commands can help make your life much easier during this initial process.

First things you may want to do are to setup a user and oauth client to make requests with.

```text
php bin/console fos:user:create
```
Followed by
```text
php bin/consle api:client:create
```

With your newly created client, you can authenticate with the OAuth server and user, so long as you at least had chosen the password grant type, otherwise authorize with the client_credentials spec.

```text
curl -X POST \
  http://localhost:8000/oauth/v2/token \
  -H 'accept: application/json' \
  -H 'content-type: application/x-www-form-urlencoded' \
  -d 'client_id=%client_id%&client_secret=%client_secret%&grant_type=client_credentials'
```

And you'll get your token!

```text
{
    "access_token": "YmZkNmNmN2I1Y2E3MGFhZTIzMjE0N2UyMGYyZTdjZTBiYzk4NzE4M2ExZTY3YThjODhkYzIxNDBkMjNiN2UzZg",
    "expires_in": 3600,
    "token_type": "bearer",
    "scope": "user"
}
```