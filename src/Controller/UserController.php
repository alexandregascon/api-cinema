<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\UserRoles;

#[Route("/api")]
class UserController extends AbstractController
{
//    #[Route('/user', name: 'app_user')]
//    public function index(): Response
//    {
//        return $this->render('user/index.html.twig', [
//            'controller_name' => 'UserController',
//        ]);
//    }

    #[Route('/user',"api_user_create",methods: ['POST'])]
    public function create(Request $requete, SerializerInterface $serializer, EntityManagerInterface $entityManager, UserRepository $userRepository) : Response {
        // Récupérer le body de la requête HTTP au format JSON
        $bodyRequete = $requete->getContent();
        // Désérialise le JSON en un objet de la classe User
        $user = $serializer->deserialize($bodyRequete,User::class,'json');
        $userByEmail = $userRepository->findOneBy(["email"=>$user->getEmail()]);
        // Vérification que le mail est unique

        $emailDejaUtilise = false;

        if($userByEmail != null){
            $emailDejaUtilise = true;
        }

        // Vérification que le mail est au bon format

        $valideEmail = false;

        if(filter_var($user->getEmail(),FILTER_VALIDATE_EMAIL)){
            $valideEmail = true;
        }

        // Vérification que le mot de passe est au bon format

        $alphabetMin = "azertyuiopqsdfghjklmwxcvbn";
        $alphabetMaj = "AZERTYUIOPQSDFGHJKLMWXCVBN";
        $caracteres = "²&é'(-è_çà)=*+,;:!?.§ù$^¨£µ%~#{[|`\@]}";
        $chiffres = "0123456789";

        $valideLettreMin = false;
        $valideLettreMaj = false;
        $valideCaractere = false;
        $valideChiffre = false;

        for($i = 0; $i <=25;$i++){
            if(strpos($user->getMdp(),substr($alphabetMin,$i,1))){
                $valideLettreMin = true;
                break;
            }
        }

        for($i = 0; $i <=25;$i++){
            if(strpos($user->getMdp(),substr($alphabetMaj,$i,1))){
                $valideLettreMaj = true;
                break;
            }
        }

        for($i = 0; $i <=9;$i++){
            if(strpos($user->getMdp(),substr($chiffres,$i,1))){
                $valideChiffre = true;
                break;
            }
        }

        for($i = 0; $i <=37;$i++){
            if(strpos($user->getMdp(),substr($caracteres,$i,1))){
                $valideCaractere = true;
                break;
            }
        }

        // Hacher le mot de passe

        $user->setMdp(password_hash($user->getMdp(),PASSWORD_DEFAULT));

        // Affecter le role Role_User

        $user->setRoles(UserRoles::ROLE_USER);

        if($emailDejaUtilise){
            $erreur = $serializer->serialize(["code"=>"400","message"=>"Email déjà utilisé"],'json');
            return new Response($erreur,Response::HTTP_BAD_REQUEST);
        }

        if(!$valideEmail){
            $erreur = $serializer->serialize(["code"=>"400","message"=>"Email non valide"],'json');
            return new Response($erreur,Response::HTTP_BAD_REQUEST);
        }

        if(!$valideLettreMin or !$valideCaractere or !$valideChiffre or !$valideLettreMaj) {
            $erreur = $serializer->serialize(["code"=>"400","message"=>"Complexité du mot de passe trop faible. 1 lettre minuscule, 1 lettre majuscule, 1 chiffre, et 1 caractère spéciale nécessaire au minimum"],'json');
            return new Response($erreur,Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($user);
        $entityManager->flush();
        // Générer la réponse
        $position = $serializer->serialize([$user,"code"=>201],'json',['groups'=>'create_user']);
        return new Response($position,Response::HTTP_CREATED,["content-type" => "application/json"]);
    }
}
