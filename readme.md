# TransLatte

This Symfony project may someday be a way to manage your translations.

I dunno, it's not ready yet, maybe it never will be.

## Getting Started

1. Clone the repo

        git clone git@github.com:Tekorius/TransLatte.git

2. Install Composer dependencies

        composer install

3. Create database, etc, ya'll know what to do

4. Create OAuth client

        ./c fos:oauth-server:create-client --redirect-uri="http://translatte.local/oauth/v2/callback" --grant-type="password"

5. Be happy?

## Libraries and Third Parties Used

### Composer

* [apache-pack](https://symfony.com/doc/current/setup/web_server_configuration.html)
* [annotations](https://symfony.com/doc/current/routing.html)
* [templating](https://symfony.com/doc/current/components/templating.html)
* [twig](https://symfony.com/doc/current/templating.html)
* [asset](https://symfony.com/doc/current/best_practices/web-assets.html)
* [doctrine](https://symfony.com/doc/current/doctrine.html)
* [maker](http://symfony.com/doc/current/bundles/SymfonyMakerBundle/index.html)
* [translator](http://symfony.com/doc/current/translation.html)
* [profiler](https://symfony.com/doc/current/profiler.html)
* [security](https://symfony.com/doc/current/security.html#security-user-providers)
* [serializer](http://symfony.com/doc/current/components/serializer.html)
* [expression-language](https://symfony.com/doc/current/components/expression_language.html)
* [form](https://symfony.com/doc/current/forms.html)
* [validator](http://symfony.com/doc/current/validation.html)

&nbsp;

* [friendsofsymfony/oauth-server-bundle](https://github.com/FriendsOfSymfony/FOSOAuthServerBundle)
* [nelmio/api-doc-bundle](https://symfony.com/doc/master/bundles/NelmioApiDocBundle/index.html)
