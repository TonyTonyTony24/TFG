<?php
namespace App\Security;

use App\Entity\User;
use App\Entity\Usuarios;
use App\Repository\UsuariosRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport; 
use Firebase\JWT\JWT; 
use Firebase\JWT\Key;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomAuthenticator extends AbstractAuthenticator
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em; 
    }
    public function supports(Request $request): ?bool
    {
        return $request->headers->has('X-AUTH-TOKEN');
    }

    public function authenticate(Request $request): Passport
    {
        $apiToken = $request->headers->get('X-AUTH-TOKEN');
        if(null===$apiToken)
        {
            throw new CustomUserMessageAuthenticationException('Se necesita token de autenticar');
        }
        try {
            $decode = JWT::decode($apiToken, new Key($_ENV['JWT_SECRET'], 'HS512'));
            $user = $this->em->getRepository(User::class)->findOneBy(['id' => $decode->aud]);
            if(!$user)
            {
                return new Passport(new UserBadge(''), new PasswordCredentials(''));
            }else
            {
                return new SelfValidatingPassport(new UserBadge($user->getEmail()) );
            }
        } catch (\Throwable $th) {
             return new Passport(new UserBadge(''), new PasswordCredentials(''));
        }

    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}