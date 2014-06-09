<?php
namespace AuthApplication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use AuthApplication\Form\LoginForm as Login;
use AuthApplication\Form\LoginFilter as LoginFilter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Storage\Session as AuthStorage;

/**
 * LoginController
 *
 * @author
 *
 * @version
 *
 */
class LoginController extends AbstractActionController
{
    const DEFAULT_ROLE='guest';
    
    protected $authService;
    /**
	 * @return the $authService
	 */
	public function getAuthService() {
	    return $this->getServiceLocator()->get('AuthService');
	    //return $this->authService;
	}

	/**
	 * @param field_type $authService
	 */
	public function setAuthService(Zend\Authentication\AuthenticationService  $authService) {
		$this->authService = $authService;
	}

	/**
     * The default action - show the home page
     */
    public function indexAction()
    {
        // TODO Auto-generated LoginController::indexAction() default action
        return new ViewModel();
    }
    
    /**
     * login action
     */
    public function loginAction()
    {
        $auth = $this->getServiceLocator()->get('AuthService');
        if ($auth->hasIdentity()) {
        	return $this->redirect()->toRoute('auth-application');
        }
        
        $form = new Login();
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $formValidator = new LoginFilter();
            $form->setInputFilter($formValidator->prepareFilters()); // setting input filter
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                // start authentication
                $formData = $form->getData();  // get Data from Post
                
                $auth        = $this->getAuthService();
                $authAdapter = $auth->getAdapter();
                
                $authAdapter->setIdentity($formData['USERNAME']);
                $authAdapter->setCredential($formData['PASSWORD']);
                    
                // Perform the authentication query, saving the result
                $result = $auth->authenticate($authAdapter);
                if ($result->isValid()) {
                    $userRow = $authAdapter->getResultRowObject();
                    if(!isset($userRow->ROLE))
                    	$userRow->ROLE=self::DEFAULT_ROLE;
                    $authStorage = $auth->getStorage();
                    $authStorage->write($userRow);
                    $this->flashMessenger()->addSuccessMessage('You are logged!');
                    return $this->redirect()->toRoute('auth-application');
                }
                else{
                    $this->flashMessenger()->addErrorMessage('Login failed');
                }
                
            }
        }
        
        
        $viewModel = new ViewModel(
        		array(
        				'loginform' => $form,
        				'errorMessages' => $this->flashMessenger()->getErrorMessages(),
        				'successMessages' => $this->flashMessenger()->getCurrentSuccessMessages(),
        		)
        );
        
        return $viewModel;
    }
    
 
    
    /**
     * logout action
     */
    public function LogoutAction()
    {
        $auth = $this->getServiceLocator()->get('AuthService');
        $auth->clearIdentity();
 
        $this->flashmessenger()->addSuccessMessage("You've been logged out");
        return $this->redirect()->toRoute('auth-login');
    }
    
}