<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{


    /**
     * @Route("/api/regions", name="api_add_region",methods={"POST"})
     */
    public function addRegion(Request $request, ValidatorInterface $validator,SerializerInterface $serializer)
    {
    $region = $serializer->deserialize($request->getContent(), Region::class,'json');
    $errors = $validator->validate($region);
    if (count($errors) > 0) {
    $errorsString =$serializer->serialize($errors,"json");
    return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
    }
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($region);
    $entityManager->flush();
    return new JsonResponse("succes",Response::HTTP_CREATED,[],true);
    }
        
        /**
         * @Route("/user", name="user")
         */
        public function index()
        {
            return $this->render('user/index.html.twig', [
                'controller_name' => 'UserController',
            ]);
        }
    }
