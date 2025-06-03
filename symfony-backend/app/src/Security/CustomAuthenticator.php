<?php
namespace App\Security;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
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
class CustomAuthenticator extends AbstractAuthenticator
{
    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function supports(Request $request): ?bool
    {
        // Debug: Verificar todas las cookies
        error_log('===== DEBUG AUTHENTICATOR =====');
        error_log('URL: ' . $request->getUri());
        error_log('Cookies disponibles: ' . json_encode($request->cookies->all()));
        error_log('Headers disponibles: ' . json_encode($request->headers->all()));
        // Verificar si existe token en cabecera o en cookie
        $hasHeaderToken = $request->headers->has('X-AUTH-TOKEN');
        $hasCookieToken = $request->cookies->has('X-AUTH-TOKEN'); // ¡CAMBIO AQUÍ!
        error_log('Tiene X-AUTH-TOKEN en header: ' . ($hasHeaderToken ? 'SÍ' : 'NO'));
        error_log('Tiene X-AUTH-TOKEN en cookie: ' . ($hasCookieToken ? 'SÍ' : 'NO'));
        if ($hasHeaderToken) {
            error_log('Valor X-AUTH-TOKEN header: ' . $request->headers->get('X-AUTH-TOKEN'));
        }
        if ($hasCookieToken) {
            error_log('Valor X-AUTH-TOKEN cookie: ' . $request->cookies->get('X-AUTH-TOKEN'));
        }
        error_log('================================');
        return $hasHeaderToken || $hasCookieToken;
    }
    public function authenticate(Request $request): Passport
    {
        // Obtener token de cabecera o cookie
        $apiToken = $request->headers->get('X-AUTH-TOKEN') ?? $request->cookies->get('X-AUTH-TOKEN'); // ¡CAMBIO AQUÍ!
        if (null === $apiToken) {
            throw new CustomUserMessageAuthenticationException('Se necesita token para autenticar.');
        }
        try {
            // Decodificar el token usando la clave secreta y el algoritmo
            $decoded = JWT::decode($apiToken, new Key($_ENV['JWT_SECRET'], 'HS512'));
            error_log('Token decodificado exitosamente. Usuario ID: ' . $decoded->aud);
            // Buscar el usuario con el ID del token (se guardó en el campo 'aud')
            $user = $this->em->getRepository(User::class)->findOneBy(['id' => $decoded->aud]);
            if (!$user) {
                error_log('Usuario no encontrado con ID: ' . $decoded->aud);
                throw new CustomUserMessageAuthenticationException('Usuario no encontrado.');
            }
            error_log('Usuario encontrado: ' . $user->getEmail());
            return new SelfValidatingPassport(new UserBadge($user->getEmail()));
        } catch (\Throwable $e) {
            error_log('Error en autenticación: ' . $e->getMessage());
            throw new CustomUserMessageAuthenticationException('Token inválido o expirado: ' . $e->getMessage());
        }
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        error_log('Autenticación exitosa para: ' . $token->getUserIdentifier());
        return null;
    }
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        error_log('Fallo de autenticación: ' . $exception->getMessage());
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        ];
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}