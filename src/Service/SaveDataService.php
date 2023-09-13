<?php
namespace App\Service;

use App\Entity\Contact;
use App\Repository\ArticleRepository;
use App\Repository\ContactRepository;
use App\Repository\OrderRepository;
use App\Repository\SalesOrderLineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class SaveDataService
{
    private $articelRepo;
    private $contactRepo;
    private $orderRepo;
    private $salesOrderLineRepo;
    private $entityManager;
    public function __construct(ArticleRepository $articelRepo,ContactRepository $contactRepo,OrderRepository $orderRepo,SalesOrderLineRepository $salesOrderLineRepo,EntityManagerInterface $entityManager)
    {
        $this->articelRepo=$articelRepo;
        $this->contactRepo=$contactRepo;
        $this->orderRepo=$orderRepo;
        $this->salesOrderLineRepo=$salesOrderLineRepo;
        $this->entityManager=$entityManager;    
    }
    public function saveContacts($contacts)
    {
        try{
            $content=$contacts["results"];
        $i=0;
        $saved=false;
        while($i<count($content)){
            $id=$content[$i]["ID"];
            $contact=$this->contactRepo->findById($id);
            if($contact==null){
                $newContact=new Contact();
                $newContact->setId($id);
                $newContact->setAccountName($content[$i]["AccountName"]);
                $newContact->setAddressLine1($content[$i]["AddressLine1"]);
                $newContact->setAddressLine2($content[$i]["AddressLine2"]);
                $newContact->setCity($content[$i]["City"]);
                $newContact->setContactName($content[$i]["ContactName"]);
                $newContact->setCountry($content[$i]["Country"]);
                $newContact->setZipCode($content[$i]["ZipCode"]);
                $this->entityManager->persist($newContact);
                $saved=true;
            }
            $i++;
        }
        if($saved){
            $this->entityManager->flush();
        }
        return true;
        }
        catch(Exception $e){
            dd($e);
            return false;
        }
    }
    public function saveOrders($orders)
    {
        
    }
}
?>