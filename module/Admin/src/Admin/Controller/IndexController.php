<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect as PaginatorDBSelectAdapter;

/**
 * Controlador que gerencia a página inicial
 * 
 * @category Admin
 * @package Controller
 * @author  Manoel Filho
 */
class IndexController extends ActionController
{
    
    public function indexAction()
    {  

		$qb = $this->getEntityManager ()->createQueryBuilder ();
		$qb->select(['SUM(m.valor) as soma', 'ct.id', 'ct.categoria', 'co.conta'])
		   ->from('Admin\Model\Movimentacao', 'm')
		   ->innerJoin('m.conta', 'co')
		   ->innerJoin('m.categoria', 'ct')
		   ->groupBy('ct.id', 'co.id');

		$qb->orderBy('co.conta', 'DESC');
		
		$query = $qb->getQuery ();
		$soma_categorias = $query->getArrayResult ();

		$qb2 = $this->getEntityManager ()->createQueryBuilder ();
		$qb2->select(['co.conta', 'co.banco'])
		   ->from('Admin\Model\Movimentacao', 'm')
		   ->innerJoin('m.conta', 'co')
		   ->groupBy('co.id');

		$qb2->orderBy('co.conta', 'DESC');
		
		$query2 = $qb2->getQuery ();
		$contas = $query2->getArrayResult ();

		$array = array();

		foreach( $contas as $conta ):
			$conta['somas'] = array();
			foreach( $soma_categorias as $soma_categoria):
				if( $soma_categoria['conta'] == $conta['conta'] ){  
					if( !in_array( $soma_categoria, $conta ) ) { 
						array_push( $conta, $soma_categoria );
						array_push( $conta['somas'], $soma_categoria ); 
					}
				}
			endforeach;	
			array_push($array, $conta);
		endforeach;	

    	return new ViewModel(
    		array(
    			'contas' => $array
    		)
    	);
    }
   
}