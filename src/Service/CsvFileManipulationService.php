<?php

/**
 * Ce fichier fait partie du projet mon-test-technique
 *
 * Dans le cas où le fichier est complexe ou important, ne pas hésiter à donner des détails ici…
 *
 * @package Service
 * @copyright 2023 Quantic Factory
 */

namespace App\Service;

use App\Repository\OrderRepository;

/**
 * Cette classe  permet de sauvegarder les données récupérées depuis la base de données dans un fichier csv
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class CsvFileManipulationService
{

    private OrderRepository $orderRepo;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    /**
     * Elle Sauvegarde les commandes récupéré de la base de données dans un fichier csv
     *
     * @param string $fileName
     *
     * @return void
     *
     */

    public function fetchOrders(string $fileName)
    {
        //On récupère la liste des commandes
        $orders = $this->orderRepo->findAll();
        //dd($orders);
        //On créer un buffer
        ob_start();
        //On déclare qu'on va générer un fichier csv
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $fileName);
        //On nettoie le buffer afin de l'avoir vide
        ob_end_clean();
        //On ouvre le fichier on ecriture
        $output = fopen("php://output", "w");
        $head = explode(";", "order;delivery_name;delivery_country;delivery_zipcode;delivery_city;item_index;item_id;item_quantity;line_price_exl_vat;line_price_incl_val");
        $row = explode(";", " ; ; ; ; ; ; ; ; ; ");
        //On ecrit la 1er ligne du fichier
        fputcsv($output, $head);
        if (!empty($orders)) {
            //On parcourt la liste de commandes
            foreach ($orders as $order) {
                //On rempli le tableau row par les données de chaque commande
                $row[0] = $order->getId();
                $contact = $order->getDeliverTo();
                $row[1] = $contact->getAccountName();
                $row[2] = $contact->getCountry();
                $row[3] = $contact->getZipCode();
                $row[4] = $contact->getCity();
                $salesOrderLines = $order->getSalesOrderLines();
                $i = 1;
                foreach ($salesOrderLines as $line) {
                    //On parcourt aussi chaque ligne de commandes afin de récupérer chaque article commandé
                    $article = $line->getArticle();
                    $row[5] = "$i";
                    $row[6] = $article->getId();
                    $row[7] = $line->getQuantity();
                    $row[8] = $line->getAmount();
                    $row[9] = $line->getAmount() * ($article->getVatPercentage() + 1);
                    //On ecrit le contenu de la variable row
                    fputcsv($output, $row);
                    $i++;
                }
                //fputcsv($output, $row);
            }
        }
        fclose($output);
    }
}
