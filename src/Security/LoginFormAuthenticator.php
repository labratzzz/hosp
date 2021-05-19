<?php


namespace App\Security;


use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $serializer;
    private $router;
    private $passwordEncoder;

    public function __construct(SerializerInterface $serializer, RouterInterface $router, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->serializer = $serializer;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        return 'app_login' === $request->attributes->get('_route') && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password')
        ];
        if ($request->hasSession()) {
            $request->getSession()->set(
                Security::LAST_USERNAME,
                $credentials['username']
            );
        }

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $userProvider->loadUserByUsername($credentials['username']);

        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('User could not be found.');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $user = $token->getUser();
        $user = $this->serializer->serialize(self::getUserData($user), 'json', [AbstractNormalizer::GROUPS => ['Main']]);

        return new Response($user);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($request->getSession() instanceof SessionInterface) {
            $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        }

        if ($exception instanceof DisabledException) {
            return new JsonResponse(["error" => "Пользователь заблокирован."], Response::HTTP_FORBIDDEN);
        } else if($exception instanceof BadCredentialsException || $exception instanceof UsernameNotFoundException) {
            return new JsonResponse(["error" => "Неверный логин или пароль"], Response::HTTP_UNAUTHORIZED);
        }
        else {
            return new JsonResponse(["error" => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('app_login');
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [];
        if ($authException) {
            $data['error'] = $authException->getMessage();
            if ($token = $authException->getToken()) {
                $data['username'] = $token->getUsername();
            }
        }
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public static function getUserData(UserInterface $user)
    {
        if ($user instanceof User) {
            return $user;
        }

        $newUser = new User();
        $newUser->setName($user->getUsername());
        $newUser->setEmail($user->getUsername());

        return $newUser;
    }
}
