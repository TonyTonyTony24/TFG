<?php

namespace App\Controller;

use App\Dto\ContactoDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface as MailerMailerInterface;

//eventos
use App\Message\Notification;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Message;

class ContactoController extends AbstractController
{
    #[Route('/contacto', methods: ['post'])]
    public function create(Request $request, #[MapRequestPayload] ContactoDto $dto, MailerMailerInterface $mailer, MessageBusInterface $bus): JsonResponse
    {
        $email = (new Email())
            ->from(new Address('test@test.com', 'curso fullstack'))
            ->to($dto->email)
            ->subject('Curso fullstack')
            ->html('
                <div style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
                <div style="max-width: 600px; margin: 0 auto; background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <h1 style="color: #2c3e50;">Hola ' . $dto->name . ' 👋</h1>
                <p style="font-size: 16px; color: #333;">Hemos recibido tu mensaje:</p>
                <blockquote style="background-color: #ecf0f1; padding: 15px; border-left: 4px solid #3498db; margin: 20px 0;">
                <p style="font-style: italic;">' . $dto->mensaje . '</p>
                </blockquote>
                <p style="font-size: 16px; color: #333;">📧 <strong>Email:</strong> ' . $dto->email . '</p>
                <p style="font-size: 16px; color: #333;">📞 <strong>Teléfono:</strong> ' . $dto->telefono . '</p>
                <hr style="margin: 30px 0;">
                <p style="font-size: 14px; color: #999;">Gracias por ponerte en contacto con nosotros.<br>Te responderemos lo antes posible.</p>
                <p style="font-size: 14px; color: #999;">— El equipo del Curso Fullstack 🚀</p>
                </div>
                </div>
            ');
        try {
            $bus->dispatch(new Notification($dto));
            $mailer->send($email);
            return $this->json([
                'estado' => 'OK',
                'mensaje' => 'El mensaje se ha enviado correctamente'
            ], Response::HTTP_OK);
        } catch (TransportExceptionInterface $th) {
            return $this->json([
                'estado' => 'error',
                'mensaje'=> 'Ups, ha ocurrido un error al enviar el mensaje'.$th
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
