# DummyApplication
tests build demo application

# Chronology:

1. We are do Create structural file system
    * Public folder
        * index.php
        * assets/ folder for resources Pictures, Styles and Script for site semantic
    * Folder organization of the core
        * App - my application folder
        * Jungle - git submodule Jungle.git
2. We are use `$ cd core && git clone https://github.com/Lexus27/Jungle.git Jungle`
3. We inherit the base `Jungle\Application` classes for mca-organizing system 
    * And place them in the root of our application with namespace `App/Modules/...` `App/Model/...`
    * We define our logic for basic services in method `App\Application::registerServices(DiInterface $di)`
    > must have services: `event_manager` and `crash_reporter`
    * In method `App\Application::initializeView` we are do initialize `View` instance
    * In method `App\Application::initializeViewRenderers` need have set aliased Renderers
     
4. MCA-Module define intercepted exception behaviour for `Process::getTask('access')` and forward to our `denied` mca-action reference

5. First of all before Hello World, we must create a system of mca - is `Module`, `Controller` and `Action` to reference `#index:index:index` as default in our application
    > The same applies to our html templates in the `App/Views/html` folder
6. Define services to our `RequestStrategy`(`Http`)
   * Service `router` general service for routing in application on concrete `Strategy`
   * Service `view_strategy` for recognizing semantic to target `renderer` for current `Request` 
   * Service `session` need instance SessionManager
   * Service `cookie` need instance CookieManager
   * Service `account` need instance \Jungle\User\Account, for work with users
   
   
> Folder `App/Services` must contains custom extended services and our classes uses in application work 