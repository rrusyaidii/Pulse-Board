<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['url', 'form'];

    protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->session = session();

        // Get URI segments
        $uri = service('uri');
        $segments = $uri->getSegments();

        $currentController = strtolower($segments[0] ?? 'home');
        $currentMethod = strtolower($segments[1] ?? 'index');

        // List of controllers or routes allowed without login
         $publicRoutes = [
        'auth',     // allow access to /auth/login, /auth/register etc.
        'logins',   // in case your login controller is named Logins
        '',         // allow /
    ];

        // If user is not logged in and trying to access a restricted controller
        if (!$this->session->get('logged_in') && !in_array($currentController, $publicRoutes)) {
            header('Location: ' . base_url('/auth/login'));
            exit; // IMPORTANT: ensure execution stops
        }
    }
}
