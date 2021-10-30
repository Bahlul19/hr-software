<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Employees', 'action' => 'login']);
   // $routes->connect('/formview/*', ['controller' => 'Forms', 'action' => 'formView']);
    $routes->connect('/update/', ['controller' => 'UpdateRemainingLeaveDays', 'action' => 'updateUsingCronJob']);
    $routes->connect('/forgot/', ['controller' => 'Employees', 'action' => 'forgot']);
    $routes->connect('/forgot/', ['controller' => 'Employees', 'action' => 'forgot']);
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    // $routes->connect('/process-documentations', ['controller' => 'processDocumentations', 'action' => 'index']);
    // $routes->connect('/process-documentations/add', ['controller' => 'processDocumentations', 'action' => 'add']);
    // $routes->connect('/process-documentations/edit', ['controller' => 'processDocumentations', 'action' => 'edit']);
    // $routes->connect('/process-documentations/index', ['controller' => 'processDocumentations', 'action' => 'index']);
    // $routes->connect('/process-documentations/view', ['controller' => 'processDocumentations', 'action' => 'view']);
    // $routes->connect('/process-documentations/delete', ['controller' => 'processDocumentations', 'action' => 'delete']);
    // $routes->connect('/process-documentations/review', ['controller' => 'processDocumentations', 'action' => 'review']);
    // $routes->connect('/process-documentations/add-tags', ['controller' => 'processDocumentations', 'action' => 'add-tags']);
    // $routes->connect('/process-documentations/assign-processes', ['controller' => 'processDocumentations', 'action' => 'assign-processes']);
    // $routes->connect('/process-documentations/list-assign-processes', ['controller' => 'processDocumentations', 'action' => 'list-assign-processes']);
    // $routes->connect('/process-documentations/view-assigned-process', ['controller' => 'processDocumentations', 'action' => 'view-assigned-process']);
    // $routes->connect('/process-documentations/delete-assigned-process', ['controller' => 'processDocumentations', 'action' => 'delete-assigned-process']);
    // $routes->connect('/process-documentations/get-department-processes', ['controller' => 'processDocumentations', 'action' => 'get-department-processes']);
    // $routes->connect('/process-documentations/get-already-assigned-processes', ['controller' => 'processDocumentations', 'action' => 'get-already-assigned-processes']);    
    // // $routes->connect('/users/login', ['controller' => 'Employees', 'action' => 'login']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

// Router::scope('/report_download/:dateTo/:dateFrom/:empId/:leaveType/:id', function (RouteBuilder $routes) {
Router::scope('/report_download', function (RouteBuilder $routes) {
    $routes->addExtensions(['pdf']);
    $routes->connect('/', ['controller' => 'EmpLeaves', 'action' => 'downloadLeaveReport']);
});

