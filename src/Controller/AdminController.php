<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Entity\User;
use App\Repository\QuoteRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(QuoteRepository $quoteRepository): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/managequotes', name: 'app_admin_managequotes')]
    public function manageQuotes(QuoteRepository $quoteRepository): Response
    {
        return $this->render('admin/quotes.html.twig',[
            'quotes'=>$quoteRepository->findAll()
        ]);
    }
    #[Route('/destroy/{id}')]
    public function destroyQuote(Quote $quote, EntityManagerInterface $manager): Response
    {
        if (!$quote){
            return $this->redirectToRoute('app_admin');
        }
        $manager->remove($quote);
        $manager->flush();
        return $this->redirectToRoute('app_admin_managequotes');
    }
    #[Route('/manageusers', name: 'app_admin_manageusers')]
    public function manageUsers(UserRepository $userRepository): Response
    {
        return $this->render('admin/users.html.twig', [
            'users'=>$userRepository->findAll()
        ]);
    }

    #[Route('/promote/{id}', name: 'app_user_promote', priority: 2)]
    #[Route('/demote/{id}', name: 'app_user_demote', priority: 2)]
    public function promoteDemote(Request $request, User $user, UserRepository $userRepository): Response
    {

        $promote = true;
        if($request->get('_route') === 'app_user_demote')
        {$promote = false ;}

        if($promote){
            $user->setRoles(["ROLE_ADMIN"]);
        }else{
            $user->setRoles([]);
        }

        $userRepository->save($user,true);

        return $this->redirectToRoute('app_admin_manageusers');
    }
}
