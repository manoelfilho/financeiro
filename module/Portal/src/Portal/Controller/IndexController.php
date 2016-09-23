<?php
namespace Portal\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect as PaginatorDBSelectAdapter;

/**
 * Controlador do Módulo Portal
 * 
 * @category Portal
 * @package Controller
 * @author  Manoel Filho
 */
class IndexController extends ActionController
{
    
    public function indexAction()
    {
    	return new ViewModel();
    }
   
}