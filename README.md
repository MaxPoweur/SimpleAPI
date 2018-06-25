Simple API with 'Alerts' and 'Users' entities
==========================


*Built with API Platform and Symfony*

[![API Platform](https://api-platform.com/logo-250x250.png)](https://api-platform.com)

The official API Platform documentation is available **[on the API Platform website][31]**.

Purposes
-------

This project is meant to get started with a simple API implementing powerfull features :

  - **JWT Authentication**
  - **Validators** on objects fields supplied by users
  - The use of an **ORM (doctrine)** to deal with the database in a sweet way
  - Indicate some fields as Readable and/or Writable by users
  - A simple but securized **membership management**
  
 The use of **Symfony make** this API maintainable, sustainable and easy to configure.
  
Demonstration
-------

You can find the documentation **[there][37]**.

To get started, you first need to get authenticated.


Here is a demonstration account :

 *  **_username**: demoUsername
  
 *  **_password**: @demoPass
  
  
To authenticate yourself, send [_username, _password] as a POST request to this login page : 
http://82.165.202.90/login_check

You will receive a **token** used to access the api resources ( /users, /pages ... ).
  
You said API Platform ?
-------

API Platform is a next-generation PHP web framework designed to easily create
API-first projects without compromising extensibility and
flexibility:

* **Expose in minutes an hypermedia REST API** that works out of the box by reusing
  entity metadata (ORM mapping, validation and serialization) ; that embraces [JSON-LD][1],
  [Hydra][2] and such other data formats like [HAL][32], [YAML][33], [XML][34] or [CSV][35]
  and provides a ton of features (CRUD, validation and error handling, relation embedding, filters, ordering...)
* Enjoy the **beautiful automatically generated API documentation** (Swagger)
* Use our awesome code generator to **bootstrap a fully-functional data model from
  [Schema.org][8] vocabularies** with ORM mapping and validation (you can also do
  it manually)
* Easily add **[JSON Web Token][25] or [OAuth][26] authentication**
* Create specs and tests with a **developer friendly API context system** on top
  of [Behat][10]
* Develop your website UI, webapp, mobile app or anything else you want using
  **your preferred client-side technologies**! Tested and approved with **React**, **AngularJS**
  (integration included), **Ionic**  and **native mobile** apps

-------

Created by [Adam Rotard][23]. Owner of [TheWebdev][30]
Support available upon request.

[1]:  http://json-ld.org
[2]:  http://hydra-cg.com
[3]:  https://getcomposer.org
[4]:  http://www.hydra-cg.com/
[5]:  https://symfony.com
[6]:  http://www.doctrine-project.org
[7]:  https://api-platform.com/docs/schema-generator/
[8]:  http://schema.org
[9]:  https://api-platform.com/docs/core/getting-started#installing-api-platform-core
[10]: https://behat.readthedocs.org
[11]: https://github.com/Behatch/contexts
[12]: https://github.com/nelmio/NelmioCorsBundle
[13]: https://foshttpcachebundle.readthedocs.org
[14]: https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html
[15]: https://symfony.com/doc/current/book/doctrine.html
[16]: https://symfony.com/doc/current/book/templating.html
[17]: https://symfony.com/doc/current/book/security.html
[18]: https://symfony.com/doc/current/cookbook/email.html
[19]: https://symfony.com/doc/current/cookbook/logging/monolog.html
[20]: https://symfony.com/doc/current/bundles/SensioGeneratorBundle/index.html
[21]: https://github.com/lexik/LexikJWTAuthenticationBundle
[22]: https://github.com/FriendsOfSymfony/FOSOAuthServerBundle
[23]: https://www.linkedin.com/in/adam-rotard-080003142/
[24]: http://swagger.io/swagger-ui/
[25]: http://jwt.io/
[26]: http://oauth.net/
[27]: https://en.wikipedia.org/wiki/Linked_data
[28]: https://developers.google.com/structured-data/
[29]: http://searchengineland.com/tested-googlebot-crawls-javascript-heres-learned-220157
[30]: https://www.the-webdev.fr
[31]: https://api-platform.com
[32]: http://stateless.co/hal_specification.html
[33]: http://yaml.org/
[34]: https://www.w3.org/XML/
[35]: https://www.ietf.org/rfc/rfc4180.txt
[36]: https://github.com/dunglas/DunglasActionBundle
[37]: http://82.165.202.90/api/doc
