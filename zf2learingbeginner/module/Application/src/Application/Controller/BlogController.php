<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BlogController  extends AbstractActionController {
	
	const PAGE_GRID = 5;
	protected $sessionContainer;
	
	public function indexAction()
	{
		throw new \Exception('Action not available');

	}
	
	
	public function listviewAction()
	{
		
		$request = $this->getRequest();
		if ($this->params()->fromRoute('page'))
			$page = $this->params()->fromRoute('page');
		else
			$page = 1;
		
		$sm = $this->getServiceLocator();
		
		
		// session service
		$this->sessionContainer = $sm->get('sessionmanager');
		
		// table service
		$tableService 	= $sm->get('table-gateway');
		$tableproduct 	= $tableService->get('product');
		$tablecategory 	= $tableService->get('category');
		$blog 			= $tableService->get('blog');
		
		$formSearch = new \Application\Form\PostFormSearch();
		$formSearch->prepareElements($tablecategory->fetchPairs(), $tableproduct->fetchPairs());
		$request = $this->getRequest();
		if ($request->isPost()) {
			$row_data=$request->getPost()->toArray();
			$array_exclude=array('Filtra','Assegna');
			$filters=array_filter($row_data,function($v) use ($array_exclude) {
				if( ! in_array($v, $array_exclude)) return true;
			});
			$formSearch->setData($request->getPost());
			$this->sessionContainer->filtriRicerca= $filters;
		}
		else
			$filters = $this->sessionContainer->filtriRicerca;
		
		$paginator = $blog->getContentBlog($filters);
		//$paginator = $blog->getContentBlogArrayAdapter($filters);
		$paginator->setCurrentPageNumber($page)->setItemCountPerPage(self::PAGE_GRID);
		
		$searchModel = new ViewModel(array(
				'formSearch' => $formSearch,
				'filtri'=>$this->sessionContainer->filtriRicerca,	
		));
		$searchModel->setTemplate("application/blog/formsearch.phtml");
		
		$grigliaModel= new ViewModel(array(
				'grigliaPaginator'=> $paginator,
				
				'successMessages' => $this->flashMessenger()->getCurrentSuccessMessages(),
				'errorMessages' => $this->flashMessenger()->getErrorMessages()
		));
		$this->getEventManager()->trigger('test');
		$grigliaModel->addChild($searchModel,'search');
			
		return $grigliaModel;
	}
	
	public function manageAction()
	{
		//throw new \Exception('Action not available');
		$sm = $this->getServiceLocator();
		$tableService 	= $sm->get('table-gateway');
		$tableproduct 	= $tableService->get('product');
		$tablecategory 	= $tableService->get('category');
		$blog 			= $tableService->get('blog');
		
		$id = (int) $this->params("id");
		
		$blogForm = new \Application\Form\PostForm($tablecategory->fetchPairs(), $tableproduct->fetchPairs());
		$blogFormFilter =  new \Application\Form\PostFormFilter();
		
		if($id > 0){
			$blogRec = $blog->getContentBlogById($id)->current();
			var_dump($blogRec);
			$blogForm->bind($blogRec);
		}
		
		if($this->getRequest()->isPost()) {
			$blogForm->setInputFilter($blogFormFilter->prepareFilters());
			$blogForm->setData($this->getRequest()->getPost());
			if($blogForm->isValid()){
				// save blog and send email
				$data = $blogForm->getData();
				if($id)
					$blog->updatePost($data->getArrayCopy(), array('ID'=>$id));
				else 
					$blog->insertPost($data);
				
				$this->getEventManager()->trigger('post_update_insert',null,array('id'=>$id));
				$this->flashMessenger()->addSuccessMessage('Insert - Update Post');
				$this->redirect()->toRoute('blog');
			}
			
		}
		
		$manageModel = new ViewModel(array(
						'blogForm'=>$blogForm,
						"id"=>$id
						));
		return $manageModel;
	}
	
	public function deleteAction()
	{
		//throw new \Exception('Action not available');
		$sm   = $this->getServiceLocator();
		$tableService 	= $sm->get('table-gateway');
		$blog = $tableService->get('blog');
		
		$id = (int) $this->params("id");
		if($id > 0){
			$blog->delete(array('ID'=>$id));
			$this->getEventManager()->trigger('post_delete',null,array('id'=>$id));
			$this->flashMessenger()->addSuccessMessage('Delete Post');
			$this->redirect()->toRoute('blog');
		}
		
	}
	
}

?>