<?php
namespace App\Service;

use App\Repository\ArticleRepository;
use App\Repository\ContactRepository;
use App\Repository\OrderRepository;
use App\Repository\SalesOrderLineRepository;

class CsvFileManipulation{
    private OrderRepository $orderRepo;
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo=$orderRepo;
    }
    public function fetchOrders(){
        $fileName="orders.csv";
        header("Content-type:   text/csv");
        header("Content-Disposition:    attachment; filename=$fileName");
        $output=fopen("php://output","w");
        $head=explode(";","order;delivery_name;delivery_country;delivery_zipcode;delivery_city;item_index;item_id;item_quantity;line_price_exl_vat;line_price_incl_val");
       //dd($head);
        $row=explode(";"," ; ; ; ; ; ; ; ; ; ");
        $orders=$this->orderRepo->findAll();
        fputcsv($output,$head);
        foreach($orders as $order){
            $row[0]=$order->getId();
            $contact=$order->getDeliverTo();
            $row[1]=$contact->getAccountName();
            $row[2]=$contact->getCountry();
            $row[3]=$contact->getZipCode();
            $row[4]=$contact->getCity();
            $salesOrderLines=$order->getSalesOrderLines();
            $i=1;
            foreach($salesOrderLines as $line)
            {
                $article=$line->getArticle();
                $row[5]="$i";
                $row[6]=$article->getId();
                $row[7]=$line->getQuantity();
                $row[8]=$line->getAmount();
                $row[9]=$line->getAmount()*($article->getVatPercentage()+1);
                fputcsv($output,$row);
                $i++;
            }
            fputcsv($output,$row);
        }
        
        fclose($output);
    }
}
?>