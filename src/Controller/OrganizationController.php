<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Organization;
use App\Entity\Survey;
use App\Entity\Tag;
use App\Form\ImportOrganizationsType;
use App\Form\OrganizationType;
use App\Repository\OrganizationRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrganizationController extends AbstractController {

    /**
     * @Route("/organizations/list", name="organizations_list")
     */
    public function showOrganizations(){
        $organizations = $this->getDoctrine()->getRepository(Organization::class)->findAll();
        return $this->render("organization/list.html.twig", [
            'organizations' => $organizations
        ]);
    }

    /**
     * @Route("/organizations/add", name="organizations_add")
     */
    public function addOrganization(Request $request){
        $form = $this->createForm(OrganizationType::class, new Organization())
        ->add("submit", SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $organization = $form->getData();
            $tags = $form->get('tags')->getData();
            foreach ($tags as $tag){
                $entityManager->persist($tag);
            }
            $entityManager->persist($organization);
            $entityManager->flush();
            return $this->redirectToRoute("organizations_list");
        }

        return $this->render("organization/form.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/organizations/edit/{id}", name="organizations_edit", requirements={"id":"\d+"})
     */
    public function editOrganization(Organization $organization, Request $request){
        if ($organization){
            $form = $this->createForm(OrganizationType::class, $organization);
            $form->add('submit', SubmitType::class);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $organization = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($organization);
                $entityManager->flush();
                return $this->redirectToRoute("organizations_list", ['_fragment'=>$organization->getId()]);
            }

            return $this->render("organization/form.html.twig", [
                "form" => $form->createView(),
                "organization" => $organization,
                "contacts"=>$organization->getContacts()
            ]);
        }
    }

    /**
     * @Route("/organizations/delete/{id}", name="organizations_delete", requirements={"id":"\d+"})
     */
    public function deleteOrganization(Session $session, Organization $organization){
        if ($organization){
            $session->getFlashBag()->add('message', "Deleted organization '{$organization->getName()}' and all related surveys");
            $entityManager = $this->getDoctrine()->getManager();
            foreach($organization->getSurveys() as $survey){
                $entityManager->remove($survey);
            }
            $entityManager->remove($organization);
            $entityManager->flush();
        }
        return $this->redirectToRoute("organizations_list");
    }

    /**
     * @Route("/organizations/{id}/surveys", name="organization_surveys", requirements={"id"="\d+"})
     * @
     */
    public function showOrganizationSurveys(int $id){
        $organization = $this->getDoctrine()->getRepository(Organization::class)->find($id);
        $organizationSurveys = $this->getDoctrine()->getRepository(Survey::class)->findBy([
            'organization' => $organization,
        ]);

        return $this->render("organization/surveys.html.twig", [
            "organization" => $organization,
            "surveys" => $organizationSurveys,
        ]);
    }

    /**
     * @Route("/organizations/{id}/content", name="organization_content", requirements={"id"="\d+"})
     * @
     */
    public function contentList(int $id){
        $organization = $this->getDoctrine()->getRepository(Organization::class)->find($id);

        return $this->render("organization/content.html.twig", [
            "organization" => $organization,
            "content" => $organization->getPostedContents()
        ]);
    }

    /**
     * @Route("/organizations/{id}/contacts", name="organization_contacts", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function contactList(int $id){
        /**
         * @var Organization
         */
        $organization = $this->getDoctrine()->getRepository(Organization::class)->find($id);
        return $this->render("organization/contacts.html.twig", [
            "organization" => $organization,
            "contacts" => $organization->getContacts()
        ]);
    }

    /**
     * @Route("/organizations/{id}/contacts", name="ogranization_create_contact", requirements={"id"="\d+"}, methods={"POST"})
     */
    public function createContact(int $id, Request $request){
        /**
         * @var Organization
         */
        $organization = $this->getDoctrine()->getRepository(Organization::class)->find($id);

        $contact = new Contact();
        $contact->setName($request->get('name'));
        $contact->setEmail($request->get('email'));
        $contact->setPhone($request->get('phone'));
        $contact->setMobile($request->get('mobile'));
        $contact->setType($request->get('type', Contact::TYPE_UNKNOWN));
        $organization->addContact($contact);
        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->persist($organization);
        $em->flush();

        return $this->redirectToRoute('organizations_edit', ['id'=>$organization->getId()]);
    }

    /**
     * @Route("/contacts/{uuid}", name="view_contact", methods={"GET"})
     */
    public function viewContact(string $uuid){
        /**
         * @var Contact|null
         */
        $contact = $this->getDoctrine()->getRepository(Contact::class)->findOneBy([
            'uuid'=>$uuid
        ]);

        if(!$contact) return new NotFoundHttpException();

        return $this->render('contact/view.html.twig', [
            'contact'=>$contact,
            'organization'=>$contact->getOrganization()
        ]);
    }

    /**
     * @Route("/contacts/{uuid}", name="update_contact", methods={"POST"})
     */
    public function updateContact(string $uuid, Request $request){
        /**
         * @var Contact|null
         */
        $contact = $this->getDoctrine()->getRepository(Contact::class)->findOneBy([
            'uuid'=>$uuid
        ]);

        if(!$contact) return new NotFoundHttpException();

        $em = $this->getDoctrine()->getManager();
        $params = $request->request->all();
        if(array_key_exists('type', $params)) $contact->setType($params['type']);
        if(array_key_exists('name', $params)) $contact->setName($params['name']);
        if(array_key_exists('email', $params)) $contact->setEmail($params['email']);
        if(array_key_exists('phone', $params)) $contact->setPhone($params['phone']);
        if(array_key_exists('mobile', $params)) $contact->setMobile($params['mobile']);
        $em->persist($contact);
        $em->flush();

        return $this->redirectToRoute('organizations_edit', ['id'=>$contact->getOrganization()->getId()]);
    }

    /**
     * @Route("organizations/import", name="organizations_import")
     */
    public function import(Request $request, OrganizationRepository $org_repository, TagRepository $tag_repository){
        $form = $this->createForm(ImportOrganizationsType::class);
        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            /**
             * @var UploadedFile
             */
            $file = $form->get('file')->getData();
            if($file){
                if('csv'==strtolower($file->getClientOriginalExtension())){
                    $fh = fopen($file->getRealPath(), 'r');
                    $keys = fgetcsv($fh);
                    $data = [];
                    while($d = fgetcsv($fh)){
                        $row = [];
                        foreach($keys as $k=>$title){
                            $value = $d[$k];
                            $row[$title] = (empty($value) || "NULL"===$value) ? null : $value;
                        }
                        $data[] = $row;
                    }
                    fclose($fh);
                    if(!empty($data)){
                        $tag_code_map = [
                            'CP'=>'Concrete Polishing',
                            'RA'=>'Reciprocal Association',
                            'FS'=>'Slab Sawing',
                            'SS'=>'Slab Sawing',
                            'WL'=>'Wall Sawing',
                            'WR'=>'Wire Sawing',
                            'HS'=>'Hand Sawing',
                            'CD'=>'Core Drilling',
                            'GG'=>'Grooving/Grinding',
                            'SD'=>'Selective Demolition',
                            'GPR'=>'GPR Imaging',
                            'NDT'=>'Non-destructive Testing',
                            'SP'=>'Surface Prep',
                            'SR'=>'Slurry Recycling',
                            'SC'=>'Slurry Collection',
                            'CR'=>'Concrete Recycling',
                            'CC'=>'Curb Cutting'
                        ];
                        $category_map = [
                            'A'=>'Affiliate',
                            'C'=>'Contactor (US)',
                            'CC'=>'Contractor (CA)',
                            'OC'=>'Contractor (Overseas)',
                            'M'=>'Manufacturer',
                            'D'=>'Distributor',
                            'G'=>'GPR Imaging',
                            'FP'=>'Field Personnel',
                            'OP'=>'Operator',
                            'RA'=>'Reciprocal Association'
                        ];
                        $entityManager = $this->getDoctrine()->getManager();
                        foreach($data as $_r){
                            if(isset($_r['custom_id'])){
                                //find org by custom_id
                                $organization = $org_repository->findOneBy(['custom_id'=>$_r['custom_id']]);
                                if(null==$organization) $organization = new Organization();
                                if(isset($_r['custom_id']) && ''==$organization->getCustomId()) $organization->setCustomId($_r['custom_id']);
                                if(isset($_r['name']) && ''==$organization->getName()) $organization->setName($_r['name']);
                                if(isset($_r['postal_code']) && ''==$organization->getPostalCode()) $organization->setPostalCode($_r['postal_code']);
                                if(isset($_r['contact_email']) && ''==$organization->getContactEmail()) $organization->setContactEmail($_r['contact_email']);
                                if(''==$organization->getContactPerson() && (isset($_r['contact_firstname']) || isset($_r['contact_lastname']))){
                                    $organization->setContactPerson((isset($_r['contact_firstname']) ? "{$_r['contact_firstname']} " : '') . (isset($_r['contact_lastname']) ? $_r['contact_lastname'] : ''));
                                }
                                if(isset($_r['directory_url']) && ''==$organization->getDirectoryUrl()) $organization->setDirectoryUrl($_r['directory_url']);
                                if(isset($_r['street_address1']) && ''==$organization->getStreetAddress1()) $organization->setStreetAddress1($_r['street_address1']);
                                if(isset($_r['street_address2']) && ''==$organization->getStreetAddress2()) $organization->setStreetAddress2($_r['street_address2']);
                                if(isset($_r['city']) && ''==$organization->getCity()) $organization->setCity($_r['city']);
                                if(isset($_r['state']) && ''==$organization->getState()) $organization->setState($_r['state']);
                                if(isset($_r['country']) && ''==$organization->getCountry()) $organization->setCountry($_r['country']);
                                if(isset($_r['contact_phone_number']) && ''==$organization->getContactPhoneNumber()) $organization->setContactPhoneNumber($_r['contact_phone_number']);
                                if(isset($_r['contact_fax']) && ''==$organization->getContactFax()) $organization->setContactFax($_r['contact_fax']);
                                if(isset($_r['contact_other_number']) && ''==$organization->getContactOtherNumber()) $organization->setContactOtherNumber($_r['contact_other_number']);
                                $tag_codes = [];
                                if(isset($_r['category']) && ''==$organization->getMembershipCategory()){
                                    $category = $category_map[strtoupper(rtrim($_r['category'], " \t\n\r\0\x0B2"))] ?? rtrim($_r['category'], " \t\n\r\0\x0B2");
                                    $organization->setMembershipCategory($category);
                                }
                                if(isset($_r['services'])){
                                    $service_codes = explode(',', $_r['services']);
                                    if(!empty($service_codes)){
                                        foreach($service_codes as $_c){
                                            $_c = trim($_c, " \t\n\r\0\x0B2");
                                            $tag_codes[] = $_c;
                                        }
                                    }
                                }
                                if(!empty($tag_codes)){
                                    foreach($tag_codes as $_c){
                                        if(''!=trim($_c)){
                                            $tag_name = $tag_code_map[strtoupper($_c)] ?? $_c;
                                            $tag = $tag_repository->findOneBy(['name'=>$tag_name]);
                                            if(null==$tag){
                                                $tag = new Tag();
                                                $tag->setName($tag_name);
                                                $entityManager->persist($tag);
                                                $entityManager->flush();
                                            }
                                            $organization->addTag($tag);
                                            if('WS'==strtoupper($_c)){
                                                $wire_sawing = $tag_repository->findOneBy(['name'=>'Wire Sawing']);
                                                $wall_sawing = $tag_repository->findOneBy(['name'=>'Wall Sawing']);
                                                if($wire_sawing) $organization->addTag($wire_sawing);
                                                if($wall_sawing) $organization->addTag($wall_sawing);
                                            }
                                        }
                                    }
                                }
                                $entityManager->persist($organization);
                            }
                        }
                        $entityManager->flush();
                    }
                    $submitted = $data;
                }
            }
        }

        return $this->render('organization/import.html.twig', [
            'form'=>$form->createView(),
            'submitted'=>$submitted ?? false
        ]);
    }
}