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