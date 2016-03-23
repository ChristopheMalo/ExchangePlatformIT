ExchangePlatformIT
==================

A job offers web site for IT - Project based on Symfony 2

## Memento

- Create project: symfony new [ProjectName] [number_symfony_version] -> ex: symfony new ExchangePlatform 2.7
- On MAC, chmod 777 app/cache and chmod 777 app/logs (use sudo if error)
- Create the bundle Platform, start the generator -> php app/console generate:bundle
- Bundle namespace: OC/PlatformBundle
- Bundle name (keep symfony choice): OCPlatformBundle
- Choose the destination (keep the symfony choice)
- Configuration format: yml
- Whole directory (minimum - keep the choice 'no')
- Confirm the generation
- Confirm by enter all the next questions
- Code the route in the bundle
- Code the controller in the bundle
- Code the view in the bundle
- Empty cache (dev): php app/console cache:clear
- Empty cache (before send to production): php app/console cache:clear --env=prod
- Or manually empty the folder due to right access on OSX
- To get the list of available services: php app/console container:debug
- To display all the route in console: php app/console router:debug
- To display all the commands: php app/console list
- To display specific help: php app/console help [command] -> ex: php app/console command list
- To remove folder with files in console: rm -rf [folder-name]

## Memento Doctrine
- Create the database: php app/console doctrine:database:create
- Generate Entity: php app/console generate:doctrine:entity
- Name Entity: OCPlatformBundle:Advert - [BundleName]:[EntityName]
- Keep [annotation] - select by enter
- Enter field name, enter, and type name enter - for all fiels of the entity
- Enter when finish
- Create the repository -> yes and enter
- Confirm generation
- To check the table that will be created: php app/console doctrine:schema:update --dump-sql
- To create the table: php app/console doctrine:schema:update --force
- After entity modification (exemple: add new attribute): php app/console doctrine:generate:entities OCPlatformBundle:Advert
- Check the query before update DB: php app/console doctrine:schema:update --dump-sql
- Update database: php app/console doctrine:schema:update --force
- To test DQL query: php app/console doctrine:query:dql 'SELECT a FROM OCPPlatformBundle:Advert a'

## Memento for fixtures
- Insert datas in DB (Fixtures): php app/console doctrine:fixtures:load

## Memento Form
- Create a form builder, the result here, AdvertType.php : php app/console doctrine:generate:form OCPlatformBundle:Advert (Advert here is the entity that needs form)

## Memento User
- Update with composer just the necessary bundle: composer update friendsofsymfony/user-bundle
- To create user with FOSUserBundle: php app/console fos:user:create
- Add role to FOSUSerBundle User, example: ROLE_ADMIN to testuser: php app/console fos:user:promote testuser ROLE_ADMIN

## Memento Assetic
- Export CSS & JS for production: php app/console assetic:dump --env=prod

## Memento web browser Console
- Install dependencies to use coresphere/console-bundle
- php composer update
- Register the bundle in AppKernel.php (Dev part only)
- Register the route (follow the readme bundle)
- Install the assets: php app/console assets:install web
- Use the console: http://to-the-path/_console
- In console not use: php app/console [command] but directly [command]

## Memento Production
- Prepare the app in local environment
    - Clear cache in dev: php app/console cache:clear
    - Clear cache for prod: php app/console cache:clear --env=prod
    - Empty cache and log folder
    - Test the environment production: activate debugger (true) for prod environment in web/app.php
    - After test, return to false
    - Personalize error pages
    - Install web browser console
    - Check quality code (with insight.sensiolabs.com)
    - Check dependencies security (send composer.lock to security.sensiolabs.org or in console: php app/console security:check
- Send files, check and prepare the production server
    - send files/folders (app, bin, src, web + 2 composer files)
    - Check compatibility production server with web/config.php
    - If problem with date.timezone, i use PLESK, i'm in France; in PLESK GUI, php config, add: date.timezone = "Europe/Paris"
    - chmod app/cache and app/log folder to 777
    - Install dependencies: composer install (carefully with the PHP Version in platform config)
    - If problem with composer, zip vendor, send by FTP and unzip in SSH console: unzip vendor.zip
    - Autorize dev environment to debug the site in production (add personal IP, update if dynamical)
    - Create the database (manual or if possible: php app/console doctrine:database:create)
    - Create the table: php app/console doctrine:schema:update --force
    - Check the site (dev and prod environment)
    - Rewrite URL or add virtualhost (In PLESK, simply use the GUI to redirect to /web folder)
    

## Iteration 1
- Initialize the project
- Code bundle (Advert and Core)
- Add static data to test the iteration

## Iteration 2
- Use Doctrine

## Iteration 3
- Use Form in Symfony 2

## Iteration 4
- Add security
- Manage users

## Iteration 5
- Use services (Advanced)
- Add CK Editor as service
- Add calls in services

## Iteration 6
- Use events and the events manager

## Iteration 7
- Use translator

## Iteration 8
- Use existing ParamConverters
- Create ParamConverters
- Personalize error pages
- Use Assetic for CSS & JS
- Use console in web browser
- Send web site in production

## Copyright
**An original idea of Alexandre Bacco for :** [a work practice of Openclassrooms](https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony2) - **Adapted and directed :** Christophe Malo
