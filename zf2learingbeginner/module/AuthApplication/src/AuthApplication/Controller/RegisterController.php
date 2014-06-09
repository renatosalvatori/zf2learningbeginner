<?php

namespace AuthApplication\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use AuthApplication\Form\User as RegisterForm;
use AuthApplication\Model\Entity\User;
use AuthApplication\Model\Users as TableUsers;

class RegisterController extends AbstractActionController{
	
	public function registerAction(){
		$registerFrm = new RegisterForm("register_user");
		
		if($this->getRequest()->isPost()) {
			
			$data = array_merge_recursive(
					$this->getRequest()->getPost()->toArray(),
					// Notice: make certain to merge the Files also to the post data
					$this->getRequest()->getFiles()->toArray()
			);
			
			$registerFrm->setData($data);
			if($registerFrm->isValid()){
				
				$uploadFile    = $this->params()->fromFiles('PICTURE');
				$adapter = new \Zend\File\Transfer\Adapter\Http();
				$adapter->setDestination(realpath(dirname(__FILE__).'/../../../../../data/uploads/'));
				if (is_array($uploadFile) && $adapter->receive($uploadFile['name'])){
					// msg success logica di upload file
				}
				
				$tableUser = new TableUsers();
				$user	   = new User();
				$user->exchangeArray($registerFrm->getData());
				$tableUser->registerUser($user);
				$this->redirect()->toRoute('auth-login');
			}
			
		}
		
		$viewModel = new ViewModel(
				array(
						'registerForm' => $registerFrm,
						'errorMessages' => $this->flashMessenger()->getErrorMessages(),
						'successMessages' => $this->flashMessenger()->getCurrentSuccessMessages(),
				)
		);
		
		return $viewModel;
	}
	
	public function editAction(){
		
		$id = (int) $this->params("id");
		$editprofileFrm = new RegisterForm("register_user");
		$editprofileFrm->remove('PASSWORD');
		$editprofileFrm->remove('PASSWORD_VERIFY');
		$editprofileFrm->remove('USERNAME');
		if($id > 0){
			$tableUser = new TableUsers();
			$user = $tableUser->getUserById($id)->current();
			if($user instanceof  \AuthApplication\Model\Entity\User){
				$editprofileFrm->bind($user);
				$editprofileFrm->setValidationGroup(array("LASTNAME","FIRSTNAME","EMAIL","PHONE","PICTURE"));
				
				if($this->getRequest()->isPost()) {
					$data = array_merge_recursive(
					$this->getRequest()->getPost()->toArray(),
					// Notice: make certain to merge the Files also to the post data
					$this->getRequest()->getFiles()->toArray()
					);
			
					$editprofileFrm->setData($data);
					if($editprofileFrm->isValid()){
					
						$uploadFile    = $this->params()->fromFiles('PICTURE');
						if(is_array($uploadFile)){
							$adapter = new \Zend\File\Transfer\Adapter\Http();
							$adapter->setDestination(realpath(dirname(__FILE__).'/../../../../../data/uploads/'));
							if (is_array($uploadFile) && $adapter->receive($uploadFile['name'])){
								// msg success logica di upload file
							}
						}
						
						var_dump($user);
						$tableUser->editUser($user,array('ID'=>$id));
						$this->flashMessenger()->addSuccessMessage('User Profile update!');
						$this->redirect()->toRoute('auth-application');
					}
				}
		
			}
		}
		
		$viewModel = new ViewModel(
				array(
						'editForm' 		=> $editprofileFrm,
						'idUser'	   		=> $id,
						'errorMessages' 	=> $this->flashMessenger()->getErrorMessages(),
						'successMessages' 	=> $this->flashMessenger()->getCurrentSuccessMessages(),
				)
		);
		
		return $viewModel;
	}
	
	
	public function changepasswordAction(){
		$id = (int) $this->params("id");
		$editprofileFrm = new RegisterForm("change_password");
		$editprofileFrm->remove('USERNAME');
		$editprofileFrm->remove('LASTNAME');
		$editprofileFrm->remove('FIRSTNAME');
		$editprofileFrm->remove('EMAIL');
		$editprofileFrm->remove('PHONE');
		$editprofileFrm->remove('PICTURE');
		
		if($id > 0){
			$tableUser = new TableUsers();
			$user = $tableUser->getUserById($id)->current();
			if($user instanceof  \AuthApplication\Model\Entity\User){
				$editprofileFrm->bind($user);
				$editprofileFrm->setValidationGroup(array("PASSWORD","PASSWORD_VERIFY"));
		
				if($this->getRequest()->isPost()) {
					$data = $this->getRequest()->getPost()->toArray();
					$editprofileFrm->setData($data);
					if($editprofileFrm->isValid()){
						$tableUser->updateUserPassword($user,array('ID'=>$id));
						$this->flashMessenger()->addSuccessMessage('User Password update!');
						$this->redirect()->toRoute('auth-application');
					}
				}
		
			}
		}
		
		$viewModel = new ViewModel(
				array(
						'editForm' 		=> $editprofileFrm,
						'idUser'	   		=> $id,
						'errorMessages' 	=> $this->flashMessenger()->getErrorMessages(),
						'successMessages' 	=> $this->flashMessenger()->getCurrentSuccessMessages(),
				)
		);
		
		return $viewModel;
		
	}
	
	
	public function loadImageAction(){
		$auth = $this->getServiceLocator()->get('AuthService');
		if ($auth->hasIdentity()) {
			$user = $auth->getIdentity();
			$image = $user->PICTURE;
		}else{
			$image ='avatar.jpeg';
		}
		
		$response = $this->getResponse();
		$imageContent =  file_get_contents('/usr/local/zend/var/apps/http/__default__/0/zf2learingbeginner/1.0.0/data/uploads/'.$image);
		$response->setContent($imageContent);
		$response
		->getHeaders()
		->addHeaderLine('Content-Transfer-Encoding', 'binary')
		->addHeaderLine('Content-Type', 'image/jpeg')
		->addHeaderLine('Content-Length', mb_strlen($imageContent));
		
		return $response;
	}
}

?>