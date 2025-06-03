<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/tasks')]
class TaskController extends AbstractController
{
    #[Route('', name: 'list_tasks', methods: ['GET'])]
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $tasks = $em->getRepository(Task::class)->findAll();
        $data = array_map(fn($task) => [
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'completed' => $task->isCompleted(),
            'createdAt' => $task->getCreatedAt()->format('Y-m-d H:i:s')
        ], $tasks);
        return $this->json($data);
    }

    #[Route('', name: 'create_task', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $params = json_decode($request->getContent(), true);
        $task = new Task();
        $task->setTitle($params['title'] ?? 'Untitled');
        $task->setCompleted($params['completed'] ?? false);
        $em->persist($task);
        $em->flush();
        return $this->json([
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'completed' => $task->isCompleted(),
            'createdAt' => $task->getCreatedAt()->format('Y-m-d h:i:s')

        ]);
    }

    #[Route('/{id}', name: 'delete_task', methods: ['DELETE'])]
    public function delete($id, EntityManagerInterface $em): JsonResponse
    {
        $task = $em->getRepository(Task::class)->find($id);
        if (!$task) {
            return $this->json(['error' => 'Task not found'], 404);
        }
        $em->remove($task);
        $em->flush();
        return $this->json(['message' => 'Task deleted']);
    }

    #[Route('/{id}', name: 'update_task', methods: ['PUT'])]
    public function update($id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $task = $em->getRepository(Task::class)->find($id);
        if (!$task) {
            return $this->json(['error' => 'Task not found'], 404);
        }
        $params = json_decode($request->getContent(), true);
        if (isset($params['title'])) {
            $task->setTitle($params['title']);
        }
        if (isset($params['completed'])) {
            $task->setCompleted($params['completed']);
        }
        $em->flush();
        return $this->json([
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'completed' => $task->getCompleted()
        ]);
    }


    #[Route('', name: 'complete_all_tasks', methods: ['PUT'])]
    public function completeAllTasks(EntityManagerInterface $em): JsonResponse
    {
        // Buscamos todas las tareas
        $tasks = $em->getRepository(Task::class)->findAll();

        if (empty($tasks)) {
            return $this->json(['error' => 'Tasks not found'], 404);
        }

        // Marcamos las tareas como completadas
        foreach ($tasks as $task) {
            $task->setCompleted(true);  // Nota: usa booleano true, no string "true"
        }

        // Guardar los cambios en bbdd
        $em->flush();

        // Devolvemos respuesta
        $data = array_map(fn($task) => [
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'completed' => $task->getCompleted()
        ], $tasks);

        return $this->json($data);
    }

    #[Route('/ordered', name: 'list_ordered_task', methods: ['GET'])]
    public function listOrdered(Request $request, EntityManagerInterface $em): JsonResponse
    {
        // Obtenemos y validamos el parámetro
        $order = $request->query->get('order', 'ASC');
        $order = strtoupper($order);

        if (!in_array($order, ['ASC', 'DESC'])) {
            return $this->json(['error' => 'Invalid order parameter. Use ASC or DESC'], 400);
        }

        // Obtenemos tareas ordenadas
        $tasks = $em->getRepository(Task::class)->findAllOrdered($order);

        // Formateamos la respuesta
        $data = array_map(fn($task) => [
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'completed' => $task->isCompleted(),
            'createdAt' => $task->getCreatedAt()?->format('Y-m-d H:i:s')
        ], $tasks);

        return $this->json($data);
    }


    #[Route('/createdAt', name: 'list_createdAt_task', methods: ['GET'])]
    public function listCreatedAt(Request $request, EntityManagerInterface $em): JsonResponse
    {
        // Obtenemos y validamos el parámetro
        $order = $request->query->get('order', 'ASC');
        $order = strtoupper($order);

        if (!in_array($order, ['ASC', 'DESC'])) {
            return $this->json(['error' => 'Invalid order parameter. Use ASC or DESC'], 400);
        }

        // Obtenemos tareas ordenadas
        $tasks = $em->getRepository(Task::class)->createAtOrdered($order);

        // Formateamos la respuesta
        $data = array_map(fn($task) => [
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'completed' => $task->isCompleted(),
            'createdAt' => $task->getCreatedAt()?->format('Y-m-d H:i:s')
        ], $tasks);

        return $this->json($data);
    }
}
