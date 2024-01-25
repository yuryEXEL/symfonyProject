<?php
declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Entity\User;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/v1/user')]
class UserController extends AbstractController
{
    private const DEFAULT_PER_PAGE = 20;

    public function __construct(private readonly UserManager $userManager)
    {
    }

    #[Route(path: '', methods: ['POST'])]
    public function saveUserAction(Request $request): Response
    {
        $login = $request->query->get('login');
        $password = $request->query->get('password');
        $email = $request->query->get('email');
        $userId = $this->userManager->create($login, $password, $email);
        [$data, $code] = $userId === null ?
            [['success' => false], Response::HTTP_BAD_REQUEST] :
            [['success' => true, 'userId' => $userId], Response::HTTP_OK];

        return new JsonResponse($data, $code);
    }

    #[Route(path: '', methods: ['GET'])]
    public function getUsersAction(Request $request): Response
    {
        $perPage = $request->query->getInt('perPage');
        $page = $request->query->getInt('page');
        $users = $this->userManager->getUsers($page, $perPage === 0 ? self::DEFAULT_PER_PAGE : $perPage);
        $code = empty($users) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return new JsonResponse(['users' => array_map(static fn(User $user) => $user->toArray(), $users)], $code);
    }

    #[Route(path: '', methods: ['DELETE'])]
    public function deleteUserAction(Request $request): Response
    {
        $userId = $request->query->getInt('userId');
        $result = $this->userManager->deleteUser($userId);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }
}
