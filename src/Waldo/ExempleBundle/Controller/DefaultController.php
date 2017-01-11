<?php

namespace Waldo\ExempleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="welcome")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Security("has_role('ROLE_OIC_USER')")
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        return $this->forward('WaldoExempleBundle:Default:index');
    }

    /**
     * @Security("has_role('ROLE_OIC_USER')")
     * @Route("/private", name="_private_page")
     * @Template()
     */
    public function privateResouceAction()
    {
        ob_start();
        var_dump($this->get('security.context')->getToken());
        $tokenRaw = ob_get_clean();
        
        return array(
            'token' => $this->get('security.context')->getToken(),
            'tokenRaw' => $tokenRaw);
    }
    
    /**
     * @Security("has_role('ROLE_OIC_USER')")
     * @Route("/private/other", name="_private_other_page")
     * @Template()
     */
    public function otherPrivateResouceAction()
    {
        return array();
    }
}
