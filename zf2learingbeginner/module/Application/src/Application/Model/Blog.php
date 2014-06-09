<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Adapter\Iterator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression as Espressione;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\TableGateway\Feature\EventFeature;
use Zend\Db\TableGateway\Feature\FeatureSet;

class Blog extends TableGateway{
	
	public function __construct()
	{
		$this->table = 'BLOG';
		$this->featureSet = new FeatureSet();
		$this->featureSet->addFeature(new GlobalAdapterFeature());
		$this->featureSet->addFeature(new EventFeature());
		$this->initialize();
	}
	
	protected function getFilters(\Zend\Db\Sql\Where $where,$_filters){
		if(is_array($_filters)){
			foreach($_filters as $key =>$filtro){
				switch ($key){
					case 'PRODUCT_ID':
						if((int)  $filtro > 0)
						$where->equalTo('PRODUCT_ID', $filtro);
						break;
					case 'CATEGORY_ID':
						if((int)  $filtro > 0)
						$where->equalTo('CATEGORY_ID', $filtro);
						break;
				}
			}
		}
		
		return $where;
	}
	
	public function getContentBlog($_filters){
		$sql= new \Zend\Db\Sql\Sql($this->getAdapter());
		$select = $sql->select();
		$select->from($this->table);
		$select->join('CATEGORY','BLOG.CATEGORY_ID=CATEGORY.ID',array('CAT_DESCRIPTION'),'left')
		->join('PRODUCT','BLOG.PRODUCT_ID=PRODUCT.ID',array('PROD_DESCRIPTION'),'left');
		$where = new Where();
		$whereCondition= $this->getFilters($where,$_filters);
		
		$select->where($whereCondition); //->order('');
		
		//return $this->selectWith($select);
		
		
		//echo "--->".$sql->getSqlStringForSqlObject($select);
		$resultSet = new ResultSet();
		$paginatorAdapter = new DbSelect(
				// our configured select object
				$select,
				// the adapter to run it against
				$this->getAdapter(),
				// the result set to hydrate
				$resultSet
		);
		$paginator = new Paginator($paginatorAdapter);
		return $paginator;
		
	}
	
	
	public function getContentBlogIterator($_filters){
		$sql= new \Zend\Db\Sql\Sql($this->getAdapter());
		$select = $sql->select();
		$select->from($this->table);
		$select->join('CATEGORY','BLOG.CATEGORY_ID=CATEGORY.ID',array('CAT_DESCRIPTION'),'left')
		->join('PRODUCT','BLOG.PRODUCT_ID=PRODUCT.ID',array('PROD_DESCRIPTION'),'left');
		$where = new Where();
		$whereCondition= $this->getFilters($where,$_filters);
	
		$select->where($whereCondition); //->order('');
		//echo "--->".$sql->getSqlStringForSqlObject($select);
		//$resultSet = new ResultSet();
		/*$paginatorAdapter = new DbSelect(
				// our configured select object
				$select,
				// the adapter to run it against
				$this->getAdapter(),
				// the result set to hydrate
				$resultSet
		);*/
	
		$paginatorAdapter = new Iterator($this->selectWith($select)->buffer());
		$paginator = new Paginator($paginatorAdapter);
	
		return $paginator;
	
	}
	
	
	public function getContentBlogArrayAdapter($_filters){
		$sql= new \Zend\Db\Sql\Sql($this->getAdapter());
		$select = $sql->select();
		$select->from($this->table);
		$select->join('CATEGORY','BLOG.CATEGORY_ID=CATEGORY.ID',array('CAT_DESCRIPTION'),'left')
		->join('PRODUCT','BLOG.PRODUCT_ID=PRODUCT.ID',array('PROD_DESCRIPTION'),'left');
		$where = new Where();
		$whereCondition= $this->getFilters($where,$_filters);
	
		$select->where($whereCondition); //->order('');
		//echo "--->".$sql->getSqlStringForSqlObject($select);
		//$resultSet = new ResultSet();
		/*$paginatorAdapter = new DbSelect(
		// our configured select object
		$select,
		// the adapter to run it against
		$this->getAdapter(),
		// the result set to hydrate
		$resultSet
		);*/
	
		$paginatorAdapter = new ArrayAdapter($this->selectWith($select)->toArray());
		$paginator = new Paginator($paginatorAdapter);
	
		return $paginator;
	
		}
	
	
	public function getContentBlogById($_id){
		$sql= new \Zend\Db\Sql\Sql($this->getAdapter());
		$select = $sql->select();
		$select->from($this->table);
		$select->where->equalTo("ID", $_id);
		return $this->selectWith($select);
	}
	
	
	public function insertPost($data){
		unset($data['submit']);
		parent::insert($data);
	}
	
	public function updatePost($data, $where){
		unset($data['submit']);
		parent::update($data, $where);
	}
	
	public function deletePost($where){
		parent::delete($where);
	}
}

?>